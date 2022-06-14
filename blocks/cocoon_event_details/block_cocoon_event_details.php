<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_event_details extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_event_details', 'block_cocoon_event_details');
    }

    // Declare second
    public function specialization()
    {
        // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
        global $CFG;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content         =  new stdClass;
        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->date)){$this->content->date = $this->config->date;}
        if(!empty($this->config->time)){$this->content->time = $this->config->time;}
        if(!empty($this->config->location)){$this->content->location = $this->config->location;}

        $this->content->text = '
        <div class="event_details_widget">
  <h4 class="title">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h4>
  <ul>
    <li><span class="flaticon-appointment"></span> '.userdate($this->content->date, get_string('strftimedatefullshort', 'langconfig')).'</li>
    <li><span class="flaticon-clock"></span> '.format_text($this->content->time, FORMAT_HTML, array('filter' => true)).'</li>
    <li><span class="flaticon-placeholder"></span> '.format_text($this->content->location, FORMAT_HTML, array('filter' => true)).'</li>
  </ul>
</div>';
        return $this->content;
    }

    /**
     * Allow multiple instances in a single course?
     *
     * @return bool True if multiple instances are allowed, false otherwise.
     */
    public function instance_allow_multiple() {
        return true;
    }

    /**
     * Enables global configuration of the block in settings.php.
     *
     * @return bool True if the global configuration is enabled.
     */
    function has_config() {
        return true;
    }

    /**
     * Sets the applicable formats for the block.
     *
     * @return string[] Array of pages and permissions.
     */
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

}
