<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_parallax_subscribe extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('pluginname', 'block_cocoon_parallax_subscribe');
    }

    // Declare second
    public function specialization()
    {
        // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content         =  new \stdClass();
        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;}
        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;}
        if(!empty($this->config->form_title)){$this->content->form_title = $this->config->form_title;}
        if(!empty($this->config->form_subtitle)){$this->content->form_subtitle = $this->config->form_subtitle;}
        if(!empty($this->config->date)){$this->content->date = $this->config->date;}

        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_parallax_subscribe', 'content');
        $this->content->image = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image .=  $url;
            }
        }



        $this->content->text = '
        <style type="text/css">
          .ccnH-'.$this->block->instance.':before {
            background-image: url('.$this->content->image.');
          }
        </style>
        <section class="divider2 parallax bgc-thm2 ccnH-'.$this->block->instance.'" data-stellar-background-ratio="0.3">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-xl-6">
        <div class="divider-two">
          <p class="color-white">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
          <h1 class="color-white text-uppercase">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h1>
              <div id="countdown" ccn-year="'.userdate($this->content->date, '%Y', 0).'" ccn-month="'.userdate($this->content->date, '%m', 0).'" ccn-day="'.userdate($this->content->date, '%d', 0).'"></div>
        </div>
      </div>
      <div class="col-lg-6 col-xl-6">
        <div class="divider-two">
          <p class="color-white">'.format_text($this->content->form_title, FORMAT_HTML, array('filter' => true)).'</p>
          <h3 class="color-white text-uppercase">'.format_text($this->content->form_subtitle, FORMAT_HTML, array('filter' => true)).'</h3>
        </div>
        <div class="divider-two-form">
          <div id="mc_embed_signup">
          <form id="mc-embedded-subscribe-form" action="'.$CFG->wwwroot.'/local/contact/index.php" method="post" class="validate">
            <div id="mc_embed_signup_scroll">';
              $this->content->text .='
              <div class="mc-field-group">
                <input id="name" name="name" type="name" required="required" class="" placeholder="Your Name"></div>
                <div class="mc-field-group">
                <input id="email" name="email" type="email" required="required" class="required email" placeholder="'.get_string('email_address', 'theme_edumy').'">
                </div>
                <input type="hidden" id="sesskey" name="sesskey" value="">
                <script>document.getElementById(\'sesskey\').value = M.cfg.sesskey;</script>
                <button type="submit" name="submit" id="submit" class="btn btn-lg mailchimp_btn">'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).'</button>
                </div>
          </form>
          </div>
        </div>
      </div>
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
