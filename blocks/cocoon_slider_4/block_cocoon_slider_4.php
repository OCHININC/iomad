<?php
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_slider_4 extends block_base {

    /**
     * Start block instance.
     */
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_slider_4');
    }

    /**
     * The block is usable in all pages
     */
     function applicable_formats() {
         $ccnBlockHandler = new ccnBlockHandler();
         return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
     }

    /**
     * Customize the block title dynamically.
     */
    function specialization() {
        // if (isset($this->config->title)) {
        //     $this->title = $this->title = format_string($this->config->title, true, ['context' => $this->context]);
        // } else {
        //     $this->title = get_string('newcustomsliderblock', 'block_cocoon_slider_4');
        // }
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->slidesnumber = '3';
          $this->config->slide_title1 = 'We Can ';
          $this->config->slide_title2 = 'We Can ';
          $this->config->slide_title3 = 'We Can ';
          $this->config->slide_title_21 = 'Teach You!';
          $this->config->slide_title_22 = 'Teach You!';
          $this->config->slide_title_23 = 'Teach You!';

          $this->config->slide_subtitle1 = 'Technology is brining a massive wave of evolution on learning things on different ways.';
          $this->config->slide_btn_text1 = 'Ready to Get Started?';
          $this->config->slide_btn_url1 = '#';
          // $this->config->image = $CFG->wwwroot.'/theme/edumy/images/home/1.jpg';
          $this->config->slide_subtitle2 = 'Technology is brining a massive wave of evolution on learning things on different ways.';
          $this->config->slide_btn_text2 = 'Ready to Get Started?';
          $this->config->slide_btn_url2 = '#';
          $this->config->slide_subtitle3 = 'Technology is brining a massive wave of evolution on learning things on different ways.';
          $this->config->slide_btn_text3 = 'Ready to Get Started?';
          $this->config->slide_btn_url3 = '#';
          $this->config->prev_1 = 'PR';
          $this->config->prev_2 = 'EV';
          $this->config->next_1 = 'NE';
          $this->config->next_2 = 'XT';
          $this->config->arrow_style = 0;

          $this->config->color_title_1 = '#0a0a0a';
          $this->config->color_title_2 = '#0a0a0a';
          $this->config->color_title_3 = '#0a0a0a';

          $this->config->color_title_2_1 = '#2441e7';
          $this->config->color_title_2_2 = '#2441e7';
          $this->config->color_title_2_3 = '#2441e7';

          $this->config->color_body_1 = '#6f7074';
          $this->config->color_body_2 = '#6f7074';
          $this->config->color_body_3 = '#6f7074';

          $this->config->color_btn_1 = '#0a0a0a';
          $this->config->color_btn_2 = '#0a0a0a';
          $this->config->color_btn_3 = '#0a0a0a';

          $this->config->color_btn_hover_1 = '#fff';
          $this->config->color_btn_hover_2 = '#fff';
          $this->config->color_btn_hover_3 = '#fff';



          include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization/specialization_ccn_carousel.php');
        }

    }

    /**
     * The block can be used repeatedly in a page.
     */
    function instance_allow_multiple() {
        return true;
    }

    /**
     * Build the block content.
     */
    function get_content() {
        global $CFG, $PAGE;

        require_once($CFG->libdir . '/filelib.php');


        if ($this->content !== NULL) {
            return $this->content;
        }

        if (!empty($this->config) && is_object($this->config)) {
          $data = $this->config;
          $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 3;
          if(!empty($this->config->style)){
            if ($data->style == 1) {
              $slidersize = 'slide slide-one home6';
            } else {
              $slidersize = 'slide slide-one sh2';
            }
          } else {
            $slidersize = 'slide slide-one sh2';
          }

          $fs = get_file_storage();
          $files = $fs->get_area_files($this->context->id, 'block_cocoon_slider_4', 'content');
          $this->content = new stdClass();
          if(!empty($this->config->image) && count($files) >= 1){$this->content->image = $this->config->image;} else { $this->content->image = $CFG->wwwroot.'/theme/edumy/images/home/1.jpg';}
          include($CFG->dirroot . '/theme/edumy/ccn/block_handler/config/config_ccn_carousel.php');
          foreach ($files as $file) {
              $filename = $file->get_filename();
              if ($filename <> '.') {
                  $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                  $this->content->image =  $url;
              }
          }
        } else {
            $data = new stdClass();
            $data->slidesnumber = '3';
        }

        $text = '';
        $bannerstyle = '';
        if ($data->slidesnumber > 1) {
          $bannerstyle .= 'home5_slider--multiple';
        } else {
          $bannerstyle .= 'home5_slider--single';
        }
        if ($data->slidesnumber > 0) {
            $text = '
            <section class="home-five bg-img5" data-ccn="image" data-ccn-img="bg-img-url" style="background-image:url('.$this->content->image.');background-size:cover;">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="home5_slider '.$bannerstyle.'" '.$ccnConfigDataCarousel.'>';
            $fs = get_file_storage();
            for ($i = 1; $i <= $data->slidesnumber; $i++) {
                $sliderimage = 'file_slide' . $i;
                $slide_title = 'slide_title' . $i;
                $slide_title_2 = 'slide_title_2' . $i;
                $slide_subtitle = 'slide_subtitle' . $i;
                $slide_btn_url = 'slide_btn_url' . $i;
                $slide_btn_text = 'slide_btn_text' . $i;
                $slide_line_break = 'slide_line_break' . $i;
                $slide_btn_target = 'slide_btn_target' . $i;

                $slide_color_title = 'color_title_' . $i;
                $slide_color_title_2 = 'color_title_2_' . $i;
                $slide_color_body = 'color_body_' . $i;
                $slide_color_btn = 'color_btn_' . $i;
                $slide_color_btn_hover = 'color_btn_hover_' . $i;


                if(!empty($data->$slide_btn_target)) {
                  $slide_btn_target = $data->$slide_btn_target;
                } else {
                  $slide_btn_target = '';
                }

                $text .= '
                <div class="item">
                  <div class="home-text">';
                  $text .='<h2><span data-ccn="slide_title'.$i.'" data-ccn-c="'.$slide_color_title.'" data-ccn-cv="'.$data->$slide_color_title.'">'.format_text($data->$slide_title, FORMAT_HTML, array('filter' => true)).'</span>';
                  if(!empty($data->$slide_line_break) && $data->$slide_line_break == '1'){
                    $text .='<br>';
                  }
                  $text .='<span data-ccn="slide_title_2'.$i.'" data-ccn-c="'.$slide_color_title_2.'" data-ccn-cv="'.$data->$slide_color_title_2.'">'. format_text($data->$slide_title_2, FORMAT_HTML, array('filter' => true)).'</span>';
                  $text .='</h2>';
                  $text .='<p data-ccn="slide_subtitle'.$i.'" data-ccn-c="'.$slide_color_body.'" data-ccn-cv="'.$data->$slide_color_body.'">'.format_text($data->$slide_subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
                  if(!empty($data->$slide_btn_text) && !empty($data->$slide_btn_url)){
                    $text .=' <a target="'.$slide_btn_target.'" class="btn home_btn" href="'.format_text($data->$slide_btn_url, FORMAT_HTML, array('filter' => true)).'"
                                data-ccn="slide_btn_text'.$i.'"
                                data-ccn-c="'.$slide_color_btn.'"
                                data-ccn-cv="'.$data->$slide_color_btn.'"
                                data-ccn-ch="'. $slide_color_btn_hover.'"
                                data-ccn-ch-co="ccnBg, ccnBd"
                                data-ccn-ch-cv="'.$data->$slide_color_btn_hover.'"
                                data-ccn-ch-self
                                >'.format_text($data->$slide_btn_text, FORMAT_HTML, array('filter' => true)).'</a>';
                  }
                  $text .='
                  </div>
                </div>';
              }
              $text .= '
              </div>
            </div>
          </div>
        </div>
      </section>';
      }

        $this->content = new stdClass;
        $this->content->footer = '';
        $this->content->text = $text;

        return $this->content;

  }


    /**
     * Serialize and store config data
     */
    function instance_config_save($data, $nolongerused = false) {
        global $CFG;

        $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                    'subdirs'       => 0,
                                    'maxfiles'      => 1,
                                    'accepted_types' => array('.jpg', '.png', '.gif'));

        for($i = 1; $i <= $data->slidesnumber; $i++) {
            $field = 'file_slide' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_slider_4', 'slides', $i, $filemanageroptions);
        }

        parent::instance_config_save($data, $nolongerused);
    }

    /**
     * When a block instance is deleted.
     */
    function instance_delete() {
        global $DB;
        $fs = get_file_storage();
        $fs->delete_area_files($this->context->id, 'block_cocoon_slider_4');
        return true;
    }

    /**
     * Copy any block-specific data when copying to a new block instance.
     * @param int $fromid the id number of the block instance to copy from
     * @return boolean
     */
    public function instance_copy($fromid) {
        global $CFG;

        $fromcontext = context_block::instance($fromid);
        $fs = get_file_storage();

        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 0;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 0;
        }

        $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                    'subdirs'       => 0,
                                    'maxfiles'      => 1,
                                    'accepted_types' => array('.jpg', '.png', '.gif'));

        for($i = 1; $i <= $data->slidesnumber; $i++) {
            $field = 'file_slide' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            // This extra check if file area is empty adds one query if it is not empty but saves several if it is.
            if (!$fs->is_area_empty($fromcontext->id, 'block_cocoon_slider_4', 'slides', $i, false)) {
                $draftitemid = 0;
                file_prepare_draft_area($draftitemid, $fromcontext->id, 'block_cocoon_slider_4', 'slides', $i, $filemanageroptions);
                file_save_draft_area_files($draftitemid, $this->context->id, 'block_cocoon_slider_4', 'slides', $i, $filemanageroptions);
            }
        }

        return true;
    }

    /**
     * The block should only be dockable when the title of the block is not empty
     * and when parent allows docking.
     *
     * @return bool
     */
    public function instance_can_be_docked() {
        return (!empty($this->config->title) && parent::instance_can_be_docked());
    }

    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }

}
