<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_subscribe extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_subscribe', 'block_cocoon_subscribe');
    }

    // Declare second
    public function specialization() {
      global $CFG, $DB;
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
      if (empty($this->config)) {
        $this->config = new \stdClass();
        $this->config->title = 'Get Newsletter';
        $this->config->subtitle = 'Your download should start automatically, if not Click here. Do you want our newsletter?';
        $this->config->button_text = 'Get it Now';
        $this->config->color_bg = '#f9fafc';
        $this->config->color_title = '#0a0a0a';
        $this->config->color_subtitle = '#6f7074';
        $this->config->color_btn = '#2441e7';
        $this->config->color_btn_hover = '#2441e7';
        $this->config->box_shadow = '0';
      }
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
          return $this->content;
        }
        $this->content =  new \stdClass();
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;}else {$this->content->subtitle = '';}
        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;}else {$this->content->button_text = '';}
        if(!empty($this->config->color_bg)){$this->content->color_bg = $this->config->color_bg;} else {$this->content->color_bg = '#f9fafc';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = '#0a0a0a';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = '#6f7074';}
        if(!empty($this->config->color_btn)){$this->content->color_btn = $this->config->color_btn;} else {$this->content->color_btn = '#2441e7';}
        if(!empty($this->config->color_btn_hover)){$this->content->color_btn_hover = $this->config->color_btn_hover;} else {$this->content->color_btn_hover = '#2441e7';}
        if(!empty($this->config->box_shadow)){$this->content->box_shadow = $this->config->box_shadow;} else {$this->content->box_shadow = '0';}

        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_subscribe', 'content');
        $this->content->image = '';
        foreach ($files as $file) {
          $filename = $file->get_filename();
          if ($filename <> '.') {
            $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
            $this->content->image .=  $url;
          }
        }

        $this->content->text = '
        <section id="our-newslatters" class="our-newslatters ccn-box-shadow-'.$this->content->box_shadow.'"
          data-ccn-c="color_bg"
          data-ccn-co="ccnBg"
          data-ccn-cv="'.$this->content->color_bg.'"
          >
          <div class="container">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                  <h3 class="mt0"
                    data-ccn="title"
                    data-ccn-c="color_title"
                    data-ccn-co="ccnCn"
                    data-ccn-cv="'.$this->content->color_title.'"
                    >'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
                  <p
                    data-ccn="subtitle"
                    data-ccn-c="color_subtitle"
                    data-ccn-co="ccnCn"
                    data-ccn-cv="'.$this->content->color_subtitle.'"
                    >'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                <div class="footer_apps_widget_home1">
                  <form action="'.$CFG->wwwroot.'/local/contact/index.php" method="post" class="form-inline mailchimp_form">';
                    if (!isloggedin() || isguestuser()) {
                      $this->content->text .='
                      <input id="name" name="name" type="name" required="required" class="hidden" placeholder="" value="Anonymous">';
                    }
                    $this->content->text .='
                    <input id="email" name="email" type="email" required="required" class="form-control" placeholder="'.get_string('email_address', 'theme_edumy').'">
                    <input type="hidden" id="sesskey" name="sesskey" value="">
                    <script>document.getElementById(\'sesskey\').value = M.cfg.sesskey;</script>
                    <button type="submit" name="submit" id="submit" class="btn btn-lg btn-thm dbxshad"
                      data-ccn="button_text"
                      data-ccn-c="color_btn"
                      data-ccn-co="ccnBg, ccnBd"
                      data-ccn-cv="'.$this->content->color_btn.'"
                      data-ccn-ch-co="ccnBd, ccnCn"
                      data-ccn-ch-cv="'.$this->content->color_btn_hover.'"
                      data-ccn-ch="color_btn_hover"
                      data-ccn-ch-self
                      >'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).' <span class="flaticon-right-arrow-1"></span></button>
                  </form>
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
