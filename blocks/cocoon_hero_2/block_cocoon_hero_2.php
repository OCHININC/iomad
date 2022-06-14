<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_hero_2 extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_hero_2', 'block_cocoon_hero_2');
    }

    // Declare second
    public function specialization()
    {
        // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->title = 'Find the Best Courses';
          $this->config->subtitle = 'Technology is brining a massive wave of evolution on learning things on different ways.';
          $this->config->button_text = 'Ready to Get Started?';
          $this->config->button_link = '#';
        }
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content         =  new \stdClass();
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = ''; }
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->title = ''; }
        if(!empty($this->config->button_link)){$this->content->button_link = $this->config->button_link;} else {$this->content->title = ''; }
        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;} else {$this->content->title = ''; }
        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_hero_2', 'content');
        $this->content->image = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image .=  $url;
            }
        }



        $this->content->text = '
        <section class="home-three home8 home8-overlay home8_bgi7" data-ccn="image" data-ccn-img="bg-img-url" style="background-image:url('.$this->content->image.');background-size:cover;">
  <div class="container">
    <div class="row home8_wave"></div>
    <div class="row posr">
      <div class="col-lg-12">
        <div class="home-text text-center home8">
          <h2 class="fz50" data-ccn="title">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h2>
          <p data-ccn="subtitle" class="color-white">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
          <a data-ccn="button_text" class="btn home_btn" href="'.format_text($this->content->button_link, FORMAT_HTML, array('filter' => true)).'">'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).'</a>
        </div>
      </div>
    </div>
    <div class="row_style home8">
      <img src="'.$CFG->wwwroot.'/theme/edumy/images/about/wave.svg" alt="wave.svg">
    </div>
  </div>
</section>';
        return $this->content;
    }

    /**
     * Allow multiple instances in a single course?
     *
     * @return bool True if multiple instances are allowed, false otherwise.
     */
    public function instance_allow_multiple() {
        return false;
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
