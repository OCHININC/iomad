<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_course_info extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_course_info', 'block_cocoon_course_info');
    }

    // Declare second
    public function specialization()
    {
        // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
        global $CFG;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('course-view'));
    }

    public function get_content()
    {
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');

        if ($this->content !== null) {
            return $this->content;
        }

        // Declare third
        $this->content         =  new stdClass;

        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->body)){$this->content->body = $this->config->body;}
        //Begin CCN Image Processing
        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_course_info', 'content');
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image = '<img class="mr20" src="' . $url . '" alt="' . $filename . '" />';
            }
        }
        // End CCN Image Processing


        $this->content->text = '
        <div class="selected_filter_widget style2">
          <span class="float-left">'. $this->content->image .'</span>
          <h4 class="mt15 fz20 fw500">'. format_text($this->content->title, FORMAT_HTML, array('filter' => true)) .'</h4>
          <br>
          <p>'. format_text($this->content->body, FORMAT_HTML, array('filter' => true)) .'</p>
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
