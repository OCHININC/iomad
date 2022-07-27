<?php
defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot. '/course/renderer.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_course_grid_4 extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_cocoon_course_grid_4');
    }

    function specialization() {
        global $CFG, $DB;

        $ccnCourseHandler = new ccnCourseHandler();
        $ccnCourses = $ccnCourseHandler->ccnGetExampleCoursesIds(8);

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->title = 'Browse Our Top Courses';
          $this->config->subtitle = 'Cum doctus civibus efficiantur in imperdiet deterruisCum doctus civibus efficiantur in imperdiet deterruisset.';
          $this->config->hover_text = 'Preview Course';
          $this->config->hover_accent = 'Top Seller';
          $this->config->button_text = 'View all courses';
          $this->config->button_link = $CFG->wwwroot . '/course';
          $this->config->course_image = '1';
          $this->config->description = '0';
          $this->config->price = '1';
          $this->config->enrol_btn = '0';
          $this->config->enrol_btn_text = 'Buy Now';
          $this->config->courses = $ccnCourses;
          $this->config->group = '1';
          $this->config->color_bg = 'rgb(0, 8, 70)';
          $this->config->color_title = 'rgb(255,255,255)';
          $this->config->color_subtitle = 'rgb(255,255,255)';
          $this->config->color_course_title = 'rgb(255,255,255)';
          $this->config->color_course_subtitle = 'rgb(255, 234, 193)';
          $this->config->color_course_price = 'rgb(255, 0, 95)';
          $this->config->color_button = 'rgb(255, 0, 95)';
          $this->config->color_course_enrol_btn = '#79b530';
        }
    }

    public function get_content() {
        global $CFG, $DB, $COURSE, $USER, $PAGE;

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        // if (isset($PAGE->theme->settings->course_enrolment_payment) && ($PAGE->theme->settings->course_enrolment_payment == 1)) {
        //   $paymentForced = false;
        // } else {
        //   $paymentForced = true;
        // }

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';
        $this->content->text = '';
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->subtitle = '';}
        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;} else {$this->content->button_text = '';}
        if(!empty($this->config->button_link)){$this->content->button_link = $this->config->button_link;} else {$this->content->button_link = '';}
        if(!empty($this->config->hover_text)){$this->content->hover_text = $this->config->hover_text;} else {$this->content->hover_text = '';}
        if(!empty($this->config->hover_accent)){$this->content->hover_accent = $this->config->hover_accent;} else {$this->content->hover_accent = '';}
        if(!empty($this->config->description)){$this->content->description = $this->config->description;} else {$this->content->description = '0';}
        if(!empty($this->config->course_image)){$this->content->course_image = $this->config->course_image;} else {$this->content->course_image = '';}
        if(!empty($this->config->price)){$this->content->price = $this->config->price;} else {$this->content->price = '1';}
        if(!empty($this->config->enrol_btn)){$this->content->enrol_btn = $this->config->enrol_btn;} else {$this->content->enrol_btn = '0';}
        if(!empty($this->config->enrol_btn_text)){$this->content->enrol_btn_text = $this->config->enrol_btn_text;} else {$this->content->enrol_btn_text = '';}


        if(!empty($this->config->color_bg)){$this->content->color_bg = $this->config->color_bg;} else {$this->content->color_bg = 'rgb(244, 245, 247)';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = 'rgb(255,255,255)';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = 'rgb(255,255,255)';}
        if(!empty($this->config->color_course_title)){$this->content->color_course_title = $this->config->color_course_title;} else {$this->content->color_course_title = 'rgb(255,255,255)';}
        if(!empty($this->config->color_course_subtitle)){$this->content->color_course_subtitle = $this->config->color_course_subtitle;} else {$this->content->color_course_subtitle = 'rgb(255, 234, 193)';}
        if(!empty($this->config->color_course_price)){$this->content->color_course_price = $this->config->color_course_price;} else {$this->content->color_course_price = 'rgb(255, 0, 95)';}
        if(!empty($this->config->color_button)){$this->content->color_button = $this->config->color_button;} else {$this->content->color_button = 'rgb(255, 0, 95)';}
        if(!empty($this->config->color_course_enrol_btn)){$this->content->color_course_enrol_btn = $this->config->color_course_enrol_btn;} else {$this->content->color_course_enrol_btn = '#79b530';}



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
          (isset($this->content->price) && $this->content->price == '1') ||
          (isset($this->content->enrol_btn_text) && $this->content->enrol_btn == '1')
        ) {
          $ccnBlockShowBottomBar = 1;
          $topCoursesClass = 'ccnWithFoot';
        } else {
          $ccnBlockShowBottomBar = 0;
          $topCoursesClass = '';
        }

        if(!empty($this->config->group)){
          $filter = $this->config->group;
          $ccnClassMasonry_cont = 'ccn-masonry-grid-1';
          $ccnClassMasonry_opts = 'ccn-masonry-options';
          $ccnClassMasonry_grid = 'ccn-masonry-grid';
        } else {
          $filter = null;
          $ccnClassMasonry_cont = '';
          $ccnClassMasonry_opts = '';
          $ccnClassMasonry_grid = '';
        }
        if(!empty($this->config->courses)){
          $coursesArr = $this->config->courses;
          $courses = new stdClass();
          foreach ($coursesArr as $key => $course) {
            $courseObj = new stdClass();
            $courseObj->id = $course;
            $courseRecord = $DB->get_record('course', array('id' => $courseObj->id), 'category');
            $courseCategory = $DB->get_record('course_categories',array('id' => $courseRecord->category));
            $courseCategory = core_course_category::get($courseCategory->id);
            $courseObj->category = $courseCategory->id;
            $courseObj->category_name = $courseCategory->get_formatted_name();
            $courses->$course = $courseObj;
          }
          $categories = array();
          foreach ($courses as $key => $course) {
            $categories[$course->category] = $course->category_name;
          }
          $categories = array_unique($categories);
        }



        $this->content->text .= '
        <section id="our-top-courses" class="'.$ccnClassMasonry_cont.' our-courses ccn-courses-grid-block ccn-courses-grid-block-4" data-ccn-c="color_bg" data-ccn-co="bg" style="background-color: '.$this->content->color_bg.';">
          <div class="container">
          <div class="row">
            <div class="col-lg-6">
              <div class="main-title mb-4">';
              if(!empty($this->content->title)){
                $this->content->text .='<h3 class="mt0" data-ccn="title" data-ccn-c="color_title" data-ccn-cv="'.$this->content->color_title.'">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>';
              }
              if(!empty($this->content->subtitle)){
                $this->content->text .='	 <p data-ccn="subtitle" data-ccn-c="color_subtitle" data-ccn-cv="'.$this->content->color_subtitle.'">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
              }
               $this->content->text .='
              </div>
            </div>
            <div class="col-lg-6">
              <div class="ccn-section-top-more pull-right mt0 mb20">';
              if($filter == 1){
                $this->content->text .= '
                <div id="options" class="'.$ccnClassMasonry_opts.' alpha-pag full">
                  <div class="option-isotop">
                    <ul id="filter" class="option-set" data-option-key="filter">
                      <li class="list-inline-item"><a data-ccn-c="color_title" data-ccn-cv="'.$this->content->color_title.'" href="#all" data-option-value="*" class="selected ccnLcEl--br--i">'.get_string('all').'</a></li>';
                      foreach ($categories as $key => $category) {
                        $key = 'cat-'.$key;
                        $this->content->text .='<li class="list-inline-item"><a class="ccnLcEl--br--i" data-ccn-c="color_title" data-ccn-cv="'.$this->content->color_title.'" href="#'.$key.'" data-option-value=".'.$key.'">'.$category.'</a></li>';
                      }
                      $this->content->text .='
                    </ul>
                  </div>
                </div><!-- /#options -->';
              }
              $this->content->text .='
              </div>
            </div>
          </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">';
              if($filter == 1){
              $this->content->text .='
              <div class="emply-text-sec">';
              }
              $this->content->text .='
                  <div class="row '.$ccnClassMasonry_grid.' id="'.$coursesContainerClass.'">';

        // $courses = self::get_featured_courses();
        // print_object($courses);
        // $courses = null;
      if(!empty($this->config->courses)){
        $chelper = new coursecat_helper();
        $total_courses = count($coursesArr);

        if($total_courses < 2) {
          $col_class = 'col-md-12';
        } else if($total_courses == 2) {
          $col_class = 'col-md-6';
        } else if($total_courses == 3) {
          $col_class = 'col-md-4';
        } else  {
          $col_class = 'col-md-6 col-lg-4 col-xl-3';
        }

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

            <div class="'.$col_class.' cat-'.$course->category.'">
							<div class="top_courses '.$topCoursesClass.'">';
								if($ccnBlockShowImg){
                  $this->content->text .='
                  <a href="'. $ccnCourse->url .'"><div class="thumb">
									'.$ccnCourse->ccnRender->coverImage.'
									<div class="overlay">';
										if($this->content->hover_accent){
                     $this->content->text .=' <div class="tag" data-ccn="hover_accent">'.format_text($this->content->hover_accent, FORMAT_HTML, array('filter' => true)).'</div>';
                    }
                    if($this->content->hover_text){
                     $this->content->text .='<span class="tc_preview_course" data-ccn="hover_text">'.format_text($this->content->hover_text, FORMAT_HTML, array('filter' => true)).'</span>';
                    }
										$this->content->text .='
									</div>
								</div></a>';
              }
              $this->content->text .='
								<div class="details">
									<div class="tc_content">';
                  $this->content->text .= '<span data-ccn-c="color_course_subtitle" data-ccn-cv="'.$this->content->color_course_subtitle.'">'.$ccnCourse->ccnRender->updatedDate.'</span>';
                  $this->content->text .=  '<a href="'.$ccnCourse->url.'"><h5 data-ccn-c="color_course_title" data-ccn-co="content" style="color: '.$this->content->color_course_title.';">'.$ccnCourse->fullName.'</h5></a>';
                  if($ccnBlockShowDesc){
                    $this->content->text .='<p data-ccn-c="color_course_title" data-ccn-cv="'.$this->content->color_course_title.'">'.$ccnCourseDescription.'</p>';
                  }
                  $this->content->text .= '<div data-ccn-c="color_course_title" data-ccn-cv="'.$this->content->color_course_title.'">'.$ccnCourse->ccnRender->starRating.'</div>';
                  $this->content->text .='
									</div>
                  </div>';
                  if($ccnBlockShowBottomBar == 1){
                  $this->content->text .='
                  <div class="tc_footer" data-ccn-c="color_course_title" data-ccn-cv="'.$this->content->color_course_title.'">
									<ul class="tc_meta float-left">'.$ccnCourse->ccnRender->enrolmentIcon . $ccnCourse->ccnRender->announcementsIcon.'</ul>';
                   if($ccnBlockShowEnrolBtn){
                     $this->content->text .='<a data-ccn-co="content" data-ccn-c="color_course_enrol_btn" style="color: '.$this->content->color_course_enrol_btn.';" href="'.$ccnCourse->enrolmentLink.'" class="tc_enrol_btn float-right">'.format_text($this->content->enrol_btn_text, FORMAT_HTML, array('filter' => true)).'</a>';
                   }
                   if($ccnBlockShowPrice){
                     $this->content->text .= '<div class="tc_price float-right" data-ccn="course_price" data-ccn-co="content" data-ccn-c="color_course_price" style="color: '.$this->content->color_course_price.';">'.$ccnCourse->price.'</div>';
                   }
                    $this->content->text .='
									</div>';
                   }
                $this->content->text .='
							</div>
						</div>';
          }
        }
      }

        $this->content->text .='
 			</div>';

      if($filter == 1){
        $this->content->text .= '
</div>';
}
$this->content->text .='
        </div></div>';

      if(!empty($this->content->button_text) && !empty($this->content->button_link)){
      $this->content->text .='
      <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="courses_all_btn text-center">
          <a class="btn btn-transparent ccnLcEl--i" data-ccn="button_text" data-ccn-c="color_button" data-ccn-cv="'.$this->content->color_button.'" href="'.format_text($this->content->button_link, FORMAT_HTML, array('filter' => true)).'">'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).'</a>
        </div>
      </div></div>'  ;
      }
$this->content->text .='

		</div>
	</section>

';

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
