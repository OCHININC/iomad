<?php

include_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot. '/course/renderer.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_course_categories_5 extends block_base {
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_course_categories_5');
    }

    function has_config() {
        return true;
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
          $ccnCourseHandler = new ccnCourseHandler();
          $ccnCategories = $ccnCourseHandler->ccnGetExampleCategoriesIds(5);
          $this->config = new \stdClass();
          $this->config->items = 5;
          $this->config->title = 'Via School Categories Courses';
          $this->config->subtitle = 'Cum doctus civibus efficiantur in imperdiet deterruisset.';
          $this->config->button_text = 'View All Courses';
          $this->config->category1 = isset($ccnCategories[0]) ? $ccnCategories[0] : NULL;
          $this->config->category2 = isset($ccnCategories[1]) ? $ccnCategories[1] : NULL;
          $this->config->category3 = isset($ccnCategories[2]) ? $ccnCategories[2] : NULL;
          $this->config->category4 = isset($ccnCategories[3]) ? $ccnCategories[3] : NULL;
          $this->config->category5 = isset($ccnCategories[4]) ? $ccnCategories[4] : NULL;
          $this->config->icon1 = 'flaticon-elearning';
          $this->config->icon2 = 'flaticon-photo-camera';
          $this->config->icon3 = 'ccn-flaticon-smartphone-6';
          $this->config->icon4 = 'la la-headphones';
          $this->config->icon5 = 'flaticon-3d';
          $this->config->color_bfbg1 = 'rgba(10, 10, 10, .5)';
          $this->config->color_bfbg_hover1 = 'rgba(36, 65, 231, .8)';
          $this->config->color_bfbg2 = 'rgba(10, 10, 10, .5)';
          $this->config->color_bfbg_hover2 = 'rgba(36, 65, 231, .8)';
          $this->config->color_bfbg3 = 'rgba(10, 10, 10, .5)';
          $this->config->color_bfbg_hover3 = 'rgba(36, 65, 231, .8)';
          $this->config->color_bfbg4 = 'rgba(10, 10, 10, .5)';
          $this->config->color_bfbg_hover4 = 'rgba(36, 65, 231, .8)';
          $this->config->color_bfbg5 = 'rgba(10, 10, 10, .5)';
          $this->config->color_bfbg_hover5 = 'rgba(36, 65, 231, .8)';
        }

    }



    function get_content() {
        global $CFG, $USER, $DB, $OUTPUT;

        if($this->content !== NULL) {
            return $this->content;
        }

        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->items = is_numeric($data->items) ? (int)$data->items : 5;
        } else {
            $data = new stdClass();
            $data->items = '5';
        }

        $this->content = new stdClass;
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->subtitle = '';}
        if(!empty($this->config->body)){$this->content->body = $this->config->body;} else {$this->content->body = '';}
        if(!empty($this->config->button_link)){$this->content->button_link = $this->config->button_link;}else{$this->content->button_link = "#our-courses";}
        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;}else{$this->content->button_text = "View All Courses";}

        // if ($data->items > 0) {
        $this->content->text = '

        <section id="our-courses" class="our-courses pt90 pt650-992">
      		<div class="container">
      			<div class="row">
      				<div class="col-lg-6">
      					<div class="main-title mb-4">';
                if(!empty($this->content->title)){
                 $this->content->text .='<h3 class="mt0" data-ccn="title">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>';
                }
                if(!empty($this->content->subtitle)){
				          $this->content->text .='	 <p data-ccn="subtitle">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
                }
                $this->content->text .='
					      </div>
              </div>
              <div class="col-lg-6">
                <div class="ccn-section-top-more ccn-top-more-categories pull-right mt0 mb20">
                  <a data-ccn="button_text" class="" href="'.$CFG->wwwroot .'/course/index.php">'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).' <span class="flaticon-right-arrow-1"></span></a>
                </div>
              </div>
            </div>
			      <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="row">';
          // $topcategory = core_course_category::top();
                $col_class = "";
                if ($data->items == 1) {
                  $col_class = "col-sm-12 col-lg-12";
                } else if ($data->items == 2) {
                  $col_class = "col-sm-6 col-lg-6";
                } else if ($data->items == 3) {
                  $col_class = "col-sm-6 col-lg-4";
                } else {
                  $col_class = "col-sm-6 col-lg-3";
                }
          if ($data->items > 0) {
            for ($i = 1; $i <= $data->items; $i++) {

              $icon = 'icon' . $i;
              $color = 'color_bfbg' . $i;
              $color_hover = 'color_bfbg_hover' . $i;
              $categoryID = 'category' . $i;

              $ccnCourseHandler = new ccnCourseHandler();
              $ccnGetCategoryDetails = $ccnCourseHandler->ccnGetCategoryDetails($data->$categoryID);

              if ($DB->record_exists('course_categories', array('id' => $data->$categoryID))) {
                // $category = $DB->get_record('course_categories',array('id' => $data->$categoryID));
                // $chelper = new coursecat_helper();
                // $categoryID = $category->id;
                // $category = core_course_category::get($categoryID);

                            if($ccnGetCategoryDetails->coursesCount >= 1){
                              $countNoOfCourses = '<p class="color-white">'.get_string('number_of_courses', 'theme_edumy', $ccnGetCategoryDetails->coursesCount).'</p>';
                            } else {
                              $countNoOfCourses = '';
                            }

                $this->content->text .=
                '
                <div class="col-sm-6 col-md-6 col-lg-4 col-lg-5th-1">
        					<a
                    href="'.$CFG->wwwroot .'/course/index.php?categoryid='.$ccnGetCategoryDetails->categoryId.'"
                    class="icon_hvr_img_box ccn-color-cat-boxes"
                    data-ccn-c="'.$color.'"
                    data-ccn-co="ccnBfBg"
                    data-ccn-ch-co="ccnBfBg"
                    data-ccn-cv="'.$data->$color.'"
                    data-ccn-ch="'.$color_hover.'"
                    data-ccn-ch-self
                    data-ccn-ch-cv="'.$data->$color_hover.'"
                    style="
                      background-image:url('.$ccnGetCategoryDetails->coverImage.');
                      background-size:cover;"
                    >
        						<div class="overlay">
        							<div class="icon ccn_icon_2 color-white"><span data-ccn="'.$icon.'" class="'.$data->$icon.'"></span></div>
        							<div class="details">
        								<h5 class="color-white">'.$ccnGetCategoryDetails->categoryName.'</h5>';
                          if(!empty($this->content->body) && $this->content->body != '1'){
                            $this->content->text .='<p class="color-white">'. format_string($ccnGetCategoryDetails->categoryDescription, $striplinks = true,$options = null).'</p>';
                          } else {
                            $this->content->text .= $countNoOfCourses;
                          }
                          $this->content->text .= '
        							</div>
        						</div>
        					</a>
        				</div>' ;
              }
            }
              } else {
                $this->content->text .= '<div class="text-center col-lg-6 offset-lg-3">'.get_string('select_no_cat', 'theme_edumy').'</div>';
              }
              $this->content->text .='
              </div>
            </div>
          </div>
        </div>
      </section>';

        return $this->content;
    }

    /**
     * Returns the role that best describes the course list block.
     *
     * @return string
     */
    public function get_aria_role() {
        return 'navigation';
    }
    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }
}
