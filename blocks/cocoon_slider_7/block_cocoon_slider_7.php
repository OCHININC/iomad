<?php
defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot. '/course/renderer.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_slider_7 extends block_base {

    /**
     * Start block instance.
     */
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_slider_7');
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
          $this->config->slidesnumber = '4';
          $this->config->title_1 = 'With Edumy, Learning ';
          $this->config->title_2_1 = 'Never Ends';
          $this->config->subtitle_1 = 'Watch our video';
          $this->config->video_1 = 'https://www.youtube.com/watch?v=UdDwKI4DcGw';
          // $this->config->image_1 = $CFG->wwwroot.'/theme/edumy/images/home/1.jpg';
          $this->config->title_2 = 'Learn Remotely From ';
          $this->config->title_2_2 = 'Anywhere';
          $this->config->subtitle_2 = 'Watch our video';
          $this->config->video_2 = 'https://www.youtube.com/watch?v=UdDwKI4DcGw';
          // $this->config->image_2 = $CFG->wwwroot.'/theme/edumy/images/home/1.jpg';
          $this->config->title_3 = 'Experience New Heights ';
          $this->config->title_2_3 = 'of Education';
          $this->config->subtitle_3 = 'Watch our video';
          $this->config->video_3 = 'https://www.youtube.com/watch?v=UdDwKI4DcGw';
          // $this->config->image_3 = $CFG->wwwroot.'/theme/edumy/images/home/1.jpg';
          $this->config->title_3 = 'Access Your Free Course  ';
          $this->config->title_2_3 = 'Today';
          $this->config->subtitle_3 = 'Watch our video';
          $this->config->video_3 = 'https://www.youtube.com/watch?v=UdDwKI4DcGw';
          // $this->config->image_3 = $CFG->wwwroot.'/theme/edumy/images/home/1.jpg';
          $this->config->title_4 = 'Learn From Anywhere, On  ';
          $this->config->title_2_4 = 'Any Device';
          $this->config->subtitle_4 = 'Watch our video';
          $this->config->video_4 = 'https://www.youtube.com/watch?v=UdDwKI4DcGw';
          // $this->config->image_4 = $CFG->wwwroot.'/theme/edumy/images/home/1.jpg';
          $this->config->button_type_1 = '0';
          $this->config->button_type_2 = '0';
          $this->config->button_type_3 = '0';
          $this->config->button_type_4 = '0';
          $this->config->button_text_1 = 'Learn more';
          $this->config->button_text_2 = 'Learn more';
          $this->config->button_text_3 = 'Learn more';
          $this->config->button_text_4 = 'Learn more';
          $this->config->button_link_1 = '#';
          $this->config->button_link_2 = '#';
          $this->config->button_link_3 = '#';
          $this->config->button_link_4 = '#';

          include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization/specialization_ccn_carousel.php');

        }

    }

    /**
     * The block can be used repeatedly in a page.
     */
    function instance_allow_multiple() {
        return false;
    }

    /**
     * Build the block content.
     */
    function get_content() {
        global $CFG, $PAGE, $COURSE, $DB;

        require_once($CFG->libdir . '/filelib.php');


        if ($this->content !== NULL) {
            return $this->content;
        }

        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 4;
        } else {
            $data = new stdClass();
            $data->slidesnumber = '4';
        }
        $this->content = new stdClass();
        if(!empty($this->config->prev_1)){$this->content->prev_1 = $this->config->prev_1;}
        if(!empty($this->config->prev_2)){$this->content->prev_2 = $this->config->prev_2;}
        if(!empty($this->config->next_1)){$this->content->next_1 = $this->config->next_1;}
        if(!empty($this->config->next_2)){$this->content->next_2 = $this->config->next_2;}
        if(!empty($this->config->prev)){$this->content->prev = $this->config->prev;}
        if(!empty($this->config->next)){$this->content->next = $this->config->next;}
        if(!empty($this->config->arrow_style)){$this->content->arrow_style = $this->config->arrow_style;}
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



            <div class="home14-slider">
            		<div class="container maxw1500">
            			<div class="row">
            				<div class="col-lg-12">
            					<div class="main-banner-wrapper">
            					    <div class="ccn-banner-style-boxed banner-style-one '.$bannerstyle.' owl-theme owl-carousel home14" '.$ccnConfigDataCarousel.'>';



                  $fs = get_file_storage();
                  for ($i = 1; $i <= $data->slidesnumber; $i++) {
                      $sliderimage = 'image_' . $i;
                      $slide_title = 'title_' . $i;
                      $slide_title_2 = 'title_2_' . $i;
                      $slide_subtitle = 'subtitle_' . $i;
                      $video = 'video_' . $i;
                      $btn_type = 'button_type_'.$i;
                      $btn_text = 'button_text_'.$i;
                      $btn_link = 'button_link_'.$i;

                      if($i == 1){
                        $class = 'active';
                      } else {
                        $class = '';
                      }

                      $files = $fs->get_area_files($this->context->id, 'block_cocoon_slider_7', 'slides', $i, 'sortorder DESC, id ASC', false, 0, 0, 1);
                      if (!empty($data->$sliderimage) && count($files) >= 1) {
                        $mainfile = reset($files);
                        $mainfile = $mainfile->get_filename();
                        $data->$sliderimage = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/{$this->context->id}/block_cocoon_slider_7/slides/" . $i . '/' . $mainfile);
                      } else {
                        $data->$sliderimage = $CFG->wwwroot .'/theme/edumy/images/home/1.jpg';
                      }

                          $text .= '

                          <div class="slide slide-one home14" style="background-image: url(' . $data->$sliderimage . ');">
                              <div class="container">
                                  <div class="row">
                                      <div class="col-lg-8 offset-lg-2 text-center">
                                          <div class="banner-sub-title text-capitalize fw400" data-ccn="'.$slide_title.'">'.format_text($data->$slide_title, FORMAT_HTML, array('filter' => true)).'</div>
                                          <div class="banner-title text-capitalize fwb mb25" data-ccn="'.$slide_title_2.'">'.format_text($data->$slide_title_2, FORMAT_HTML, array('filter' => true)).'</div>
                                          <div class="btn-block">
                                              <a data-ccn="'.$btn_text.'" href="'.$data->$btn_link.'" class="banner-btn bdrs3">'.format_text($data->$btn_text, FORMAT_HTML, array('filter' => true)).'</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                        ';
                  }

