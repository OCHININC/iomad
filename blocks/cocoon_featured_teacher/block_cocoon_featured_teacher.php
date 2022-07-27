<?php
defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot. '/course/renderer.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_featured_teacher extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_cocoon_featured_teacher');
    }

    function specialization() {
        global $CFG, $DB;

        $ccnCourseHandler = new ccnCourseHandler();
        $ccnCourses = $ccnCourseHandler->ccnGetExampleCoursesIds(8);
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->title = 'Teacher of Week';
          $this->config->body = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.';
          $this->config->courses_title = 'Teacher Courses';
          $this->config->hover_text = 'Preview Course';
          $this->config->hover_accent = 'Top Seller';
          $this->config->course_image = '1';
          $this->config->description = '0';
          $this->config->price = '1';
          $this->config->enrol_btn = '0';
          $this->config->enrol_btn_text = 'Buy Now';
          $this->config->color_bfbg = 'rgba(94, 94, 94, 0)';
          $this->config->color_title = 'rgba(255,255,255,.051)';
          $this->config->color_subtitle = '#fff';
          $this->config->color_course_card = 'rgb(255, 255, 255)';
          $this->config->color_course_title = '#0a0a0a';
          $this->config->color_course_price = 'rgb(199, 85, 51)';
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


        if(!empty($this->config->user)){
          $ccnUserHandler = new ccnUserHandler();
          $ccnUser = $ccnUserHandler->ccnGetUserDetails($this->config->user);
          $ccnUserCourses = $ccnUser->teachingCoursesIds;
          $ccnUserCourses = array_slice($ccnUserCourses, 0, 20);
          $ccnCourseCount = 1;
          $ccnCourseCountMd = 1;
          if(count($ccnUserCourses) > 1){
            $ccnCourseCount = 2;
            $ccnCourseCountMd = 2;
          }
          if(count($ccnUserCourses) > 2){
            $ccnCourseCount = 3;
          }
          if(count($ccnUserCourses) > 3){
            $ccnCourseCount = 4;
          }
        }


        if(!empty($this->config->body) && strlen($this->config->body) > 2){
          $renderBio = $this->config->body;
        } elseif(!empty($this->config->user)){
          $renderBio = $ccnUser->description;
        } else {
          $renderBio = '';
        }

        $this->content = new stdClass();
        $this->content->text = '';
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->courses_title)){$this->content->courses_title = $this->config->courses_title;} else {$this->content->courses_title = '';}
        if(!empty($this->config->hover_text)){$this->content->hover_text = $this->config->hover_text;} else {$this->content->hover_text = '';}
        if(!empty($this->config->hover_accent)){$this->content->hover_accent = $this->config->hover_accent;} else {$this->content->hover_accent = '';}
        if(!empty($this->config->description)){$this->content->description = $this->config->description;} else {$this->content->description = '0';}
        if(!empty($this->config->course_image)){$this->content->course_image = $this->config->course_image;} else {$this->content->course_image = '';}
        if(!empty($this->config->price)){$this->content->price = $this->config->price;} else {$this->content->price = '1';}
        if(!empty($this->config->enrol_btn)){$this->content->enrol_btn = $this->config->enrol_btn;} else {$this->content->enrol_btn = '0';}
        if(!empty($this->config->enrol_btn_text)){$this->content->enrol_btn_text = $this->config->enrol_btn_text;} else {$this->content->enrol_btn_text = '';}
        if(!empty($this->config->color_bfbg)){$this->content->color_bfbg = $this->config->color_bfbg;} else {$this->content->color_bfbg = 'rgba(94, 94, 94, 0)';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = 'rgba(255,255,255,.051)';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = '#fff';}
        if(!empty($this->config->color_course_card)){$this->content->color_course_card = $this->config->color_course_card;} else {$this->content->color_course_card = 'rgb(255, 255, 255)';}
        if(!empty($this->config->color_course_title)){$this->content->color_course_title = $this->config->color_course_title;} else {$this->content->color_course_title = '#0a0a0a';}
        if(!empty($this->config->color_course_price)){$this->content->color_course_price = $this->config->color_course_price;} else {$this->content->color_course_price = 'rgb(199, 85, 51)';}
        if(!empty($this->config->color_course_enrol_btn)){$this->content->color_course_enrol_btn = $this->config->color_course_enrol_btn;} else {$this->content->color_course_enrol_btn = '#79b530';}

        $fs = get_file_storage();
        $ccnImages_background = $CFG->wwwroot.'/theme/edumy/images/background/10.jpg';
        $ccnImages_foreground = '';
        for ($i = 1; $i <= 2; $i++) {
          $image = 'image' . $i;
          $files = $fs->get_area_files($this->context->id, 'block_cocoon_featured_teacher', 'images', $i, 'sortorder DESC, id ASC', false, 0, 0, 1);
          if (count($files) >= 1) {
            $mainfile = reset($files);
            $mainfile = $mainfile->get_filename();
          } else {
            continue;
          }
          $ccnFileUrl = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/{$this->context->id}/block_cocoon_featured_teacher/images/" . $i . '/' . $mainfile);
          if($i === 1){
            $ccnImages_background = $ccnFileUrl;
          }
          if($i === 2){
            $ccnImages_foreground = $ccnFileUrl;
          }
        }

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
          /* */
          ($this->content->price == '1' || $this->content->enrol_btn == '1')
        ) {
          $ccnBlockShowBottomBar = 1;
          $topCoursesClass = 'ccnWithFoot';
        } else {
          $ccnBlockShowBottomBar = 0;
          $topCoursesClass = '';
        }

        $this->content->text .= '


        <section
          class="bg-img10 pb90 pt90 ovh"
          data-ccn="image1"
          data-ccn-img="bg-img-url"
          style="background-image:url('.$ccnImages_background.')"
          data-ccn-c="color_bfbg"
          data-ccn-co="ccnBfBg"
          data-ccn-cv="'.$this->content->color_bfbg.'"
          >
          <div class="container">
            <div class="main-title home12 mb-4">
              <div class="row">
                <div class="col-lg-12">
                  <h1
                    class="bg_title"
                    data-ccn="title"
                    data-ccn-c="color_title"
                    data-ccn-co="ccnCn"
                    data-ccn-cv="'.$this->content->color_title.'">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h1>
                </div>
                <div class="col-lg-7">
                  <h2
                    class="mt0 mb45"
                    data-ccn-c="color_subtitle"
                    data-ccn-co="ccnCn"
                    data-ccn-cv="'.$this->content->color_subtitle.'">'.$ccnUser->fullname.'</h2>
                  <p
                    class="mb50"
                    data-ccn="body"
                    data-ccn-c="color_subtitle"
                    data-ccn-co="ccnCn"
                    data-ccn-cv="'.$this->content->color_subtitle.'">'.$renderBio.'</p>
                  <h3
                    class="mt0 fz22"
                    data-ccn="courses_title"
                    data-ccn-c="color_subtitle"
                    data-ccn-co="ccnCn"
                    data-ccn-cv="'.$this->content->color_subtitle.'"
                    >'.format_text($this->content->courses_title, FORMAT_HTML, array('filter' => true)).'</h3>
                </div>
              </div>
            </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="teacher_course_slider">';
          if(count($ccnUserCourses) == 0){
            $this->content->text .= '<p
                                      data-ccn-c="color_subtitle"
                                      data-ccn-co="ccnCn"
                                      data-ccn-cv="'.$this->content->color_subtitle.'">This teacher doesn\'t have any courses yet.</p>';
          }
          foreach ($ccnUserCourses as $course) {
            if ($DB->record_exists('course', array('id' => $course))) {

              $ccnCourseHandler = new ccnCourseHandler();
              $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($course);

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

              $ccnCourseDescription = $ccnCourseHandler->ccnGetCourseDescription($course, $maxlength);

              $this->content->text .='
              <div class="item">
                <div
                  class="top_courses home2 mb0 '.$topCoursesClass.'"
                  data-ccn-c="color_course_card"
                  data-ccn-co="ccnBg, ccnBd"
                  data-ccn-cv="'.$this->content->color_course_card.'"
                >';
                if($ccnBlockShowImg){
                  $this->content->text .='
                  <div class="thumb">
                    '.$ccnCourse->ccnRender->coverImage.'
                    <a class="overlay" href="'. $ccnCourse->url .'">';
                    if($this->content->hover_accent){
                     $this->content->text .='<div class="tag" data-ccn="hover_accent">'.format_text($this->content->hover_accent, FORMAT_HTML, array('filter' => true)).'</div>';
                   }
                   if($this->content->hover_text){
                    $this->content->text .='  <div class="tc_preview_course" data-ccn="hover_text" href="'. $ccnCourse->url .'">'.format_text($this->content->hover_text, FORMAT_HTML, array('filter' => true)).'</div>';
                   }
                    $this->content->text .='
                    </a>
                  </div>';
                }
                $this->content->text .='
                  <div class="details">
                    <div class="tc_content">';
                    $this->content->text .= $ccnCourse->ccnRender->updatedDate;
                    $this->content->text .=  '<a href="'.$ccnCourse->url.'">
                                                <h5
                                                  data-ccn-c="color_course_title"
                                                  data-ccn-co="ccnCn"
                                                  data-ccn-cv="'.$this->content->color_course_title.'">'.$ccnCourse->fullName.'</h5>
                                              </a>';
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
                        $this->content->text .='<a
                                                  href="'.$ccnCourse->enrolmentLink.'"
                                                  class="tc_enrol_btn data-ccn="enrol_btn_text" float-right"
                                                  data-ccn-co="ccnCn"
                                                  data-ccn-c="color_course_enrol_btn"
                                                  data-ccn-cv="'.$this->content->color_course_enrol_btn.'"
                                                  >'.format_text($this->content->enrol_btn_text, FORMAT_HTML, array('filter' => true)).'</a>';
                      }
                      if($ccnBlockShowPrice){
                        $this->content->text .= '<div
                                                  class="tc_price float-right"
                                                  data-ccn-c="color_course_price"
                                                  data-ccn-co="ccnCn"
                                                  data-ccn-cv="'.$this->content->color_course_price.'">'.$ccnCourse->price.'</div>';
                      }
                      $this->content->text .='
                    </div>';
                  }
                  $this->content->text .='
                </div>
              </div>';
            }
          }
          $this->content->text .='
        </div>
      </div>';
      if($ccnImages_foreground !== ''){
        $this->content->text .='
        <div class="col-lg-12">
          <div class="teacherimg">
            <img src="'.$ccnImages_foreground.'" alt="" data-ccn="image2" data-ccn="content">
          </div>
        </div>';
      }
      $this->content->text .='
    </div>
  </div>
