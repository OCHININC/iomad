<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_custom_html extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_custom_html', 'block_cocoon_custom_html');

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
      return $ccnBlockHandler->ccnGetBlockApplicability(array('trulyAll'));
    }

    public function instance_allow_multiple() {
        return true;
    }

    public function get_content()
    {
        global $CFG, $DB;

        if ($this->content !== null) {
            return $this->content;
        }

        // Declare third
        $this->content = new stdClass;

        if(!empty($this->config->title)){$this->content->title = '<h4 class="title">'. format_text($this->config->title, FORMAT_HTML, array('filter' => true)) .'</h4>';}
        if(!empty($this->config->body)){$this->content->body = $this->config->body['text'];}
        if(!empty($this->config->style)){$this->content->style = $this->config->style;}
        $this->content->text = '';
        if($this->content->style == 2) { //Box shadow
          $this->content->text .= '
          <div class="cs_row_two">
            <div class="cs_overview ccn-csv2">
              '.$this->content->title.'
              '. format_text($this->content->body, FORMAT_HTML, array('filter' => true, 'noclean' => true)) .'
            </div>
          </div>';
        } elseif($this->content->style == 1) { //Border
          $this->content->text .= '
          <div class="cs_row_two">
            <div class="cs_overview">
              '.$this->content->title.'
              '. format_text($this->content->body, FORMAT_HTML, array('filter' => true, 'noclean' => true)) .'
            </div>
          </div>';
        } else { //No Style
          $this->content->text .= '
          <div class="ccn_custom_html_default">
            '.$this->content->title.'
            '. format_text($this->content->body, FORMAT_HTML, array('filter' => true, 'noclean' => true)) .'
          </div>';
        }
        return $this->content;
    }
    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }
}
