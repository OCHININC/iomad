<?php
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_slider_2 extends block_base {

  function init() {
    $this->title = get_string('pluginname', 'block_cocoon_slider_2');
  }

  function applicable_formats() {
    $ccnBlockHandler = new ccnBlockHandler();
    return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
  }

  function specialization() {
    global $CFG, $DB;
    include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
    if (empty($this->config)) {
      $this->config = new \stdClass();
      $this->config->slidesnumber = '3';
      $this->config->slide_title1 = 'Self Education Resources and Infos';
      $this->config->slide_subtitle1 = 'Technology is brining a massive wave of evolution on learning things on different ways.';
      $this->config->slide_btn_text1 = 'Ready to Get Started?';
      $this->config->slide_btn_url1 = '#';
      $this->config->slide_title2 = 'Self Education Resources and Infos';
      $this->config->slide_subtitle2 = 'Technology is brining a massive wave of evolution on learning things on different ways.';
      $this->config->slide_btn_text2 = 'Ready to Get Started?';
      $this->config->slide_btn_url2 = '#';
      $this->config->slide_title3 = 'Self Education Resources and Infos';
      $this->config->slide_subtitle3 = 'Technology is brining a massive wave of evolution on learning things on different ways.';
      $this->config->slide_btn_text3 = 'Ready to Get Started?';
      $this->config->slide_btn_url3 = '#';
      $this->config->prev_1 = 'PR';
      $this->config->prev_2 = 'EV';
      $this->config->next_1 = 'NE';
      $this->config->next_2 = 'XT';
      $this->config->arrow_style = 0;
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization/specialization_ccn_carousel.php');
    }
  }

  function ccnIterable($args = NULL, $i = NULL) {

    if($i === NULL) {
      $i = '_x_ccnI';
    }
    if($args === NULL) {
      $args = new \stdClass();

      $fieldFileSlide = 'file_slide'.$i;
      $fieldSlideTitle = 'slide_title'.$i;
      $fieldSlideSubtitle = 'slide_subtitle'.$i;
      $fieldButtonUrl = 'slide_btn_url'.$i;
      $fieldButtonTarget = 'slide_btn_target'.$i;
      $fieldButtonText = 'slide_btn_text'.$i;

      $args->$fieldFileSlide = 'test';
      $args->$fieldSlideTitle = 'test';
      $args->$fieldSlideSubtitle = 'test';
      $args->$fieldButtonUrl = 'test';
      $args->$fieldButtonTarget = 'test';
      $args->$fieldButtonText = 'test';
    }
    // var_dump($args);

    return '
    <div class="'.$slidersize.'" data-ccn-slide data-ccn="'.$fieldFileSlide.'" data-ccn-img="bg-img-url" style="background-image: url('.$data->$sliderimage.');">
     <div class="container">
         <div class="row">
             <div class="col-lg-12 text-center">
               <h3 data-ccn="'.$fieldSlideTitle.'" class="banner-title">'.format_text($fieldSlideTitle, FORMAT_HTML, array('filter' => true)).'</h3>
               <p data-ccn="'.$fieldSlideSubtitle.'">'.format_text($fieldSlideSubtitle, FORMAT_HTML, array('filter' => true)).'</p>
               <div class="btn-block">
                          <a data-ccn="'.$fieldSlideButtonText.'" target="" href="'.format_text($data->$slide_btn_url, FORMAT_HTML, array('filter' => true)).'" class="banner-btn">'.format_text($args->$fieldSlideButtonText, FORMAT_HTML, array('filter' => true)).'</a>
                        </div>
                        </div>
         </div>
     </div>
     </div>';

  }

  function instance_allow_multiple() {
    return false;
  }

  function get_content() {
    global $CFG, $PAGE;
    require_once($CFG->libdir . '/filelib.php');

    if ($this->content !== NULL) {
        return $this->content;
    }

    if (!empty($this->config) && is_object($this->config)) {
      $data = $this->config;
      $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 3;
      if ($data->style == 1) {
        $slidersize = 'slide slide-one home6';
      } else {
        $slidersize = 'slide slide-one sh2';
      }
    } else {
      $data = new \stdClass();
      $data->slidesnumber = '3';
    }

    $this->content = new \stdClass();
    if(!empty($this->config->prev_1)){$this->content->prev_1 = $this->config->prev_1;}else{$this->content->prev_1 = 'PR';}
    if(!empty($this->config->prev_2)){$this->content->prev_2 = $this->config->prev_2;}else{$this->content->prev_2 = 'EV';}
    if(!empty($this->config->next_1)){$this->content->next_1 = $this->config->next_1;}else{$this->content->next_1 = 'NE';}
    if(!empty($this->config->next_2)){$this->content->next_2 = $this->config->next_2;}else{$this->content->next_2 = 'XT';}
    if(!empty($this->config->prev)){$this->content->prev = $this->config->prev;}else{$this->content->prev = 'PREV';}
    if(!empty($this->config->next)){$this->content->next = $this->config->next;}else{$this->content->next = 'NEXT';}
    if(!empty($this->config->arrow_style)){$this->content->arrow_style = $this->config->arrow_style;} else {$this->content->arrow_style = '0';}
    include($CFG->dirroot . '/theme/edumy/ccn/block_handler/config/config_ccn_carousel.php');

    $text = '';
    $bannerstyle = '';
    if ($data->slidesnumber > 1) {
      $bannerstyle .= 'banner-style-one--multiple';
    } else {
      $bannerstyle .= 'banner-style-one--single';
    }
    if ($data->slidesnumber > 0) {
    $text = '
    <div class="home2-slider">
    	<div class="container-fluid p0">
    		<div class="row">
    			<div class="col-lg-12">
    				<div class="main-banner-wrapper">
    				  <div class="banner-style-one owl-theme owl-carousel '.$bannerstyle.'" '.$ccnConfigDataCarousel.'>';
              $fs = get_file_storage();
              for ($i = 1; $i <= $data->slidesnumber; $i++) {
                $sliderimage = 'file_slide' . $i;
                $slide_title = 'slide_title' . $i;
                $slide_subtitle = 'slide_subtitle' . $i;
                $slide_btn_url = 'slide_btn_url' . $i;
                $slide_btn_text = 'slide_btn_text' . $i;
                $slide_btn_target = 'slide_btn_target' . $i;
                if(!empty($data->$slide_btn_target)) {
                  $slide_btn_target = $data->$slide_btn_target;
                } else {
                  $slide_btn_target = '';
                }
                $files = $fs->get_area_files($this->context->id, 'block_cocoon_slider_2', 'slides', $i, 'sortorder DESC, id ASC', false, 0, 0, 1);
                if (!empty($data->$sliderimage) && count($files) >= 1) {
                  $mainfile = reset($files);
                  $mainfile = $mainfile->get_filename();
                  $data->$sliderimage = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/{$this->context->id}/block_cocoon_slider_2/slides/" . $i . '/' . $mainfile);
                } else {
                  $data->$sliderimage = $CFG->wwwroot .'/theme/edumy/images/home/1.jpg';
                }

                $text .= '
                <div class="'.$slidersize.'" data-ccn-slide data-ccn="file_slide'.$i.'" data-ccn-img="bg-img-url" style="background-image: url('.$data->$sliderimage.');">
                 <div class="container">
                     <div class="row">
                         <div class="col-lg-12 text-center">';
                         if (!empty($data->$slide_title)) {
                           $text .='<h3 data-ccn="slide_title'.$i.'" class="banner-title">'.format_text($data->$slide_title, FORMAT_HTML, array('filter' => true)).'</h3>';
                         }
                         if (!empty($data->$slide_subtitle)) {
                           $text .='<p data-ccn="slide_subtitle'.$i.'">'.format_text($data->$slide_subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
                         }
                         if (!empty($data->$slide_btn_url) && !empty($data->$slide_btn_text)) {
                           $text .='<div class="btn-block">
                                      <a data-ccn="slide_btn_text'.$i.'" target="'.$slide_btn_target.'" href="'.format_text($data->$slide_btn_url, FORMAT_HTML, array('filter' => true)).'" class="banner-btn">'.format_text($data->$slide_btn_text, FORMAT_HTML, array('filter' => true)).'</a>
                                    </div>';
                         }
                         $text .='</div>
                     </div>
                 </div>
             </div>';
            }
            $text .= '
            </div>';
            if($this->content->arrow_style != '2' && $data->slidesnumber > 1) {
             $text .='
            <div class="carousel-btn-block banner-carousel-btn">
              <span class="carousel-btn left-btn">
                <i class="flaticon-left-arrow left"></i> ';
                if($this->content->arrow_style != '1'){
                  $text .=' <span class="left">'.$this->content->prev_1.' <br> '.$this->content->prev_2.'</span>';
                } else {
                  $text .=' <span class="left">'.$this->content->prev.'</span>';
                }
                $text .='
              </span>
                  <span class="carousel-btn right-btn">';
                  if($this->content->arrow_style != '1'){
                    $text .='<span class="right">'.$this->content->next_1.' <br> '.$this->content->next_2.'</span> <i class="flaticon-right-arrow-1 right"></i>';
                  } else {
                    $text .='<span class="right">'.$this->content->next.'</span> <i class="flaticon-right-arrow-1 right"></i>';
                  }
                  $text .='
                  </span>
              </div><!-- /.carousel-btn-block banner-carousel-btn -->';
            }
            $text .='
					</div><!-- /.main-banner-wrapper -->
				</div>
			</div>
		</div>
	</div>';
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

            file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_slider_2', 'slides', $i, $filemanageroptions);
        }

        parent::instance_config_save($data, $nolongerused);
    }

    /**
     * When a block instance is deleted.
     */
    function instance_delete() {
        global $DB;
        $fs = get_file_storage();
        $fs->delete_area_files($this->context->id, 'block_cocoon_slider_2');
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
            if (!$fs->is_area_empty($fromcontext->id, 'block_cocoon_slider_2', 'slides', $i, false)) {
                $draftitemid = 0;
                file_prepare_draft_area($draftitemid, $fromcontext->id, 'block_cocoon_slider_2', 'slides', $i, $filemanageroptions);
                file_save_draft_area_files($draftitemid, $this->context->id, 'block_cocoon_slider_2', 'slides', $i, $filemanageroptions);
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
