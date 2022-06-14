<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_parallax_subscribe_2 extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('pluginname', 'block_cocoon_parallax_subscribe_2');
    }

    // Declare second
    public function specialization() {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');

        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->title = 'REGISTER TO GET IT';
          $this->config->subtitle = 'Get 100 Online Courses for Free';
          $this->config->button_text = 'Get it Now';
          $this->config->form_title = 'Create Free Account To Get';
          $this->config->form_subtitle = 'The Complete Web Developer Course';
        }

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
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_parallax_subscribe_2', 'content');
        $this->content->image = $CFG->wwwroot .'/theme/edumy/background/4.jpg';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image =  $url;
            }
        }

        $this->content->text = '
        <section
          class="divider3 parallax bgi4 pt90 pb90"
          data-stellar-background-ratio="0.3"
          data-ccn="image"
          data-ccn-img="bg-img-url"
          style="background: url('.$this->content->image.');background-size:cover"
          >
          <div class="container">
            <div class="row">
              <div class="col-lg-6 col-xl-7">
                <div class="divider-two mt45 home11">
                  <p
                    class="color-white"
                    data-ccn="subtitle"
                    >'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
                  <h1
                    class="color-white text-uppercase"
                    data-ccn="title"
                    >'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h1>
                  <div id="countdown" class="row countdown home11" ccn-year="'.userdate($this->content->date, '%Y', 0).'" ccn-month="'.userdate($this->content->date, '%m', 0).'" ccn-day="'.userdate($this->content->date, '%d', 0).'" ccn-str=\'{
                    "days": "'.get_string('days').'",
                    "hours": "'.get_string('hours').'",
                    "minutes": "'.get_string('minutes').'",
                    "seconds": "'.get_string('seconds').'"}\'
                    ></div>
              </div>
              </div>
              <div class="col-lg-6 col-xl-5">
                <div class="singup-course-form">
                  <div class="scf_heading text-center mt5 mb25">
                    <h4
                      class="title m0"
                      data-ccn="form_title"
                      >'.format_text($this->content->form_title, FORMAT_HTML, array('filter' => true)).'</h4>
                    <h4
                      class="title m0"
                      data-ccn="form_subtitle"
                      >'.format_text($this->content->form_subtitle, FORMAT_HTML, array('filter' => true)).'</h4>
                  </div>
                  <div class="scf_content">
                    <div id="mc_embed_signup">
                      <form id="mc-embedded-subscribe-form" action="'.$CFG->wwwroot.'/local/contact/index.php" method="post" class="validate">
                        <div id="mc_embed_signup_scroll">';
                          $this->content->text .='
                          <div class="mc-field-group mb0">
                            <input id="name" name="name" type="name" required="required" class="" placeholder="'.get_string('name').'">
                          </div>
                          <div class="mc-field-group mb0">
                            <input id="email" name="email" type="email" required="required" class="required email" placeholder="'.get_string('email_address', 'theme_edumy').'">
                          </div>
                          <div class="mc-field-group mb0">
                            <input id="phone" name="phone" type="number" required="required" class="required phone" placeholder="'.get_string('phone', 'theme_edumy').'">
                          </div>
                          <input type="hidden" id="sesskey" name="sesskey" value="">
                          <script>document.getElementById(\'sesskey\').value = M.cfg.sesskey;</script>
                          <button
                            type="submit"
                            name="submit"
                            id="submit"
                            class="btn btn-lg btn-thm4 btn-block mb5"
                            data-ccn="button_text"
                            >'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).'</button>
                        </div>
                      </form>
                    </div>
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
