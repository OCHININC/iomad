<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_faqs extends block_base {

    /**
     * Start block instance.
     */
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_faqs');
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
          $this->config->title = 'Frequently Asked Questions';
          $this->config->faq_title1 = 'Why won\'t my payment go through?';
          $this->config->faq_title2 = 'How do I get a refund?';
          $this->config->faq_title3 = 'How do I redeem a coupon?';
          $this->config->faq_title4 = 'Changing account name';
          $this->config->faq_subtitle1 = 'Course Description';
          $this->config->faq_subtitle2 = 'Course Description';
          $this->config->faq_subtitle3 = 'Course Description';
          $this->config->faq_subtitle4 = 'Course Description';
          $this->config->faq_body1 = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.';
          $this->config->faq_body2 = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.';
          $this->config->faq_body3 = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.';
          $this->config->faq_body4 = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.';
          $this->config->color_bg = 'rgb(255,255,255)';
          $this->config->color_title = '#0a0a0a';
          $this->config->color_panel_bg = '#edeff7';
          $this->config->color_panel_title = '#0a0a0a';
          $this->config->color_panel_subtitle = '#3b3b3b';
          $this->config->color_panel_body = '#7e7e7e';
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

        $this->content = new stdClass();

        if(!empty($this->config->color_bg)){$this->content->color_bg = $this->config->color_bg;} else {$this->content->color_bg = '';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = '';}
        if(!empty($this->config->color_panel_bg)){$this->content->color_panel_bg = $this->config->color_panel_bg;} else {$this->content->color_panel_bg = '#edeff7';}
        if(!empty($this->config->color_panel_title)){$this->content->color_panel_title = $this->config->color_panel_title;} else {$this->content->color_panel_title = '#0a0a0a';}
        if(!empty($this->config->color_panel_subtitle)){$this->content->color_panel_subtitle = $this->config->color_panel_subtitle;} else {$this->content->color_panel_subtitle = '#3b3b3b';}
        if(!empty($this->config->color_panel_body)){$this->content->color_panel_body = $this->config->color_panel_body;} else {$this->content->color_panel_body = '#7e7e7e';}


        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 4;
            if(!empty($this->content->style)){
              if($data->style == 1) {
                $slidersize = 'slide slide-one home6';
              } else {
                $slidersize = 'slide slide-one sh2';
              }
            } else {
              $slidersize = 'slide slide-one sh2';
            }
        } else {
            $data = new stdClass();
            $data->slidesnumber = '4';
        }

        $text = '';

        if ($data->slidesnumber > 0) {
            $text = '
            <h4 class="fz20 mb30" data-ccn="title" data-ccn-c="color_title" data-ccn-co="content" data-ccn-cv="'.$this->content->color_title.'">'.format_text($data->title, FORMAT_HTML, array('filter' => true)).'</h4>
            <div class="faq_according ccn-faq_according mb25">
              <div id="accordion" class="panel-group">';
              $fs = get_file_storage();
              for ($i = 1; $i <= $data->slidesnumber; $i++) {
                $faq_title = 'faq_title' . $i;
                $faq_subtitle = 'faq_subtitle' . $i;
                $faq_body = 'faq_body' . $i;
                $faq_body_html = 'faq_html' . $i;
                $faq_body_type = 'body_type' . $i;
                $text .= '
                <div class="panel">
                  <div class="panel-heading" data-ccn-c="color_panel_bg" data-ccn-co="bg" data-ccn-cv="'.$this->content->color_panel_bg.'">
                    <h4 class="panel-title">
                      <a href="#panel-'. $this->context->id . $i.'" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion" data-ccn="'.$faq_title.'" data-ccn-c="color_panel_title" data-ccn-co="content" data-ccn-cv="'.$this->content->color_panel_title.'">'.format_text($data->$faq_title, FORMAT_HTML, array('filter' => true)).'</a>
                    </h4>
                  </div>
                  <div id="panel-'.$this->context->id . $i.'" class="panel-collapse collapse">
                    <div class="panel-body">
                      <h4 data-ccn="'.$faq_subtitle.'" data-ccn-c="color_panel_subtitle" data-ccn-co="content" data-ccn-cv="'.$this->content->color_panel_subtitle.'">'.format_text($data->$faq_subtitle, FORMAT_HTML, array('filter' => true)).'</h4>';
                      if(!empty($data->$faq_body_type) && $data->$faq_body_type == '1'){
                        $text .='<div data-ccn-c="color_panel_body" data-ccn-co="content" data-ccn-cv="'.$this->content->color_panel_body.'" data-ccn="'.$faq_body_html.'">'. format_text($data->$faq_body_html['text'], FORMAT_HTML, array('filter' => true)) .'</div>';
                      } else {
                        $text .='<p data-ccn-c="color_panel_body" data-ccn-co="content" data-ccn-cv="'.$this->content->color_panel_body.'" data-ccn="'.$faq_body.'">'.format_text($data->$faq_body, FORMAT_HTML, array('filter' => true)).'</p>';
                      }
                      $text .='
                    </div>
                  </div>
                </div>';
              }
              $text .= '
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

            file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_faqs', 'slides', $i, $filemanageroptions);
        }

        parent::instance_config_save($data, $nolongerused);
    }

    /**
     * When a block instance is deleted.
     */
    function instance_delete() {
        global $DB;
        $fs = get_file_storage();
        $fs->delete_area_files($this->context->id, 'block_cocoon_faqs');
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
            if (!$fs->is_area_empty($fromcontext->id, 'block_cocoon_faqs', 'slides', $i, false)) {
                $draftitemid = 0;
                file_prepare_draft_area($draftitemid, $fromcontext->id, 'block_cocoon_faqs', 'slides', $i, $filemanageroptions);
                file_save_draft_area_files($draftitemid, $this->context->id, 'block_cocoon_faqs', 'slides', $i, $filemanageroptions);
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
