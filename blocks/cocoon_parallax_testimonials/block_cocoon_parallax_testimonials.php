<?php
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_parallax_testimonials extends block_base {

    /**
     * Start block instance.
     */
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_parallax_testimonials');
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
        global $CFG, $DB;

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->title = 'What People Say';
          $this->config->subtitle = 'Cum doctus civibus efficiantur in imperdiet deterruisset.';
          $this->config->slidesnumber = '5';
          $this->config->slide_title1 = 'Augusta Silva';
          $this->config->subtitle1 = 'Client';
          $this->config->body1 = 'Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.';
          $this->config->image1 = $CFG->wwwroot.'/theme/edumy/images/ccnBgSm.png';
          $this->config->slide_title2 = 'Augusta Silva';
          $this->config->subtitle2 = 'Client';
          $this->config->body2 = 'Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.';
          $this->config->image2 = $CFG->wwwroot.'/theme/edumy/images/ccnBgSm.png';
          $this->config->slide_title3 = 'Augusta Silva';
          $this->config->subtitle3 = 'Client';
          $this->config->body3 = 'Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.';
          $this->config->image3 = $CFG->wwwroot.'/theme/edumy/images/ccnBgSm.png';
          $this->config->slide_title4 = 'Augusta Silva';
          $this->config->subtitle4 = 'Client';
          $this->config->body4 = 'Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.';
          $this->config->image4 = $CFG->wwwroot.'/theme/edumy/images/ccnBgSm.png';
          $this->config->slide_title5 = 'Augusta Silva';
          $this->config->subtitle5 = 'Client';
          $this->config->body5 = 'Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.';
          $this->config->image5 = $CFG->wwwroot.'/theme/edumy/images/ccnBgSm.png';
          $this->config->color_bg = '#2441e7';
          $this->config->color_title = '#ffffff';
          $this->config->color_subtitle = '#ffffff';
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
        $this->content         =  new \stdClass();
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->subtitle = '';}
        if(!empty($this->config->color_bg)){$this->content->color_bg = $this->config->color_bg;} else {$this->content->color_bg = '#2441e7';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = '#fff';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = '';}

        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 5;
        } else {
            $data = new stdClass();
            $data->slidesnumber = '5';
        }

        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_parallax_testimonials', 'slides', '0');
        $ccn_image = '';
        $ccn_styles = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/{$this->context->id}/block_cocoon_parallax_testimonials/slides/0/" . $filename);
                $ccn_image .=  $url;
                $ccn_styles .= 'background-image:url('.$ccn_image.');background-size:cover;';
            }
        }
        $text = '';
        if ($data->slidesnumber > 0) {
            $text = '
            <style type="text/css">
            .ccn-parallax-bg-'.$this->instance->id.':before{
              background: '.$this->content->color_bg.';
            }
            </style>
            <section class="parallax bg-img2 divider_home1 ccn-parallax-bg-'.$this->instance->id.'" data-stellar-background-ratio="0.5"  data-ccn="image" data-ccn-img="bg-img-url" style="'.$ccn_styles.'">
          		<div class="container">
          			<div class="row">
          				<div class="col-lg-6 offset-lg-3">
          					<div class="main-title text-center">
          						<h3 class="ccn-color-white-soft mt0" data-ccn="title" data-ccn-c="color_title" data-ccn-co="content" data-ccn-cv="'.$this->content->color_title.'">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
          						<p class="ccn-color-white-soft" data-ccn="subtitle" data-ccn-c="color_subtitle" data-ccn-co="content" data-ccn-cv="'.$this->content->color_subtitle.'">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
          					</div>
          				</div>
          			</div>
                <div class="row">
                  <div class="col-lg-6 offset-lg-3">
                    <div class="testimonial_grid_slider">';
            $fs = get_file_storage();
            for ($i = 1; $i <= $data->slidesnumber; $i++) {
              $sliderimage = 'image' . $i;
              $slide_title = 'slide_title' . $i;
              $subtitle = 'subtitle' . $i;
              $body = 'body' . $i;
              $style = 'style' . $i;
              $files = $fs->get_area_files($this->context->id, 'block_cocoon_parallax_testimonials', 'slides', $i, 'sortorder DESC, id ASC', false, 0, 0, 1);
              if (!empty($data->$sliderimage) && count($files) >= 1) {
                $mainfile = reset($files);
                $mainfile = $mainfile->get_filename();
                $data->$sliderimage = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/{$this->context->id}/block_cocoon_parallax_testimonials/slides/" . $i . '/' . $mainfile);
              } else {
                $data->$sliderimage = $CFG->wwwroot.'/theme/edumy/images/ccnBgSm.png';
              }
              $text .= '
              <div class="item">
                <div class="testimonial_grid">';
                if (!empty($data->$sliderimage)) {
                  $text .='
                  <div class="thumb">
                    <img src="' . $data->$sliderimage .' " alt="">
                  </div>';
                }
                $text .='
                  <div class="details">
                    <h4 data-ccn="slide_title'.$i.'">'.format_text($data->$slide_title, FORMAT_HTML, array('filter' => true)).'</h4>
                    <p data-ccn="subtitle'.$i.'">'.format_text($data->$subtitle, FORMAT_HTML, array('filter' => true)).'</p>
                    <p data-ccn="body'.$i.'" class="mt25">'.format_text($data->$body, FORMAT_HTML, array('filter' => true)).'</p>
                  </div>
                </div>
              </div>';
            }
            $text .= '
            </div>
				</div>
			</div>

		</div>
	</section>
  <script type="text/javascript">
  (function($){
    $(window).on("load", function() {

  if($(".testimonial_grid_slider").length){
        $(".testimonial_grid_slider").owlCarousel({
            loop:true,
            margin:15,
            dots:true,
            nav:false,
            rtl:false,
            autoplayHoverPause:false,
            autoplay: false,
            singleItem: true,
            smartSpeed: 1200,
            navText: [
              \'<i class="fa fa-arrow-left"></i>\',
              \'<i class="fa fa-arrow-right"></i>\'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480:{
                    items:1,
                    center: false
                },
                600: {
                    items: 1,
                    center: false
                },
                768: {
                    items: 1
                },
                992: {
                    items: 1
                },
                1200: {
                    items: 1
                }
            }
        })
    }
  });
  }(jQuery));
    </script>
';
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
            $field = 'image' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_parallax_testimonials', 'slides', $i, $filemanageroptions);
        }

        parent::instance_config_save($data, $nolongerused);
    }

    /**
     * When a block instance is deleted.
     */
    function instance_delete() {
        global $DB;
        $fs = get_file_storage();
        $fs->delete_area_files($this->context->id, 'block_cocoon_parallax_testimonials');
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
            $field = 'image' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            // This extra check if file area is empty adds one query if it is not empty but saves several if it is.
            if (!$fs->is_area_empty($fromcontext->id, 'block_cocoon_parallax_testimonials', 'slides', $i, false)) {
                $draftitemid = 0;
                file_prepare_draft_area($draftitemid, $fromcontext->id, 'block_cocoon_parallax_testimonials', 'slides', $i, $filemanageroptions);
                file_save_draft_area_files($draftitemid, $this->context->id, 'block_cocoon_parallax_testimonials', 'slides', $i, $filemanageroptions);
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
