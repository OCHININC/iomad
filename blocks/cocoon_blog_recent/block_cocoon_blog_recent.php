<?php

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot .'/blog/lib.php');
require_once($CFG->dirroot .'/blog/locallib.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/blog_handler/ccn_blog_handler.php');

class block_cocoon_blog_recent extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_blog_recent');
        $this->content_type = BLOCK_TYPE_TEXT;
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
    }


    function instance_allow_config() {
        return true;
    }

    /**
     * Allow multiple instances in a single course?
     *
     * @return bool True if multiple instances are allowed, false otherwise.
     */
    public function instance_allow_multiple() {
        return true;
    }

    function get_content() {
        global $CFG;

        if ($this->content !== NULL) {
            return $this->content;
        }

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

        $ccnBlogHandler = new ccnBlogHandler();
        $this->content = new stdClass();
        $this->content->footer = '';
        $this->content->text = '';
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->subtitle = '';}
        if(!empty($this->config->footer_text)){$this->content->footer_text = $this->config->footer_text;} else {$this->content->footer_text = '';}
        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;} else {$this->content->button_text = '';}
        if(!empty($this->config->button_link)){$this->content->button_link = $this->config->button_link;}else{$this->content->button_link = '/blog/index.php';}

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


        global $CFG, $OUTPUT, $PAGE;
        $bloglisting = new blog_listing();
        $limit = 10;
        $start = 0;
        $entries = $bloglisting->get_entries($start, $limit);
        if (!empty($entries)) {
            $entrieslist = array();
            $viewblogurl = new moodle_url('/blog/index.php');

$this->content->text .= '
<section class="our-blog">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="main-title text-center">
          <h3 class="mt0">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
          <p>'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-xl-6">
      <div class="blog_slider_home1 ccn-blog-slider-thumb">';
            $i = 0;
            foreach ($entries as $entryid => $entry) {
               if(($i == 2) || ($i == 3) || ($i == 4)) {

                $ccnGetPostDetails = $ccnBlogHandler->ccnGetPostDetails($entryid);
                $viewblogurl->param('entryid', $entryid);
                $entrylink = html_writer::link($viewblogurl, shorten_text($entry->subject));
                $entrieslist[] = $entrylink;

                $blogentry = new blog_entry($entryid);
                $blogattachments = $blogentry->get_attachments();


                $this->content->text .= '						<div class="item">
							<div class="blog_post one">
              <a href="'.$ccnGetPostDetails->url.'">
								<div class="thumb">
									<div class="post_title">'.get_string('events', 'theme_edumy').'</div>
									<img class="img-fluid w100" src="'.$ccnGetPostDetails->image.'" alt="'.$ccnGetPostDetails->title.'">';
                  if($PAGE->theme->settings->blog_post_date != 1){
                    $this->content->text .='<span class="post_date" href="'.$ccnGetPostDetails->url.'"><span>'. userdate($entry->created, '%d', 0) .' <br> '. userdate($entry->created, '%B', 0) .'</span></span>';
                  }
                  $this->content->text .='
								</div>
                </a>
								<div class="details">
									<div class="post_meta">
										<ul>';
                      if($PAGE->theme->settings->blog_post_date != 1){
                        $this->content->text .='<li class="ccn-white list-inline-item"><i class="flaticon-calendar"></i> '. userdate($entry->created, '%d %B %Y', 0) .'</li>';
                      }
                      if($PAGE->theme->settings->blog_post_author != 1){
                      $this->content->text .='
                      <li class="ccn-white list-inline-item"><i class="flaticon-profile"></i> '. $entry->firstname .' '. $entry->lastname.'</li>';
                      }
      							  $this->content->text .='
										</ul>
									</div>
									<a href="'.$ccnGetPostDetails->url.'"><h4>'. $ccnGetPostDetails->title.'</h4></a>
								</div>
							</div>
						</div>
';
}
$i++;

            }

$this->content->text .='</div>
				</div>';
        $j = 0;
        foreach ($entries as $entryid => $entry) {
          if(($j == 0) || ($j == 1)) {
            $viewblogurl->param('entryid', $entryid);
            $entrylink = html_writer::link($viewblogurl, shorten_text($entry->subject));
            $entrieslist[] = $entrylink;

            $blogentry = new blog_entry($entryid);
            $blogattachments = $blogentry->get_attachments();

            // print_object($entry);
            $tags = $OUTPUT->tag_list(core_tag_tag::get_item_tags('core', 'post', $entry->id));
            // print_object($tags);


            $this->content->text .= '
            <div class="col-md-6 col-lg-3 col-xl-3">
              <div class="blog_post ccn-blog-featured-thumb">
                <a href="'.$viewblogurl.'"><div class="thumb">
                  <img class="img-fluid w100" src="'.$blogattachments[0]->url.'" alt="">';
                  if($PAGE->theme->settings->blog_post_date != 1){
                    $this->content->text .='<span class="post_date">'. userdate($entry->created, '%d %B %Y', 0) .'</span>';
                  }
                $this->content->text .='
                </div></a>
                <div class="details">
                  <h5 class="ccn-white">'.$tags.'</h5>
                  <a href="'.$viewblogurl.'"><h4>'. $entry->subject.'</h4></a>
                </div>
              </div>
            </div>';
          }
          $j++;
          }
$this->content->text .= '

			</div>
			<div class="row mt50">
				<div class="col-lg-12">
					<div class="read_more_home text-center">';
          if(!empty($this->content->footer_text)){
						$this->content->text .='<h4>'.format_text($this->content->footer_text, FORMAT_HTML, array('filter' => true)).' <a href="'.format_text($this->content->button_link, FORMAT_HTML, array('filter' => true)).'">'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).'<span class="flaticon-right-arrow pl10"></span></a></h4>';
          }
          $this->content->text .='
					</div>
				</div>
			</div>
		</div>
	</section>';
        }
    }
    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }
}
