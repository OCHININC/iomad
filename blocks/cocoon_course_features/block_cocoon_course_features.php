<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_course_features extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_course_features', 'block_cocoon_course_features');
    }

    // Declare second
    public function specialization()
    {
        // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
        $this->lectures = isset($this->config->lectures) ? format_string($this->config->lectures) : '';
        $this->quizzes = isset($this->config->quizzes) ? format_string($this->config->quizzes) : '';
        $this->duration = isset($this->config->duration) ? format_string($this->config->duration) : '';
        $this->skill_level = isset($this->config->skill_level) ? format_string($this->config->skill_level) : '';
        $this->language = isset($this->config->language) ? format_string($this->config->language) : '';
        $this->assessments = isset($this->config->assessments) ? format_string($this->config->assessments) : '';
        global $CFG;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('course-view'));
    }

    function instance_allow_config() {
        return true;
    }

    public function get_content()
    {
        global $CFG, $DB;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content         =  new stdClass;

        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->lectures)){$this->content->lectures = $this->config->lectures;}
        if(!empty($this->config->quizzes)){$this->content->quizzes = $this->config->quizzes;}
        if(!empty($this->config->duration)){$this->content->duration = $this->config->duration;}
        if(!empty($this->config->skill_level)){$this->content->skill_level = $this->config->skill_level;}
        if(!empty($this->config->language)){$this->content->language = $this->config->language;}
        if(!empty($this->config->assessments)){$this->content->assessments = $this->config->assessments;}

        $this->content->text = '
        <div class="feature_course_widget">
          <ul class="list-group">
            <h4 class="title">'. format_text($this->content->title, FORMAT_HTML, array('filter' => true)) .'</h4>
            <li class="d-flex justify-content-between align-items-center">
                '.get_string('lectures', 'theme_edumy').' <span class="float-right">'. format_text($this->content->lectures, FORMAT_HTML, array('filter' => true)) .'</span>
            </li>
            <li class="d-flex justify-content-between align-items-center">
                '.get_string('quizzes', 'theme_edumy').' <span class="float-right">'. format_text($this->content->quizzes, FORMAT_HTML, array('filter' => true)) .'</span>
            </li>
            <li class="d-flex justify-content-between align-items-center">
                '.get_string('duration', 'theme_edumy').' <span class="float-right">'. format_text($this->content->duration, FORMAT_HTML, array('filter' => true)) .'</span>
            </li>
            <li class="d-flex justify-content-between align-items-center">
                '.get_string('skill_level', 'theme_edumy').' <span class="float-right">'. format_text($this->content->skill_level, FORMAT_HTML, array('filter' => true)) .'</span>
            </li>
            <li class="d-flex justify-content-between align-items-center">
                '.get_string('language', 'theme_edumy').' <span class="float-right">'. format_text($this->content->language, FORMAT_HTML, array('filter' => true)) .'</span>
            </li>
            <li class="d-flex justify-content-between align-items-center">
                '.get_string('assessments', 'theme_edumy').' <span class="float-right">'. format_text($this->content->assessments, FORMAT_HTML, array('filter' => true)) .'</span>
            </li>
          </ul>
        </div>';
        return $this->content;
    }
    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }
}
