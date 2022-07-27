<?php

include_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot. '/course/renderer.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/course_handler/ccn_course_handler.php');

class block_cocoon_course_categories extends block_base {
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_course_categories');
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

    public function instance_allow_multiple() {
      return true;
    }

    function specialization() {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->title = 'Via School Categories Courses';
          $this->config->subtitle = 'Cum doctus civibus efficiantur in imperdiet deterruisset.';
          $this->config->button_text = 'View All Courses';
          $this->config->body = '0';
          $this->config->items = '8';
          $this->config->color_bg = 'rgb(255,255,255)';
          $this->config->color_title = '#0a0a0a';
          $this->config->color_subtitle = '#6f7074';
          $this->config->color_overlay = 'rgba(10,10,10,.5)';
          $this->config->color_hover = '#2441e7';
          $this->config->color_btn = '#2441e7';
          $this->config->button_bdrrd = '50';
        }

    }

    function get_content() {
        global $CFG, $USER, $DB, $OUTPUT;

        if($this->content !== NULL) {
            return $this->content;
        }

        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->items = !empty($data->items) ?  (int) $data->items : (int) 8;
            // $data->items = is_numeric($data->items) ? (int)$data->items : (int) 8;
        } else {
            $data = new stdClass();
            $data->items = 0;
        }

        $this->content = new \stdClass();

        $this->content->text = '';
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->subtitle = '';}
        if(!empty($this->config->body)){$this->content->body = $this->config->body;} else {$this->content->body = 0;}
        if(!empty($this->config->button_link)){$this->content->button_link = $this->config->button_link;}else{$this->content->button_link = "#our-courses";}
        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;} else {$this->content->button_text = '';}
        if(!empty($this->config->categories)){$this->content->categories = $this->config->categories;} else {$this->content->categories = NULL ;}
        if(!empty($this->config->style)){$this->content->style = $this->config->style;} else {$this->content->style = 0;}
        if(!empty($this->config->color_bg)){$this->content->color_bg = $this->config->color_bg;} else {$this->content->color_bg = 'rgb(255,255,255)';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = '#0a0a0a';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = '#6f7074';}
        if(!empty($this->config->color_overlay)){$this->content->color_overlay = $this->config->color_overlay;} else {$this->content->color_overlay = 'rgba(10,10,10,.5)';}
        if(!empty($this->config->color_hover)){$this->content->color_hover = $this->config->color_hover;} else {$this->content->color_hover = '#2441e7';}
        if(!empty($this->config->color_btn)){$this->content->color_btn = $this->config->color_btn;} else {$this->content->color_btn = '#2441e7';}
        if(!empty($this->config->button_bdrrd)){$this->content->button_bdrrd = $this->config->button_bdrrd;} else {$this->content->button_bdrrd = '50';}

        if ($this->content->style == 1) {
          $this->content->style = '<a href="#our-courses">
				    	<div class="mouse_scroll">
			        		<div class="icon"><span class="flaticon-download-arrow"></span></div>
				    	</div>
				    </a>';
        } else {
          $this->content->style = '';
        }

        $this->content->text = '
        <style type="text/css">
        .img_hvr_box:before {
          background-color: '.$this->content->color_overlay.';
        }
        .img_hvr_box:hover:before {
          background-color: '.$this->content->color_hover.';
        }
        </style>
        <section id="our-courses" class="our-courses pt90 pt650-992" data-ccn-c="color_bg" data-ccn-co="bg" style="background-color:'.$this->content->color_bg.';">
      		<div class="container">
      			<div class="row">
      				<div class="col-lg-12">
      					'.$this->content->style.'
      				</div>
      			</div>
      		</div>
      		<div class="container">
      			<div class="row">
      				<div class="col-lg-6 offset-lg-3">
      					<div class="main-title text-center">
      						<h3 data-ccn="title" class="mt0" data-ccn-c="color_title" data-ccn-co="content" style="color:'.$this->content->color_title.';">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
      						<p data-ccn="subtitle" data-ccn-c="color_subtitle" data-ccn-co="content" style="color:'.$this->content->color_subtitle.';">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
      					</div>
      				</div>
      			</div>
      			<div class="row">
              <div class="col-12">
                <div class="row">';
          $topcategory = core_course_category::top();
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


          if(!empty($this->content->categories) && $this->content->categories !== NULL){
            foreach($this->content->categories as $k=>$category) {

              $ccnCourseHandler = new ccnCourseHandler();
              $ccnGetCategoryDetails = $ccnCourseHandler->ccnGetCategoryDetails((int)$category);

              if($ccnGetCategoryDetails->coursesCount >= 1){
                $countNoOfCourses = '<p>'.get_string('number_of_courses', 'theme_edumy', $ccnGetCategoryDetails->coursesCount).'</p>';
              } elseif($ccnGetCategoryDetails->subcategoriesCount >= 1) {
                $countNoOfCourses = '<p>'.get_string('number_of_subcategories', 'theme_edumy', $ccnGetCategoryDetails->subcategoriesCount).'</p>';
              } else {
                $countNoOfCourses = '';
              }

              $this->content->text .= '
              <div class="'.$col_class.'">
                <a href="'.$ccnGetCategoryDetails->categoryUrl.'" class="img_hvr_box" style="background-image: url('.$ccnGetCategoryDetails->coverImage.');">
                  <div class="overlay">
                    <div class="details">
                      <h5>'. $ccnGetCategoryDetails->categoryName .'</h5>';
                      if($this->content->body == '2'){
                        $this->content->text .= '';
                      } elseif($this->content->body == '1'){
                        $this->content->text .= $countNoOfCourses;
                      } else {
                       $this->content->text .='<p>'. $ccnGetCategoryDetails->categorySummary.'</p>';
                      }
                      $this->content->text .='
                    </div>
                  </div>
                </a>
              </div>';

            }
          } elseif($data->items > 0) {
            if ($topcategory->is_uservisible() && ($categories = $topcategory->get_children())) { // Check we have categories.
              if (count($categories) > 1 || (count($categories) == 1 && $DB->count_records('course') > 200)) {     // Just print top level category links
                  $i = 0;
                  foreach ($categories as $category) {
                    if(++$i > $data->items) break;

                    $outputimage = '';
                    //ccnComm: Fetching the image manually added to the coursecat description via the Atto editor.
                    $chelper = new coursecat_helper();
                    $description = $chelper->get_category_formatted_description($category);
                    if ($description) {
                      $dom = new DOMDocument();
                      $dom->loadHTML($description);
                      $xpath = new DOMXPath($dom);
                      $src = $xpath->evaluate("string(//img/@src)");
                    }
                    if ($src && $description){
                      $outputimage = $src;
                    } else {
                      $children_courses = $category->get_courses();
                      if($children_courses >= 1){
                        $countNoOfCourses = '<p>'.get_string('number_of_courses', 'theme_edumy', count($children_courses)).'</p>';
                      } else {
                        $countNoOfCourses = '';
                      }
                      foreach($children_courses as $child_course) {
                        if ($child_course === reset($children_courses)) {
                          foreach ($child_course->get_course_overviewfiles() as $file) {
                            if ($file->is_valid_image()) {
                              $imagepath = '/' . $file->get_contextid() . '/' . $file->get_component() . '/' . $file->get_filearea() . $file->get_filepath() . $file->get_filename();
                              $imageurl = file_encode_url($CFG->wwwroot . '/pluginfile.php', $imagepath, false);
                              $outputimage  =  $imageurl;
                              // Use the first image found.
                              break;
                            }
                          }
                        }
                      }
                    }
                      $categoryname = $category->get_formatted_name();
                      $linkcss = $category->visible ? "" : " class=\"dimmed\" ";
                      $this->content->text .= '
                      <div class="'.$col_class.'">
                        <a href="'.$CFG->wwwroot .'/course/index.php?categoryid='.$category->id.'" class="img_hvr_box" style="background-image: url('. $outputimage .');">
                          <div class="overlay">
                            <div class="details">
                              <h5>'. $categoryname .'</h5>';
                              if($this->content->body == '2'){
                                $this->content->text .= '';
                              } elseif($this->content->body == '1'){
                                $this->content->text .= $countNoOfCourses;
                              } else {
                               $this->content->text .='<p>'. format_string($category->description, $striplinks = true,$options = null).'</p>';
                              }
                              $this->content->text .='
                            </div>
                          </div>
                        </a>
                      </div>';

                  }
                }
              } else {                          // Just print course names of single category
                $category = array_shift($categories);
                if($category !== null){
                  $courses = $category->get_courses();

                  if ($courses) {
                      foreach ($courses as $course) {
                          $coursecontext = context_course::instance($course->id);
                          $linkcss = $course->visible ? "" : " class=\"dimmed\" ";

                          $this->content->text .= '
                          <li><a href="'.$CFG->wwwroot .'/course/view.php?id='.$course->id.'">'. $course->get_formatted_name() .' <span class="float-right">()</span></a></li>

                          ';
                      }
                    }
                }

                }
              } else {
                $this->content->text .= '<div class="text-center col-lg-6 offset-lg-3">'.get_string('select_no_cat', 'theme_edumy').'</div>';
              }
              $this->content->text .='
              </div>
            </div>';
            if(!empty($this->content->button_text)){
            $this->content->text .='
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <div class="row">
                <div class="col-lg-6 offset-lg-3">
                  <div class="courses_all_btn text-center">
                    <a data-ccn="button_text" data-ccn-c="color_btn" data-ccn-cv="'.$this->content->color_btn.'" data-ccn-bdrrd="button_bdrrd" class="btn btn-transparent ccnLcEl--i" href="'.$CFG->wwwroot .'/course/index.php" style="border-radius:'.$this->content->button_bdrrd.'px;">'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).'</a>
                  </div>
                </div>
              </div>
            </div>';
          }
          $this->content->text .='
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
