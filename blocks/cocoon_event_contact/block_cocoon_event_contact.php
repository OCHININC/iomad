<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_event_contact extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_event_contact', 'block_cocoon_event_contact');
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
        if(!empty($this->config->phone)){$this->content->phone = $this->config->phone;}
        if(!empty($this->config->email)){$this->content->email = $this->config->email;}
        if(!empty($this->config->website)){$this->content->website = $this->config->website;}
        if(!empty($this->config->map_lat)){$this->content->map_lat = $this->config->map_lat;}
        if(!empty($this->config->map_lng)){$this->content->map_lng = $this->config->map_lng;}

        $this->content->text = '
        <div class="event_details_widget">
  <h4 class="title">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h4>
  <div class="h200 mb30 bdrs5" id="map-canvas"></div>
  <ul>
    <li><span class="flaticon-phone-call"></span> '.format_text($this->content->phone, FORMAT_HTML, array('filter' => true)).'</li>
    <li><span class="flaticon-email"></span> '.format_text($this->content->email, FORMAT_HTML, array('filter' => true)).'</li>
    <li><span class="flaticon-www"></span> '.format_text($this->content->website, FORMAT_HTML, array('filter' => true)).'</li>
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
