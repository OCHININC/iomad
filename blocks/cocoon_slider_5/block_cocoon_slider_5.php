<?php
defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot. '/course/renderer.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_slider_5 extends block_base {

    /**
     * Start block instance.
     */
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_slider_5');
    }

    /**
     * The block is usable in all pages
     */
    function applicable_formats() {
        $ccnBlockHandler = new ccnBlockHandler();
        return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
    }

    /**
     * Customize the block title dynamically.
     */
    function specialization() {
        global $CFG, $DB;

        $ccnCourseHandler = new ccnCourseHandler();
        $ccnCourses = $ccnCourseHandler->ccnGetExampleCourses(3);
        // print_object($ccnCourses[0]->courseId);

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->slidesnumber = '3';
          $this->config->course1 = $ccnCourses[0]->courseId;
          $this->config->course2 = $ccnCourses[1]->courseId;
          $this->config->course3 = $ccnCourses[2]->courseId;
          $this->config->slide_title1 = 'Learn From';
          $this->config->slide_title_21 = 'Anywhere';
          $this->config->slide_title_22 = 'Anywhere';
          $this->config->slide_title_23 = 'Anywhere';
          $this->config->slide_accent1 = 'Top Seller';
          $this->config->slide_accent2 = 'Top Seller';
          $this->config->slide_accent3 = 'Top Seller';
          $this->config->slide_subtitle1 = 'Technology is brining a massive wave of evolution on learning things on different ways.';
          // $this->config->slide_btn_text1 = 'Ready to Get Started?';
          // $this->config->slide_btn_url1 = '#';
          // $this->config->file_slide1 = $CFG->wwwroot.'/theme/edumy/images/home/1.jpg';
          // $this->config->file_slide2 = $CFG->wwwroot.'/theme/edumy/images/home/1.jpg';
          // $this->config->file_slide3 = $CFG->wwwroot.'/theme/edumy/images/home/1.jpg';
          $this->config->slide_title2 = 'Learn From';
          $this->config->slide_subtitle2 = 'Technology is brining a massive wave of evolution on learning things on different ways.';
          // $this->config->slide_btn_text2 = 'Ready to Get Started?';
          // $this->config->slide_btn_url2 = '#';
          $this->config->slide_title3 = 'Learn From';
          $this->config->slide_subtitle3 = 'Technology is brining a massive wave of evolution on learning things on different ways.';
          // $this->config->slide_btn_text3 = 'Ready to Get Started?';
          // $this->config->slide_btn_url3 = '#';
          $this->config->prev_1 = 'PR';
          $this->config->prev_2 = 'EV';
          $this->config->next_1 = 'NE';
          $this->config->next_2 = 'XT';
        }
    }

    /**
     * The block can be used repeatedly in a page.
     */
    function instance_allow_multiple() {
        return false;
    }

    /**
     * Build the block content.
     */
    function get_content() {
        global $CFG, $PAGE, $COURSE, $DB;

        require_once($CFG->libdir . '/filelib.php');


        if ($this->content !== NULL) {
            return $this->content;
        }

        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 3;
        } else {
            $data = new stdClass();
            $data->slidesnumber = '3';
        }

        $this->content = new stdClass();
        if(!empty($this->config->prev_1)){$this->content->prev_1 = $this->config->prev_1;}
        if(!empty($this->config->prev_2)){$this->content->prev_2 = $this->config->prev_2;}
        if(!empty($this->config->next_1)){$this->content->next_1 = $this->config->next_1;}
        if(!empty($this->config->next_2)){$this->content->next_2 = $this->config->next_2;}
        if(!empty($this->config->prev)){$this->content->prev = $this->config->prev;}
        if(!empty($this->config->next)){$this->content->next = $this->config->next;}
        if(!empty($this->config->arrow_style)){$this->content->arrow_style = $this->config->arrow_style;}

        $text = '';
        $bannerstyle = '';
        if ($data->slidesnumber > 1) {
          $bannerstyle .= 'banner-style-one--multiple';
        } else {
          $bannerstyle .= 'banner-style-one--single';
        }

        if ($data->slidesnumber > 0) {
            $text = '






            <section class="p0">
  <div class="container-fluid p0">
          <div class="home8-slider vh-85">
              <div id="bs_carousel" class="carousel slide bs_carousel" data-ride="carousel" data-pause="false" data-interval="7000">
                  <div class="carousel-inner">';

                  $fs = get_file_storage();
                  for ($i = 1; $i <= $data->slidesnumber; $i++) {
                      $sliderimage = 'file_slide' . $i;
                      $slide_title = 'slide_title' . $i;
                      $slide_title_2 = 'slide_title_2' . $i;
                      $slide_subtitle = 'slide_subtitle' . $i;
                      $slide_accent = 'slide_accent' . $i;
                      // $slide_btn_url = 'slide_btn_url' . $i;
                      // $slide_btn_text = 'slide_btn_text' . $i;
                      $courseid = 'course' . $i;
                      $course = $DB->get_record('course',array('id' => $data->$courseid));
                      $courseid = $course->id;
                      $chelper = new coursecat_helper();

                      if ($DB->record_exists('course', array('id' => $courseid))) {
                        $course = new core_course_list_element($course);
                        $context = context_course::instance($courseid);
                        $numberofusers = count_enrolled_users($context);
                        $coursename = $chelper->get_course_formatted_name($course);
                        $coursenamelink = new moodle_url('/course/view.php', array('id' => $courseid));
                        $courseCategory = $DB->get_record('course_categories',array('id' => $course->category));
                        $courseCategory = core_course_category::get($courseCategory->id);
                        $courseCategory = $courseCategory->get_formatted_name();


                      // print_object($course);
                      if($i == 1){
                        $class = 'active';
                      } else {
                        $class = '';
                      }

                      $files = $fs->get_area_files($this->context->id, 'block_cocoon_slider_5', 'slides', $i, 'sortorder DESC, id ASC', false, 0, 0, 1);
                      if (!empty($data->$sliderimage) && count($files) >= 1) {
                        $mainfile = reset($files);
                        $mainfile = $mainfile->get_filename();
                        $data->$sliderimage = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/{$this->context->id}/block_cocoon_slider_5/slides/" . $i . '/' . $mainfile);
                      } else {
                        $data->$sliderimage = $CFG->wwwroot .'/theme/edumy/images/home/1.jpg';
                      }

                          $text .= '
                          <div class="carousel-item '.$class.'" data-slide="'.$i.'" data-interval="false">
                              <div class="bs_carousel_bg"  data-ccn="file_slide'.$i.'" data-ccn-img="bg-img-url" style="background-image: url(' . $data->$sliderimage . ');"></div>
                              <div class="bs-caption">
                                  <div class="container">
                                      <div class="row">
                                          <div class="col-md-7 col-lg-8">
                                              <div class="main_title"><span data-ccn="slide_title'.$i.'">'.format_text($data->$slide_title, FORMAT_HTML, array('filter' => true)).'</span> <span class="ccnS5TS" data-ccn="slide_title_2'.$i.'">'.format_text($data->$slide_title_2, FORMAT_HTML, array('filter' => true)).'</span></div>
                                              <p data-ccn="slide_subtitle'.$i.'" class="parag">'.format_text($data->$slide_subtitle, FORMAT_HTML, array('filter' => true)).'</p>
                                          </div>
                                          <div class="col-md-5 col-lg-4">
                        <div class="feat_property home8">
                        <a href="'.$coursenamelink.'">
                          <div class="details">
                            <div class="tc_content">
                              <div class="tag"
                                data-ccn="'.$slide_accent.'">
                                '.$data->$slide_accent.'
                              </div>';
                              if($PAGE->theme->settings->coursecat_modified != 1){
                                $text.='<p>'.get_string('updated', 'theme_edumy').' '.userdate($course->timemodified, get_string('strftimedatefullshort', 'langconfig')).'</p>';
                              }
                              $text.='
                              <h4>'.$coursename.'</h4>';
                              if($PAGE->theme->settings->course_ratings == 1){
                                $text .='<ul class="tc_review">
                                  <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                  <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                  <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                  <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                  <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                </ul>';
                              } elseif($PAGE->theme->settings->course_ratings == 2){
                                $block = block_instance('cocoon_course_rating');
                                $ccnRating = $block->external_star_rating($courseid);
                                $text .= $ccnRating;
                              }
$text .='


                            </div>
                            <div class="fp_footer">
                             <ul class="fp_meta float-left mb0">';
                            if($PAGE->theme->settings->coursecat_enrolments != 1){
                              $text .='
                              <li class="list-inline-item"><i class="flaticon-profile"></i></li>
                              <li class="list-inline-item">'. $numberofusers .'</li>';
                            }

                            if($PAGE->theme->settings->coursecat_announcements != 1){
                              $text .='	<li class="list-inline-item"><i class="flaticon-comment"></i></li>
                                <li class="list-inline-item">'.$course->newsitems.'</li>';
                            }
$text .='</ul>

                              <div class="fp_pdate float-right">'.$courseCategory.'</div>
                            </div>
                          </div>
                          </a>
                        </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>




                        ';
}
                  }

$text .= '




                  </div>
                  <div class="property-carousel-controls">
                      <a class="property-carousel-control-prev" role="button" data-slide="prev">
                          <span class="flaticon-left-arrow"></span>
                      </a>
                      <a class="property-carousel-control-next" role="button" data-slide="next">
                          <span class="flaticon-right-arrow-1"></span>
                      </a>
                  </div>
              </div>
              <div class="carousel slide bs_carousel_prices" data-ride="carousel" data-pause="false" data-interval="false">
                  <div class="carousel-inner"></div>
                  <div class="property-carousel-ticker">
                      <div class="property-carousel-ticker-counter"></div>
                      <div class="property-carousel-ticker-divider">&nbsp;&nbsp;/&nbsp;&nbsp;</div>
                      <div class="property-carousel-ticker-total"></div>
                  </div>
              </div>
          </div>
  </div>
</section>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <a href="#continue">
          <div class="discover_scroll home8">
              <div class="icons">
              <h4>'.get_string('scroll_down', 'theme_edumy').'</h4>
              <p>'.get_string('to_discover_more', 'theme_edumy').'</p>
              </div>
              <div class="thumb">
                <img src="'.$CFG->wwwroot.'/theme/edumy/images/resource/mouse.png" alt="mouse.png">
              </div>
          </div>
        </a>
    </div>
  </div>
</div>
<a id="continue" class="" style="visibility:hidden"></a>';
        }

        $this->content = new stdClass;
        $this->content->footer = '';
        $this->content->text = $text;

        return $this->content;

  }


    /**
     * Serialize and store config data
     */
    function instance_config_save($data, $nolongerused = false) {
        global $CFG;

        $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                    'subdirs'       => 0,
                                    'maxfiles'      => 1,
                                    'accepted_types' => array('.jpg', '.png', '.gif'));

        for($i = 1; $i <= $data->slidesnumber; $i++) {
            $field = 'file_slide' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_slider_5', 'slides', $i, $filemanageroptions);
        }

        parent::instance_config_save($data, $nolongerused);
    }

    /**
     * When a block instance is deleted.
     */
    function instance_delete() {
        global $DB;
        $fs = get_file_storage();
        $fs->delete_area_files($this->context->id, 'block_cocoon_slider_5');
        return true;
    }

    /**
     * Copy any block-specific data when copying to a new block instance.
     * @param int $fromid the id number of the block instance to copy from
     * @return boolean
     */
    public function instance_copy($fromid) {
        global $CFG;

        $fromcontext = context_block::instance($fromid);
        $fs = get_file_storage();

        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 0;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 0;
        }

        $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                    'subdirs'       => 0,
                                    'maxfiles'      => 1,
                                    'accepted_types' => array('.jpg', '.png', '.gif'));

        for($i = 1; $i <= $data->slidesnumber; $i++) {
            $field = 'file_slide' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            // This extra check if file area is empty adds one query if it is not empty but saves several if it is.
            if (!$fs->is_area_empty($fromcontext->id, 'block_cocoon_slider_5', 'slides', $i, false)) {
                $draftitemid = 0;
                file_prepare_draft_area($draftitemid, $fromcontext->id, 'block_cocoon_slider_5', 'slides', $i, $filemanageroptions);
                file_save_draft_area_files($draftitemid, $this->context->id, 'block_cocoon_slider_5', 'slides', $i, $filemanageroptions);
            }
        }

        return true;
    }

    /**
     * The block should only be dockable when the title of the block is not empty
     * and when parent allows docking.
     *
     * @return bool
     */
    public function instance_can_be_docked() {
        return (!empty($this->config->title) && parent::instance_can_be_docked());
    }

    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }

}