$text .= '



</div>




';
if($data->slidesnumber > 1){
  $text .= '
  <div class="carousel-btn-block banner-carousel-btn">
      <span class="carousel-btn left-btn"><i class="flaticon-back left"></i></span>
      <span class="carousel-btn right-btn"><i class="flaticon-right-arrow right"></i></span>
  </div><!-- /.carousel-btn-block banner-carousel-btn -->';
}
$text .= '
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
            $field = 'image_' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_slider_7', 'slides', $i, $filemanageroptions);
        }

        parent::instance_config_save($data, $nolongerused);
    }

    /**
     * When a block instance is deleted.
     */
    function instance_delete() {
        global $DB;
        $fs = get_file_storage();
        $fs->delete_area_files($this->context->id, 'block_cocoon_slider_7');
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
            $field = 'image_' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            // This extra check if file area is empty adds one query if it is not empty but saves several if it is.
            if (!$fs->is_area_empty($fromcontext->id, 'block_cocoon_slider_7', 'slides', $i, false)) {
                $draftitemid = 0;
                file_prepare_draft_area($draftitemid, $fromcontext->id, 'block_cocoon_slider_7', 'slides', $i, $filemanageroptions);
                file_save_draft_area_files($draftitemid, $this->context->id, 'block_cocoon_slider_7', 'slides', $i, $filemanageroptions);
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
