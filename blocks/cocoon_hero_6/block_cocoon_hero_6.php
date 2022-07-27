<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_hero_6 extends block_base {

    public function init() {
      $this->title = get_string('cocoon_hero_6', 'block_cocoon_hero_6');
    }

    public function specialization() {
      global $CFG, $DB;
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
      if (empty($this->config)) {
        $this->config = new \stdClass();
        $this->config->title = 'Learn From Anywhere';
        $this->config->subtitle = 'Technology is bringing a massive wave of evolution on learning things on different ways.';
        $this->config->button_text = 'Get Started';
        $this->config->button_link = '#';
        $this->config->button_text_2 = 'View Courses';
        $this->config->button_link_2 = '#';
        $this->config->color_title = '#221538';
        $this->config->color_subtitle = '#6f7074';
        $this->config->color_btn_1 = '#ff1053';
        $this->config->color_btn_2 = '#051925';
        $this->config->color_btn_1_hover = '#ff1053';
        $this->config->color_btn_2_hover = '#051925';
      }
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content         =  new stdClass;
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = ''; }
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->subtitle = ''; }
        if(!empty($this->config->button_link)){$this->content->button_link = $this->config->button_link;} else {$this->content->button_link = ''; }
        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;} else {$this->content->button_text = ''; }
        if(!empty($this->config->button_link_2)){$this->content->button_link_2 = $this->config->button_link_2;} else {$this->content->button_link_2 = ''; }
        if(!empty($this->config->button_text_2)){$this->content->button_text_2 = $this->config->button_text_2;} else {$this->content->button_text_2 = ''; }
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = '#221538'; }
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = '#6f7074'; }
        if(!empty($this->config->color_btn_1)){$this->content->color_btn_1 = $this->config->color_btn_1;} else {$this->content->color_btn_1 = '#ff1053'; }
        if(!empty($this->config->color_btn_2)){$this->content->color_btn_2 = $this->config->color_btn_2;} else {$this->content->color_btn_2 = '#051925'; }
        if(!empty($this->config->color_btn_1_hover)){$this->content->color_btn_1_hover = $this->config->color_btn_1_hover;} else {$this->content->color_btn_1_hover = '#ff1053'; }
        if(!empty($this->config->color_btn_2_hover)){$this->content->color_btn_2_hover = $this->config->color_btn_2_hover;} else {$this->content->color_btn_2_hover = '#051925'; }


        $fs = get_file_storage();
        $ccnImages_background = $CFG->wwwroot . '/theme/edumy/images/ccnBgHuge.png';
        $ccnImages_foreground = $CFG->wwwroot . '/theme/edumy/images/ccnBgMd.png';
        for ($i = 1; $i <= 2; $i++) {
          $image = 'image' . $i;
          $files = $fs->get_area_files($this->context->id, 'block_cocoon_hero_6', 'images', $i, 'sortorder DESC, id ASC', false, 0, 0, 1);
          if (count($files) >= 1) {
            $mainfile = reset($files);
            $mainfile = $mainfile->get_filename();
          } else {
            continue;
          }
          $ccnFileUrl = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/{$this->context->id}/block_cocoon_hero_6/images/" . $i . '/' . $mainfile);
          if($i === 1){
            $ccnImages_background = $ccnFileUrl;
          }
          if($i === 2){
            $ccnImages_foreground = $ccnFileUrl;
          }
        }

        $this->content->text = '
        <div class="home-twelve bg-img9" data-ccn="image" data-ccn-img="bg-img-url" style="background-image:url('.$ccnImages_background.');background-size:cover;">
          <div class="container">
            <div class="row">
              <div class="col-lg-5">
                <div class="home-text home12">
                  <h2
                    class="title"
                    data-ccn="title"
                    data-ccn-c="color_title"
                    data-ccn-co="ccnCn"
                    data-ccn-cv="'.$this->content->color_title.'">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h2>
                  <p
                    class="mb20"
                    data-ccn="subtitle"
                    data-ccn-c="color_subtitle"
                    data-ccn-co="ccnCn"
                    data-ccn-cv="'.$this->content->color_subtitle.'">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
                  <a
                    class="btn btn-lg rounded home12_btn mr10 ccn-color-white-soft ccn-trans-bg-hover"
                    href="'.format_text($this->content->button_link, FORMAT_HTML, array('filter' => true)).'"
                    data-ccn="button_text"
                    data-ccn-c="color_btn_1"
                    data-ccn-co="ccnBg, ccnBd"
                    data-ccn-cv="'.$this->content->color_btn_1.'"
                    data-ccn-ch-co="ccnCn, ccnBd"
                    data-ccn-ch-cv="'.$this->content->color_btn_1_hover.'"
                    data-ccn-ch="color_btn_1_hover"
                    data-ccn-ch-self>'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).'</a>
                  <a
                    class="btn btn-lg btn-dark rounded home12_btn ccn-color-white-soft ccn-trans-bg-hover ccn-border-1"
                    href="'.format_text($this->content->button_link_2, FORMAT_HTML, array('filter' => true)).'"
                    data-ccn="button_text_2"
                    data-ccn-c="color_btn_2"
                    data-ccn-co="ccnBd, ccnBg"
                    data-ccn-cv="'.$this->content->color_btn_2.'"
                    data-ccn-ch-co="ccnBd, ccnCn"
                    data-ccn-ch-cv="'.$this->content->color_btn_2_hover.'"
                    data-ccn-ch="color_btn_2_hover"
                    data-ccn-ch-self>'.format_text($this->content->button_text_2, FORMAT_HTML, array('filter' => true)).'</a>
                </div>
              </div>
              <div class="col-lg-7">
                <div class="animated_img home12 pt70">
                    <ul id="scene" class="scene ccn-parallax-scene">
                    <li class="layer" data-depth="0.70"><a class="moveDown" href="#0"><img src="'.$ccnImages_foreground.'" alt=""></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>';

        return $this->content;
    }


    function instance_config_save($data, $nolongerused = false) {
      global $CFG;
      $filemanageroptions = array(
        'maxbytes' => $CFG->maxbytes,
        'subdirs'       => 0,
        'maxfiles'      => 1,
        'accepted_types' => array('.jpg', '.png', '.gif')
      );
      for($i = 1; $i <= 2; $i++) {
        $field = 'image' . $i;
        if (!isset($data->$field)) {
          continue;
        }
        file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_hero_6', 'images', $i, $filemanageroptions);
      }
      parent::instance_config_save($data, $nolongerused);
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
