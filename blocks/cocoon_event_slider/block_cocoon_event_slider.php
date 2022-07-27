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
class block_cocoon_event_slider extends block_base {

    /**
     * Start block instance.
     */
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_event_slider');
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
        // }
        global $CFG;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
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

        if(!empty($this->config->title)){$ccn_title = $this->config->title;}else{$ccn_title = '';}
        if(!empty($this->config->subtitle)){$ccn_subtitle = $this->config->subtitle;}else{$ccn_subtitle = '';}

        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 0;
            if ($data->style == 1) {
              $slidersize = 'slide slide-one home6';
            } else {
              $slidersize = 'slide slide-one sh2';
            }
        } else {
            $data = new stdClass();
            $data->slidesnumber = 0;
        }
        $text = '';
        if ($data->slidesnumber > 0) {
            $text = '		<section class="our-blog">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 offset-lg-3">
					<div class="main-title text-center">';
            if(!empty($ccn_title)){
						        $text .='<h3 class="mt0">'.format_text($ccn_title, FORMAT_HTML, array('filter' => true)).'</h3>';
            }
            if(!empty($ccn_subtitle)){
						        $text .='<p>'.format_text($ccn_subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
                  }
                  $text .='
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="blog_post_slider_home2">';
            $fs = get_file_storage();
            for ($i = 1; $i <= $data->slidesnumber; $i++) {
                $sliderimage = 'file_slide' . $i;
                $slide_title = 'slide_title' . $i;
                $slide_subtitle = 'slide_subtitle' . $i;
                $slide_btn_link = 'slide_btn_link' . $i;
                $slide_btn_text = 'slide_btn_text' . $i;
                $slide_time = 'slide_time' . $i;
                $slide_location = 'slide_location' . $i;
                $slide_date = 'slide_date' . $i;
                $slide_url = 'slide_url' . $i;
                if(!empty($data->$slide_url)) {
                  $slide_url = $data->$slide_url;
                } else {
                  $slide_url = '';
                }

                if (!empty($data->$sliderimage)) {
                    $files = $fs->get_area_files($this->context->id, 'block_cocoon_event_slider', 'slides', $i, 'sortorder DESC, id ASC', false, 0, 0, 1);
                    if (count($files) >= 1) {
                        $mainfile = reset($files);
                        $mainfile = $mainfile->get_filename();
                    } else {
                        continue;
                    }

                    $text .= '
                    <div class="item" data-ccn-slide>';
                    if($slide_url){
                      $text .='
                      <a href="'.$slide_url.'">';
                    }
                    $text .='
							          <div class="blog_post_home2">
								          <div class="bph2_header">
									          <img class="img-fluid" src="' . moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/{$this->context->id}/block_cocoon_event_slider/slides/" . $i . '/' . $mainfile) . '" alt="">';
                  if (!empty($data->$sliderimage)) {
								$text .='<div class="bph2_date_meta">
										      <span class="year" data-ccn="'.$slide_date.'">'.userdate($data->$slide_date, '%d').' <br> '.userdate($data->$slide_date, '%B').'</span>
									       </div>';
                }
								$text .='
                </div>
								<div class="details">
									<div class="post_meta">
										<ul>';
                    if (!empty($data->$slide_time)) {
										$text .='<li class="list-inline-item"><span><i class="flaticon-calendar"></i> <span data-ccn="'.$slide_time.'">'.format_text($data->$slide_time, FORMAT_HTML, array('filter' => true)).'</span></span></li>';
                    }
                    if (!empty($data->$slide_location)) {
										$text .='<li class="list-inline-item"><span><i class="flaticon-placeholder"></i> <span data-ccn="'.$slide_location.'">'. format_text($data->$slide_location, FORMAT_HTML, array('filter' => true)).'</span></span></li>';
                    }
										$text .='
                    </ul>
									</div>';
                  if (!empty($data->$slide_title)) {
                    $text .='	<h4 data-ccn="'.$slide_title.'">'. format_text($data->$slide_title, FORMAT_HTML, array('filter' => true)).'</h4>';
                  }
                    $text .=' </div>
                  </div>';
                  if($slide_url){
                    $text .='
                    </a>';
                  }
                  $text .='
                </div>';
                }

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

            file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_event_slider', 'slides', $i, $filemanageroptions);
        }

        parent::instance_config_save($data, $nolongerused);
    }

    /**
     * When a block instance is deleted.
     */
    function instance_delete() {
        global $DB;
        $fs = get_file_storage();
        $fs->delete_area_files($this->context->id, 'block_cocoon_event_slider');
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
            if (!$fs->is_area_empty($fromcontext->id, 'block_cocoon_event_slider', 'slides', $i, false)) {
                $draftitemid = 0;
                file_prepare_draft_area($draftitemid, $fromcontext->id, 'block_cocoon_event_slider', 'slides', $i, $filemanageroptions);
                file_save_draft_area_files($draftitemid, $this->context->id, 'block_cocoon_event_slider', 'slides', $i, $filemanageroptions);
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
