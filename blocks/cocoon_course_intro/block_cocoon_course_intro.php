<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/user_handler/ccn_user_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/general_handler/ccn_video_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_course_intro extends block_base {
    public function init() { $this->title = get_string('cocoon_course_intro', 'block_cocoon_course_intro'); }
    public function specialization() {
      global $CFG;
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
    }

    public function get_content() {
        global $CFG, $DB, $COURSE, $PAGE;
        $courseid = $COURSE->id;
        $context = context_course::instance($courseid);
        require_once($CFG->libdir . '/behat/lib.php');
        require_once($CFG->libdir . '/filelib.php');

        // initialize fetch
        if(!empty($this->config->user)){
          $ccnUserHandler = new ccnUserHandler();
          $ccnUser = $ccnUserHandler->ccnGetUserDetails($this->config->user);
        }

        if(!empty($this->config->video_url)) {
          $ccnVideoHandler = new ccnVideoHandler();
          $ccnVideo = $ccnVideoHandler->ccnVideoEmbedHandler($this->config->video_url);
        }
        $ccnCourseHandler = new ccnCourseHandler();
        $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($COURSE->id);

        if ($this->content !== null) {
            return $this->content;
        }
        $this->content         =  new stdClass;

        // initialize overrides
        if(!empty($this->config->teacher)){$this->content->teacher = $this->config->teacher;}
        if(!empty($this->config->accent)){$this->content->accent = $this->config->accent;}
        if(!empty($this->config->video)){$this->content->video = $this->config->video;}
        if(!empty($this->config->video_url)){$this->content->video_url = $this->config->video_url;} else {$this->content->video_url = '';}
        if(!empty($this->config->style)){$this->content->style = $this->config->style;}
        if(!empty($this->config->show_teacher)){$this->content->show_teacher = $this->config->show_teacher;}

        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_course_intro', 'content');
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image = '<img class="thumb" src="' . $url . '" alt="' . $filename . '" />';
            }
        }

        // map data
        if(!empty($this->config->teacher)){
          $renderName = '<li class="list-inline-item"><a class="'.$white.'">'. $this->content->teacher .'</a></li>';
        } elseif(!empty($this->config->user)){
          $renderName = '<li class="list-inline-item"><a class="'.$white.'" href="'.$ccnUser->profileUrl.'">'. $ccnUser->fullname .'</a></li>';
        } else {
          $renderName = '';
        }
        if(!empty($this->config->accent)){
          $renderAccent = '<li class="list-inline-item"><a href="#"><span>'. format_text($this->content->accent, FORMAT_HTML, array('filter' => true)) .'</span></a></li>';
        } else {
          $renderAccent = '';
        }
        if(!empty($this->content->image)){
          $renderImage = '<li class="list-inline-item ccn-img-50">'. $this->content->image .'</li>';
        }elseif(!empty($this->config->user)){
          $renderImage = '<li class="list-inline-item ccn-img-50"><a href="'.$ccnUser->profileUrl.'"><img src="'.$ccnUser->rawAvatar.'"</a></li>';
        } else {
          $renderImage = '';
        }

        $cocoon_share_fb = 'https://www.facebook.com/sharer/sharer.php?u='. $this->page->url;
        $white = '';
        if($PAGE->theme->settings->course_single_style != 0){
          $white = 'color-white';
        }
        $this->content->text = '
          <div class="cs_row_one">
            <div class="cs_ins_container">
              <div class="ccn-identify-course-intro">
                <div class="cs_instructor">
                  <ul class="cs_instrct_list float-left mb0">';
                  if($this->content->show_teacher == '1'){
                    $this->content->text .= $renderImage;
                    $this->content->text .= $renderName;
                  }
                  if($PAGE->theme->settings->coursecat_modified != 1){
                    $this->content->text .='  <li class="list-inline-item"><a class="'.$white.'">'.get_string('last_updated', 'theme_edumy').' '. userdate($COURSE->timemodified, get_string('strftimedate', 'langconfig'), 0) .'</a></li>';
                  }
                  $this->content->text .='
                  </ul>
                  <ul class="cs_watch_list float-right mb0">
                    <li class="list-inline-item"><a class="'.$white.'" target="_blank" href="'.$cocoon_share_fb.'"><span class="flaticon-share"> '.get_string('share','theme_edumy').'</span></a></li>
                  </ul>
                </div>
                <h3 class="cs_title '.$white.'">'. format_text($COURSE->fullname, FORMAT_HTML, array('filter' => true)) .'</h3>
                <ul class="cs_review_seller">';
                    $this->content->text .= $renderAccent;
                    $this->content->text .= $ccnCourse->ccnRender->starRating;
                  $this->content->text .='
                </ul>';
                if($PAGE->theme->settings->coursecat_enrolments != 1 || $PAGE->theme->settings->coursecat_announcements != 1){
                $this->content->text .='<ul class="cs_review_enroll">';
                if($PAGE->theme->settings->coursecat_enrolments != 1){
                  $this->content->text .='<li class="list-inline-item"><a class="'.$white.'" href="#"><span class="flaticon-profile"></span> '. count_enrolled_users($context) .' '.get_string('students_enrolled', 'theme_edumy').'</a></li>';
                }
                if($PAGE->theme->settings->coursecat_announcements != 1){
                  $this->content->text .='<li class="list-inline-item"><a class="'.$white.'" href="#"><span class="flaticon-comment"></span> '. $ccnCourse->numberOfSections .' '.get_string('topics', 'theme_edumy').'</a></li>';
                }
                $this->content->text .='</ul>';
              }
              $this->content->text .='</div>';

              if(!empty($this->content->video_url)) {
                $this->content->text .='
                  <div class="courses_big_thumb">
                    <div class="thumb">
                      <iframe class="iframe_video" src="'.$ccnVideo.'" frameborder="0" allowfullscreen></iframe>
                    </div>
                  </div>';
              }
              $this->content->text .='
            </div>
          </div>';
        return $this->content;
    }

    public function instance_allow_multiple() {
          return true;
    }
    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('course-view'));
    }
    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }


}
