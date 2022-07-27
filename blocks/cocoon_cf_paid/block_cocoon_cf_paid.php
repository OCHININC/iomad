<?php
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
include_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');

class block_cocoon_cf_paid extends block_list {
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_cf_paid');
    }

    function has_config() {
        return true;
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('course-index-category'));
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
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = $this->title;}


        $ccnCourseHandler = new ccnCourseHandler();
        $ccnFilter = $ccnCourseHandler->ccnBuildCourseFilterType('filter-price');

        $this->content->footer = '
        <div class="selected_filter_widget style2 mb30">
    <div id="accordion" class="panel-group">
      <div class="panel">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a href="#panelBodyPrice" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">'.$this->content->title.'</a>
            </h4>
          </div>
        <div id="panelBodyPrice" class="panel-collapse collapse show">
            <div class="panel-body">


              '.$ccnFilter.'
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
