<?php

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot. '/course/renderer.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_my_courses extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_cocoon_my_courses');
    }

    public function get_content() {
        global $CFG, $PAGE, $USER, $DB;

        if (isset($PAGE->theme->settings->course_enrolment_payment) && ($PAGE->theme->settings->course_enrolment_payment == 1)) {
          $paymentForced = false;
        } else {
          $paymentForced = true;
        }

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';
        $this->content->text = '';

        if (isloggedin() && !isguestuser()) {


        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;}
        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;}
        if(!empty($this->config->button_link)){$this->content->button_link = $this->config->button_link;}
        if(!empty($this->config->hover_text)){$this->content->hover_text = $this->config->hover_text;}
        if(!empty($this->config->hover_accent)){$this->content->hover_accent = $this->config->hover_accent;}
        if(!empty($this->config->description)){$this->content->description = $this->config->description;}
        if(!empty($this->config->course_image)){$this->content->course_image = $this->config->course_image;}
        if(!empty($this->config->price)){$this->content->price = $this->config->price;}
        if(!empty($this->config->enrol_btn)){$this->content->enrol_btn = $this->config->enrol_btn;}
        if(!empty($this->config->enrol_btn_text)){$this->content->enrol_btn_text = $this->config->enrol_btn_text;}

        if(
          isset($this->content->description) &&
          $this->content->description != '0'
        ) {
          $ccnBlockShowDesc = 1;
        } else {
          $ccnBlockShowDesc = 0;
        }

        if(
          isset($this->content->course_image) &&
          $this->content->course_image == '1'
        ){
          $ccnBlockShowImg = 1;
        } else {
          $ccnBlockShowImg = 0;
        }
        if(
          isset($this->content->enrol_btn) &&
          isset($this->content->enrol_btn_text) &&
          $this->content->enrol_btn == '1'
        ) {
          $ccnBlockShowEnrolBtn = 1;
        } else {
          $ccnBlockShowEnrolBtn = 0;
        }
        if(
          isset($this->content->price) &&
          $this->content->price == '1'
        ) {
          $ccnBlockShowPrice = 1;
        } else {
          $ccnBlockShowPrice = 0;
        }

        if(
          $PAGE->theme->settings->coursecat_enrolments != 1 ||
          $PAGE->theme->settings->coursecat_announcements != 1 ||
          isset($this->content->price) ||
          isset($this->content->enrol_btn_text) &&
          // ccnBreak
          ($this->content->price == '1' || $this->content->enrol_btn == '1')
        ) {
          $ccnBlockShowBottomBar = 1;
          $topCoursesClass = 'ccnWithFoot';
        } else {
          $ccnBlockShowBottomBar = 0;
          $topCoursesClass = '';
        }



        $courses = enrol_get_all_users_courses($USER->id);
        $total_courses = count($courses);
        if($total_courses < 2) {
          $topColumnClass = 'col-md-12';
          $col_class = 'col-md-6 offset-md-3 col-xl-4 offset-xl-4';
        } else if($total_courses == 2) {
          $topColumnClass = 'col-sm-8 offset-sm-2 col-md-12 offset-md-0 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2';
          $col_class = 'col-md-6';
        } else if($total_courses == 3) {
          $topColumnClass = 'col-sm-8 offset-sm-2 col-md-12 offset-md-0 col-xl-10 offset-xl-1';
          $col_class = 'col-md-6 col-lg-4';
        } else  {
          $topColumnClass = 'col-xs-12';
          $col_class = 'col-md-6 col-lg-4 col-xl-3';
        }

        $this->content->text .= '


<section class="our-courses">
<div class="container">
        <div class="row">
    <div class="col-lg-6 offset-lg-3">
    <div class="main-title text-center">';
    if(!empty($this->content->title)){
      $this->content->text .='<h3 class="mt0">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>';
    }
    if(!empty($this->content->subtitle)){
     $this->content->text .='<p>'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
   }
    $this->content->text .='
    </div></div>
</div>
<div class="row">
<div class="'.$topColumnClass.'">
<div class="row">
';




        $chelper = new coursecat_helper();
        foreach ($courses as $course) {
          if ($DB->record_exists('course', array('id' => $course->id))) {

            $ccnCourseHandler = new ccnCourseHandler();
            $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($course->id);

            if(!empty($this->content->description) && $this->content->description == '7'){
              $maxlength = 500;
            } elseif(!empty($this->content->description) && $this->content->description == '6'){
              $maxlength = 350;
            } elseif(!empty($this->content->description) && $this->content->description == '5'){
              $maxlength = 200;
            } elseif(!empty($this->content->description) && $this->content->description == '4'){
              $maxlength = 150;
            } elseif(!empty($this->content->description) && $this->content->description == '3'){
              $maxlength = 100;
            } elseif(!empty($this->content->description) && $this->content->description == '2'){
              $maxlength = 50;
            } else {
              $maxlength = null;
            }
            $ccnCourseDescription = $ccnCourseHandler->ccnGetCourseDescription($course->id, $maxlength);








            $this->content->text .='

            <div class="'.$col_class.'">
							<div class="top_courses '.$topCoursesClass.'">
              <a href="'. $ccnCourse->url .'">';
              if($ccnBlockShowImg){
								$this->content->text .='
                <div class="thumb">
									'.$ccnCourse->ccnRender->coverImage.'
									<div class="overlay">';
                  if($this->content->hover_accent){
										$this->content->text .='<div class="tag">'.format_text($this->content->hover_accent, FORMAT_HTML, array('filter' => true)).'</div>';
                  }
                  if($this->content->hover_text){
										$this->content->text .='<span class="tc_preview_course">'.format_text($this->content->hover_text, FORMAT_HTML, array('filter' => true)).'</span>';
                  }
                  $this->content->text .='
									</div>
								</div>';
              }
              $this->content->text .='
								<div class="details">
									<div class="tc_content">';

                $this->content->text .= $ccnCourse->ccnRender->updatedDate;
                $this->content->text .=  $ccnCourse->ccnRender->title;
                if($ccnBlockShowDesc){
                  $this->content->text .='<p>'.$ccnCourseDescription.'</p>';
                }
                $this->content->text .= $ccnCourse->ccnRender->starRating;


                  $this->content->text .='
									</div>
                  </div>';
                  if($ccnBlockShowBottomBar == 1){
                    $this->content->text .='
									<div class="tc_footer">
										<ul class="tc_meta float-left">'.$ccnCourse->ccnRender->enrolmentIcon . $ccnCourse->ccnRender->announcementsIcon.'</ul>';

                    if($ccnBlockShowEnrolBtn){
                      $this->content->text .='<a href="'.$ccnCourse->enrolmentLink.'" class="tc_enrol_btn float-right">'.$this->content->enrol_btn_text.'</a>';
                    }
                    if($ccnBlockShowPrice){
                      $this->content->text .= '<div class="tc_price float-right">'.$ccnCourse->price.'</div>';
                    }


                    $this->content->text .='
									</div>';
                }
               $this->content->text .='
								</a>
							</div>
						</div>


            ';
          }
        }


        $this->content->text .= '
        		</div></div></div></div></section>

        ';


      } else {
        $this->content->text = '';
      }




        return $this->content;
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
    }

    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }


    public function instance_allow_multiple() {
          return false;
    }

    public function has_config() {
        return false;
    }

    public function cron() {
        return true;
    }


}
