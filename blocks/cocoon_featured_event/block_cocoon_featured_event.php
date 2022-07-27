<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_featured_event extends block_base
{

    public function init()
    {

        $this->title = get_string('cocoon_featured_event', 'block_cocoon_featured_event');

    }
    public function specialization()
    {
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
        if(!empty($this->config->body)){$this->content->body = $this->config->body;}
        if(!empty($this->config->date)){$this->content->date = $this->config->date;}
        if(!empty($this->config->end_date)){$this->content->end_date = $this->config->end_date;}
        if(!empty($this->config->time)){$this->content->time = $this->config->time;}
        if(!empty($this->config->location)){$this->content->location = $this->config->location;}
        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;}
        if(!empty($this->config->button_link)){$this->content->button_link = $this->config->button_link;}

        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_featured_event', 'content');
        $this->content->image = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image .=  $url;
            }
        }
        $this->content->text = '
        <div class="row event_lists p0">
          <div class="col-xl-5 pr15-xl pr0 mb35">
            <div class="blog_grid_post event_lists">
              <div class="thumb" style="background-image: url('.$this->content->image.');background-size:cover;">
                <div class="post_date"><h2>'.userdate($this->content->date, '%d').'</h2> <span>'.userdate($this->content->date, '%B').'</span></div>
              </div>
            </div>
          </div>
          <div class="col-xl-7 pl15-xl pl0 mb35">
            <div class="blog_grid_post style2 event_lists">
              <div class="details">';
              if($this->content->title){
                $this->content->text .='<h3 data-ccn="title">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>';
              }
              if($this->content->body){
                $this->content->text .='<p data-ccn="body">'.format_text($this->content->body, FORMAT_HTML, array('filter' => true)).'</p>';
              }
              $this->content->text .='
                <ul class="mb0">';
                  if($this->content->date || $this->content->end_date){
                    $this->content->text .='<li class="ccn-block-featured-event-detail">';
                    if($this->content->date) {
                      $this->content->text .='<span class="flaticon-appointment"></span>'.get_string('config_date', 'theme_edumy').': '.userdate($this->content->date, get_string('strftimedatefullshort', 'langconfig'));
                    }
                    if(!empty($this->content->end_date)) {
                      $this->content->text .='<span class="flaticon-appointment '. ($this->content->date ? 'ml30' : '') .'"></span>'.get_string('end_date', 'theme_edumy').': '.userdate($this->content->end_date, get_string('strftimedatefullshort', 'langconfig'));
                    }
                    $this->content->text .='</li>';
                  }
                  if($this->content->time){
                    $this->content->text .='<li class="ccn-block-featured-event-detail"><span class="flaticon-clock"></span><span data-ccn="time">'.format_text($this->content->time, FORMAT_HTML, array('filter' => true)).'</span></li>';
                  }
                  if($this->content->location){
                    $this->content->text .='<li class="ccn-block-featured-event-detail"><span class="flaticon-placeholder"></span><span data-ccn="location">'.format_text($this->content->location, FORMAT_HTML, array('filter' => true)).'</span></li>';
                  }
                  $this->content->text .='
                </ul>';
                if(!empty($this->content->button_text)){
                  $this->content->text .='<a data-ccn="button_text" href="'.$this->content->button_link.'" class="btn dbxshad btn-md btn-thm2 rounded mt30">'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).'</a>';
                }
                $this->content->text .='
              </div>
            </div>
          </div>
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
