<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file contains the news item block class, based upon block_base.
 *
 * @package    block_cocoon_mynews
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Class block_cocoon_mynews
 *
 * @package    block_cocoon_mynews
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_mynews extends block_base {
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_mynews');
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('my'));
    }

    function get_content() {
        global $CFG, $USER;

        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new \stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        if (empty($this->instance)) {
            return $this->content;
        }


        if ($this->page->course->newsitems) {   // Create a nice listing of recent postings

            require_once($CFG->dirroot.'/mod/forum/lib.php');   // We'll need this

            $text = '<div class="recent_job_activity">';

            if (!$forum = forum_get_course_forum($this->page->course->id, 'news')) {
                return '';
            }

            $modinfo = get_fast_modinfo($this->page->course);
            if (empty($modinfo->instances['forum'][$forum->id])) {
                return '';
            }
            $cm = $modinfo->instances['forum'][$forum->id];

            if (!$cm->uservisible) {
                return '';
            }

            $context = context_module::instance($cm->id);

        /// User must have perms to view discussions in that forum
            if (!has_capability('mod/forum:viewdiscussion', $context)) {
                return '';
            }


            // $text .= '<h4 class="title">'. get_string('notifications', 'theme_edumy').'</h4>';
        /// First work out whether we can post to this group and if so, include a link
            $groupmode    = groups_get_activity_groupmode($cm);
            $currentgroup = groups_get_activity_group($cm, true);

            if (forum_user_can_post_discussion($forum, $currentgroup, $groupmode, $cm, $context)) {
                $text .= '<div class="mb15">
                            <a class="btn btn-primary btn-sm" href="'.$CFG->wwwroot.'/mod/forum/post.php?forum='.$forum->id.'">'.get_string('addanewtopic', 'forum').'</a>
                          </div>';
            }

        /// Get all the recent discussions we're allowed to see

            // This block displays the most recent posts in a forum in
            // descending order. The call to default sort order here will use
            // that unless the discussion that post is in has a timestart set
            // in the future.
            // This sort will ignore pinned posts as we want the most recent.
            $sort = forum_get_default_sort_order(true, 'p.modified', 'd', false);
            if (! $discussions = forum_get_discussions($cm, $sort, false,
                                                        -1, $this->page->course->newsitems,
                                                        false, -1, 0, FORUM_POSTS_ALL_USER_GROUPS) ) {
                $text .= '('.get_string('nonews', 'forum').')';
                // $this->content->text = $text;
                // return $this->content;
            }

        /// Actually create the listing now

            $strftimerecent = get_string('strftimerecent');
            $strmore = get_string('more', 'forum');

        /// Accessibility: markup as a list.
            // $text .= "\n<ul class='unlist'>\n";
            foreach ($discussions as $discussion) {

                $discussion->subject = $discussion->name;

                $discussion->subject = format_string($discussion->subject, true, $forum->course);
                //
                // $text .= '<li class="post">'.
                //          '<div class="head clearfix">'.
                //          '<div class="date">'.userdate($discussion->modified, $strftimerecent).'</div>'.
                //          '<div class="name">'.fullname($discussion).'</div></div>'.
                //          '<div class="info"><a href="'.$CFG->wwwroot.'/mod/forum/discuss.php?d='.$discussion->discussion.'">'.$discussion->subject.'</a></div>'.
                //          "</li>\n";

                         $text .= '								<div class="grid">
									<ul>
										<li><div class="title"><a href="'.$CFG->wwwroot.'/mod/forum/discuss.php?d='.$discussion->discussion.'">'. $discussion->subject .'</a></div></li>
										<li><p>'.fullname($discussion).' <small>'.userdate($discussion->modified, $strftimerecent).'</small></p></li>
									</ul>
								</div>
';
            }
            // $text .= "</ul>\n";


            $text .= '<div class="mt15"><a class="view_all_noti text-thm" href="'.$CFG->wwwroot.'/mod/forum/view.php?f='.$forum->id.'">'.get_string('oldertopics', 'forum').'</a></div>';

        /// If RSS is activated at site and forum level and this forum has rss defined, show link
            if (isset($CFG->enablerssfeeds) && isset($CFG->forum_enablerssfeeds) &&
                $CFG->enablerssfeeds && $CFG->forum_enablerssfeeds && $forum->rsstype && $forum->rssarticles) {
                require_once($CFG->dirroot.'/lib/rsslib.php');   // We'll need this
                if ($forum->rsstype == 1) {
                    $tooltiptext = get_string('rsssubscriberssdiscussions','forum');
                } else {
                    $tooltiptext = get_string('rsssubscriberssposts','forum');
                }
                if (!isloggedin()) {
                    $userid = $CFG->siteguest;
                } else {
                    $userid = $USER->id;
                }

                $this->content->footer .= '<br />'.rss_get_link($context->id, $userid, 'mod_forum', $forum->id, $tooltiptext);
            }

            $text .= '</div>';

            $this->content->text = $text;

        }


        return $this->content;
    }
}