</section>
  <script type="text/javascript">
  (function($){

      if($(".teacher_course_slider").length){
          $(".teacher_course_slider").owlCarousel({
              center:true,
              loop:true,
              margin:15,
              dots:true,
              nav:false,
              rtl:false,
              autoplayHoverPause:false,
              autoplay: true,
              singleItem: true,
              smartSpeed: 2000,
              navText: [
                \'<i class="flaticon-left-arrow"></i>\',
                \'<i class="flaticon-right-arrow-1"></i>\'
              ],
              responsive: {
                  0: {
                      items: 1,
                      center: false
                  },
                  480:{
                      items:1,
                      center: false
                  },
                  520:{
                      items:1,
                      center: false
                  },
                  600: {
                      items: 1,
                      center: false
                  },
                  768: {
                      items: 2,
                      center: false
                  },
                  992: {
                      items: 3,
                      center: false
                  },
                  1200: {
                      items: 4,
                      center: false
                  },
                  1366: {
                      items: 4,
                      center: false
                  },
                  1400: {
                      items: 4,
                      center: false
                  }
              }
          })
      }

  }(jQuery));
  </script>

';

        return $this->content;
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
    }

    function instance_config_save($data, $nolongerused = false) {
      global $CFG;
      $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                  'subdirs'       => 0,
                                  'maxfiles'      => 1,
                                  'accepted_types' => array('.jpg', '.png', '.gif'));

      for($i = 1; $i <= 2; $i++) {
        $field = 'image' . $i;
        if (!isset($data->$field)) {
          continue;
        }
        file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_featured_teacher', 'images', $i, $filemanageroptions);
      }
      parent::instance_config_save($data, $nolongerused);
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
