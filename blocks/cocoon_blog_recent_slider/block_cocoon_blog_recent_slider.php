<?php

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot .'/blog/lib.php');
require_once($CFG->dirroot .'/blog/locallib.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_blog_recent_slider extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_blog_recent_slider');
        $this->content_type = BLOCK_TYPE_TEXT;
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
    }


    function instance_allow_config() {
        return true;
    }

    function specialization() {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->title = 'Blog';
          $this->config->subtitle = 'Cum doctus civibus efficiantur in imperdiet deterruisset.';
          $this->config->color_bg = '#fff';
          $this->config->color_title = '#0a0a0a';
          $this->config->color_subtitle = '#6f7074';

        }

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
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->subtitle = '';}
        if(!empty($this->config->color_bg)){$this->content->color_bg = $this->config->color_bg;} else {$this->content->color_bg = '#fff';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = '#0a0a0a';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = '#6f7074';}

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

        $bloglisting = new blog_listing();

        $entries = $bloglisting->get_entries();
        $entrieslist = array();
        $viewblogurl = new moodle_url('/blog/index.php');

$this->content->text .= '
<section class="our-blog" data-ccn-c="color_bg" data-ccn-co="bg" data-ccn-cv="'.$this->content->color_bg.'">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="main-title text-center">
          <h3 class="mt0" data-ccn="title" data-ccn-c="color_title" data-ccn-cv="'.$this->content->color_title.'">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
          <p data-ccn="subtitle" data-ccn-c="color_subtitle" data-ccn-cv="'.$this->content->color_subtitle.'">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="blog_post_slider_home4">';
            foreach ($entries as $entryid => $entry) {
                $viewblogurl->param('entryid', $entryid);
                $entrylink = html_writer::link($viewblogurl, shorten_text($entry->subject));
                $entrieslist[] = $entrylink;

                $blogentry = new blog_entry($entryid);
                $blogattachments = $blogentry->get_attachments();
                $this->content->text .= '

                <div class="item">
    							<div class="blog_post_home4">
    								<a href="'.$viewblogurl.'"><div class="bph4_thumb">
    									<img class="img-fluid" src="'.$blogattachments[0]->url.'" alt="'.$entry->subject.'">';
                      if($PAGE->theme->settings->blog_post_date != 1){
                        $this->content->text .='<div class="bph4_date_meta">
    										                          <p class="year">'. userdate($entry->created, '%Y', 0) .'</p>
    										                          <p class="date">'. userdate($entry->created, '%d %B', 0) .'</p>
    									                          </div>';
                      }
                      $this->content->text .='
    								</div></a>
    								<a href="'.$viewblogurl.'">
                      <div class="details">';
                      if($PAGE->theme->settings->blog_post_author != 1){
                        $this->content->text .='
    									  <h5 data-ccn-c="color_subtitle" data-ccn-cv="'.$this->content->color_subtitle.'">'. $entry->firstname .' '. $entry->lastname.'</h5>';
                      }
                      $this->content->text .='
    									  <h4 data-ccn-c="color_title" data-ccn-cv="'.$this->content->color_title.'">'. $entry->subject.'</h4>
    									  <p data-ccn-c="color_subtitle" data-ccn-cv="'.$this->content->color_subtitle.'">'. substr(format_string($entry->summary, $striplinks = true,$options = null),0,100).'...</p>
    								  </div>
                    </a>
    							</div>
    						</div>';

            }
$this->content->text .= '
</div>
				</div>
			</div>
		</div>
	</section>';

  return $this->content;
    }
    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }
}
