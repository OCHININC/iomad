<?php

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot .'/blog/lib.php');
require_once($CFG->dirroot .'/blog/locallib.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_blog_recent_list extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_blog_recent_list');
        $this->content_type = BLOCK_TYPE_TEXT;
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
    }


    function instance_allow_config() {
        return true;
    }

    function get_content() {
        global $CFG, $PAGE;

        if ($this->content !== NULL) {
            return $this->content;
        }

        // verify blog is enabled
        if (empty($CFG->enableblogs)) {
            $this->content = new stdClass();
            $this->content->text = '';
            if ($this->page->user_is_editing()) {
                $this->content->text = get_string('blogdisable', 'blog');
            }
            return $this->content;

        } else if ($CFG->bloglevel < BLOG_GLOBAL_LEVEL and (!isloggedin() or isguestuser())) {
            $this->content = new stdClass();
            $this->content->text = '';
            return $this->content;
        }



        if (empty($this->config)) {
            $this->config = new stdClass();
        }

        if (empty($this->config->recentbloginterval)) {
            $this->config->recentbloginterval = 8400;
        }

        if (empty($this->config->numberofrecentblogentries)) {
            $this->config->numberofrecentblogentries = 4;
        }

        $this->content = new stdClass();
        $this->content->footer = '';
        $this->content->text = '';
        if(!empty($this->config->title)){$this->content->title = $this->config->title;}

        $context = $this->page->context;

        $url = new moodle_url('/blog/index.php');
        $filter = array();
        if ($context->contextlevel == CONTEXT_MODULE) {
            $filter['module'] = $context->instanceid;
            $a = new stdClass;
            $a->type = get_string('modulename', $this->page->cm->modname);
            $strview = get_string('viewallmodentries', 'blog', $a);
            $url->param('modid', $context->instanceid);
        } else if ($context->contextlevel == CONTEXT_COURSE) {
            $filter['course'] = $context->instanceid;
            $a = new stdClass;
            $a->type = get_string('course');
            $strview = get_string('viewblogentries', 'blog', $a);
            $url->param('courseid', $context->instanceid);
        } else {
            $strview = get_string('viewsiteentries', 'blog');
        }
        $filter = null;


        global $CFG;
        $bloglisting = new blog_listing();

        $entries = $bloglisting->get_entries();
       // if (!empty($entries)) {
            $entrieslist = array();
            $viewblogurl = new moodle_url('/blog/index.php');

            $this->content->text .= '
            <div class="blog_recent_post_widget media_widget">
              <h4 class="title">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h4>';
              foreach ($entries as $entryid => $entry) {
                $viewblogurl->param('entryid', $entryid);
                $entrylink = html_writer::link($viewblogurl, shorten_text($entry->subject));
                $entrieslist[] = $entrylink;

                $blogentry = new blog_entry($entryid);
                $blogattachments = $blogentry->get_attachments();
                $this->content->text .= '

                <div class="media">
                  <div class="ccn-img-surround">
                    <a href="'.$viewblogurl.'">
                      <img class="align-self-start mr-3" src="'.$blogattachments[0]->url.'" alt="'.$entry->subject.'">
                    </a>
                  </div>
                  <div class="media-body">
                    <a href="'.$viewblogurl.'">
                      <h5 class="mt-0 post_title">'. format_text($entry->subject, FORMAT_HTML, array('filter' => true)).'</h5>
                    </a>';
                    if($PAGE->theme->settings->blog_post_date != 1){
                      $this->content->text .='<a href="'.$viewblogurl.'">'. userdate($entry->created, '%d %B', 0) .'</a>';
                    }
                    $this->content->text .='
                  </div>
                </div>';
              }
            $this->content->text .= '
              </div>';



       /* } else {
            $this->content->text .= get_string('norecentblogentries', 'block_cocoon_blog_recent_list');
        } */
    }

    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }
}
