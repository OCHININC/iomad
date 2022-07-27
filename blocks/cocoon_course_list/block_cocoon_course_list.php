<?php

include_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_course_list extends block_list {
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_course_list');
    }

    function has_config() {
        return true;
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
    }


    function get_content() {
        global $CFG, $USER, $DB, $OUTPUT, $PAGE, $COURSE;

        if($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';
        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->child_categories)){$this->content->child_categories = $this->config->child_categories;}else{$this->content->child_categories = '0';}

        if (isset($_GET['categoryid'])) {
          $categoryAlias = $_GET['categoryid'];
        } else {
          $categoryAlias = null;
        }

        $this->content->footer = '
        <div class="selected_filter_widget style2 mb30">
          <div id="accordion" class="panel-group">
            <div class="panel">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a href="#panelBodySoftware" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">'. format_text($this->content->title, FORMAT_HTML, array('filter' => true)) .'</a>
                </h4>
              </div>
              <div id="panelBodySoftware" class="panel-collapse collapse show">
                <div class="panel-body">
                  <div class="category_sidebar_widget">
                    <ul class="category_list">';
                    $topcategory = core_course_category::top();
                    if ($topcategory->is_uservisible() && ($categories = $topcategory->get_children())) { // Check we have categories.
                      if (count($categories) > 1 || (count($categories) == 1 && $DB->count_records('course') > 200)) {     // Just print top level category links
                        foreach ($categories as $category) {
                          $childCategories = $category->get_children();
                          $childCategories = !empty($childCategories) ? $childCategories : null;

                          if($this->content->child_categories == '2' && $childCategories !== null){
                            $ccnShowChildren = true;
                          } elseif ($this->content->child_categories == '1' && $categoryAlias == $category->id && $childCategories !== null) {
                            $ccnShowChildren = true;
                          } else {
                            $ccnShowChildren = false;
                          }

                          $categoryname = $category->get_formatted_name();
                          $this->content->footer .= '<li>
                                                      <a href="'.$CFG->wwwroot .'/course/index.php?categoryid='.$category->id.'">'. $categoryname .' <span class="float-right">('. count($category->get_courses()) .')</span></a>';
                          if($ccnShowChildren !== false){
                            $this->content->footer .= '<ul>';
                            foreach($childCategories as $key=>$childCategory){
                              $this->content->footer .= '<li><a href="'.$CFG->wwwroot .'/course/index.php?categoryid='.$childCategory->id.'">'. $childCategory->get_formatted_name() .' <span class="float-right">('. count($childCategory->get_courses()) .')</span></a></li>';
                            }
                            $this->content->footer .= '</ul>';
                          }
                          $this->content->footer .= '</li>';
                        }
                      }
                    } else { // Just print course names of single category
                      $categories = $topcategory->get_children();
                      $category = array_shift($categories);
                      $courses = $category->get_courses();
                      if ($courses) {
                        foreach ($courses as $course) {
                          $coursecontext = context_course::instance($course->id);
                          $this->content->footer .= '<li><a href="'.$CFG->wwwroot .'/course/view.php?id='.$course->id.'">'. $course->get_formatted_name() .'</a></li>';
                        }
                      }
                    }
                    $this->content->footer .='
                    </ul>
                    <a class="color-orose" href=" '.$CFG->wwwroot.'/course/index.php"><span class="fa fa-plus pr10"></span> '.get_string('see_more', 'theme_edumy').'</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>';
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
