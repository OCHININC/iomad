<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/general_handler/ccnLazy.php');

class block_cocoon_featured_video extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('pluginname', 'block_cocoon_featured_video');
    }

    // Declare second
    public function specialization()
    {
        // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->slidesnumber = '4';
          $this->config->video_url = 'https://youtu.be/UdDwKI4DcGw';
          $this->config->title1 = 'Creative Events';
          $this->config->subtitle1 = '749';
          $this->config->subtitle_2_1 = '';
          $this->config->title2 = 'Skilled Tutor';
          $this->config->subtitle2 = '832';
          $this->config->subtitle_2_2 = '';
          $this->config->title3 = 'Online Courses';
          $this->config->subtitle3 = '35';
          $this->config->subtitle_2_3 = 'k';
          $this->config->title4 = 'People Wordwide';
          $this->config->subtitle4 = '92';
          $this->config->subtitle_2_4 = 'k';
          $this->config->color_bfbg = '#f9f9f9';
          $this->config->color_title = '#0067da';
          $this->config->color_subtitle = '#222222';
          $this->config->color_overlay = 'rgb(34, 34, 34, .4)';
        }
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content         =  new stdClass;
        if(!empty($this->config->video_url)){$this->content->video_url = $this->config->video_url;} else {$this->content->video_url = '';}

        if(!empty($this->config->color_bfbg)){$this->content->color_bfbg = $this->config->color_bfbg;} else {$this->content->color_bfbg = '#f9f9f9';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = '#0067da';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = '#222222';}
        if(!empty($this->config->color_overlay)){$this->content->color_overlay = $this->config->color_overlay;} else {$this->content->color_overlay = 'rgb(34, 34, 34, .4)';}
        $this->content->image = $CFG->wwwroot.'/theme/edumy/images/ccnBgMd.png';


        $ccnLazy = new ccnLazy();

        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 4;
        } else {
            $data = new stdClass();
            $data->slidesnumber = '4';
        }

        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_featured_video', 'content');

        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image =  $url;
            }
        }


        $this->content->text = '
        <section
          class="about-us-home13 pb20 pt0"
          data-ccn-c="color_bfbg"
          data-ccn-co="ccnBfBg"
          data-ccn-cv="'.$this->content->color_bfbg.'">
          <div class="container">
            <div class="row">
      				<div class="col-lg-10 offset-lg-1">
      					<div class="gallery_item home13 mt80">
      						<img class="img-fluid img-circle-rounded" alt="" data-ccn="image" data-ccn-img="content" '.$ccnLazy->ccnLazyImage($this->content->image).'>
      						<div
                    class="gallery_overlay"
                    data-ccn-c="color_overlay"
                    data-ccn-co="ccnBg"
                    data-ccn-cv="'.$this->content->color_overlay.'">
      							<a class="popup-img popup-youtube home_post_overlay_icon bgc-theme8" href="'.$this->content->video_url.'">
      								<div class="video_popup_btn"><span class="flaticon-play-button-1"></span></div>
      							</a>
      						</div>
      					</div>
      				</div>
      			</div>
      		</div>
      	</section>
        <section id="our-top-courses" class="our-courses pt0 pb0">
      		<div class="container pb60">
      			<div class="row">';
              if ($data->slidesnumber > 0) {
                for ($i = 1; $i <= $data->slidesnumber; $i++) {
                  $title = 'title' . $i;
                  $subtitle = 'subtitle' . $i;
                  $subtitle_2 = 'subtitle_2_' . $i;

                  $this->content->text .= '
                  <div class="col-sm-6 col-lg-3">
                    <div class="funfact_one home13 text-center">
                      <div class="details">
                        <ul>
          								<li class="list-inline-item">
                            <div
                              class="timer"
                              data-ccn="'.$subtitle.'"
                              data-ccn-c="color_title"
                              data-ccn-co="ccnCn"
                              data-ccn-cv="'.$this->content->color_title.'">'.$data->$subtitle.'</div>
                          </li>
          								<li class="list-inline-item">
                            <span
                              data-ccn="'.$subtitle_2.'"
                              data-ccn-c="color_title"
                              data-ccn-co="ccnCn"
                              data-ccn-cv="'.$this->content->color_title.'"
                              class="">'.$data->$subtitle_2.'</span></li>
          							</ul>
                        <h5
                          data-ccn="'.$title.'"
                          data-ccn-c="color_subtitle"
                          data-ccn-co="ccnCn"
                          data-ccn-cv="'.$this->content->color_subtitle.'">'.$data->$title.'</h5>
                      </div>
                    </div>
                  </div>';
                }
              }
              $this->content->text .='
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
