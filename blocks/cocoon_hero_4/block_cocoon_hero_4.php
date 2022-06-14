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

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_hero_4 extends block_base {

    /**
     * Initialises the block.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_cocoon_hero_4');
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
        //     $this->title = get_string('newcustomsliderblock', 'block_cocoon_hero_4');
        // }
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->title = 'Learn From';
          $this->config->title_2 = 'Anywhere';
          $this->config->subtitle = 'Technology is bringing a massive wave of evolution on learning things in different ways.';
          $this->config->form_title = 'Get your free personalized course list';
          $this->config->form_text = 'Your data is safe and secure with Edumy. We never share your data.';
          $this->config->form_icon = 'ccn-flaticon-locked';
          $this->config->form_button_text = 'Recommend My Courses';
          $this->config->feature_1_title = 'Design: Over 800 Courses';
          $this->config->feature_2_title = 'Business: Over 1,400 Courses';
          $this->config->feature_3_title = 'Photography: Over 740 Courses';
          $this->config->feature_4_title = 'Marketing: Over 200 Courses';
          $this->config->feature_1_icon = 'flaticon-pencil';
          $this->config->feature_2_icon = 'flaticon-student-1';
          $this->config->feature_3_icon = 'flaticon-photo-camera';
          $this->config->feature_4_icon = 'flaticon-medal';
          $this->config->color_title = '#fff';
          $this->config->color_title_2 = '#fff';
          $this->config->color_subtitle = '#fff';
          $this->config->color_features = '#fff';
          $this->config->color_form_title = '#cdbe9c';
          $this->config->color_form_button = '#3e4448';


        }
    }

    /**
     * The block can be used repeatedly in a page.
     */
    function instance_allow_multiple() {
        return false;
    }

    /**
     * Gets the block contents.
     *
     * If we can avoid it better not check the server status here as connecting
     * to the server will slow down the whole page load.
     *
     * @return string The block HTML.
     */
    public function get_content() {
        global $OUTPUT, $CFG, $PAGE;

        require_once($CFG->libdir . '/filelib.php');

        if ($this->content !== null) {
            return $this->content;
        }

        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            // $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 3;
        } else {
            $data = new stdClass();
            // $data->slidesnumber = '3';
        }

        $this->content = new stdClass();
        $this->content->footer = '';
        $this->content->text = '';
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->title_2)){$this->content->title_2 = $this->config->title_2;} else {$this->content->title_2 = '';}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->subtitle = '';}
        if(!empty($this->config->form_title)){$this->content->form_title = $this->config->form_title;} else {$this->content->form_title = '';}
        if(!empty($this->config->form_text)){$this->content->form_text = $this->config->form_text;} else {$this->content->form_text = '';}
        if(!empty($this->config->form_icon)){$this->content->form_icon = $this->config->form_icon;} else {$this->content->form_icon = '';}
        if(!empty($this->config->form_button_text)){$this->content->form_button_text = $this->config->form_button_text;} else {$this->content->form_button_text = '';}
        if(!empty($this->config->image)){$this->content->image = $this->config->image;} else {$this->content->image = $CFG->wwwroot.'/theme/edumy/images/home/ccnBg.png';;}
        if(!empty($this->config->feature_1_title)){$this->content->feature_1_title = $this->config->feature_1_title;} else {$this->content->feature_1_title = '';}
        if(!empty($this->config->feature_1_icon)){$this->content->feature_1_icon = $this->config->feature_1_icon;} else {$this->content->feature_1_icon = '';}
        if(!empty($this->config->feature_2_title)){$this->content->feature_2_title = $this->config->feature_2_title;} else {$this->content->feature_2_title = '';}
        if(!empty($this->config->feature_2_icon)){$this->content->feature_2_icon = $this->config->feature_2_icon;} else {$this->content->feature_2_icon = '';}
        if(!empty($this->config->feature_3_title)){$this->content->feature_3_title = $this->config->feature_3_title;} else {$this->content->feature_3_title = '';}
        if(!empty($this->config->feature_3_icon)){$this->content->feature_3_icon = $this->config->feature_3_icon;} else {$this->content->feature_3_icon = '';}
        if(!empty($this->config->feature_4_title)){$this->content->feature_4_title = $this->config->feature_4_title;} else {$this->content->feature_4_title = '';}
        if(!empty($this->config->feature_4_icon)){$this->content->feature_4_icon = $this->config->feature_4_icon;} else {$this->content->feature_4_icon = '';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = '#fff';}
        if(!empty($this->config->color_title_2)){$this->content->color_title_2 = $this->config->color_title_2;} else {$this->content->color_title_2 = '#fff';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = '#fff';}
        if(!empty($this->config->color_features)){$this->content->color_features = $this->config->color_features;} else {$this->content->color_features = '#fff';}
        if(!empty($this->config->color_form_title)){$this->content->color_form_title = $this->config->color_form_title;} else {$this->content->color_form_title = '#cdbe9c';}
        if(!empty($this->config->color_form_button)){$this->content->color_form_button = $this->config->color_form_button;} else {$this->content->color_form_button = '#3e4448';}




        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_hero_4', 'content');
        $this->content->image = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image .=  $url;
            }
        }


        $this->content->text .= '
          <section class="home-one home5-overlay home5_bgi5" style="background-image:url('.$this->content->image.')">
            <div class="container">
              <div class="row posr">
                <div class="col-lg-7">
        					<div class="home_content home5">
        						<div class="home-text home5">
        							<h2><span class="ccn-text-light" data-ccn="title" data-ccn-c="color_title" data-ccn-co="content" data-ccn-cv="'.$this->content->color_title.'">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</span> <span data-ccn="title_2" data-ccn-c="color_title_2" data-ccn-co="content" data-ccn-cv="'.$this->content->color_title_2.'">'.format_text($this->content->title_2, FORMAT_HTML, array('filter' => true)).'</span></h2>
        							<p class="discounts_para color-white" data-ccn="subtitle" data-ccn-c="color_subtitle" data-ccn-co="content" data-ccn-cv="'.$this->content->color_subtitle.'">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
        						</div>
        					</div>
        				</div>
        				<div class="col-lg-5">
        					<div class="home_content home5 style2">
        						<div class="home1-advnc-search home5">
        							<form class="home5_advanced_search_form" action="'.$CFG->wwwroot.'/local/contact/index.php" method="post">
                        <div class="ccn-form-header" data-ccn="form_title" data-ccn-c="color_form_title" data-ccn-co="bg" data-ccn-cv="'.$this->content->color_form_title.'">'.format_text($this->content->form_title, FORMAT_HTML, array('filter' => true)).'</div>
                        <div class="form-group">
                          <input id="name" name="name" type="name" required="required" class="form-control" placeholder="'.get_string('firstname').'" value="">
                        </div>
                        <div class="form-group">
                          <input id="last_name" name="last_name" type="last_name" required="required" class="form-control" placeholder="'.get_string('lastname').'" value="">
                        </div>
                        <div class="form-group">
                          <input id="email" name="email" type="email" required="required" class="form-control" placeholder="'.get_string('email').'">
                        </div>
                        <div class="form-group">
                          <input id="interests" name="interests" type="interests" required="required" class="form-control" placeholder="'.get_string('interested_in', 'theme_edumy').'">
                        </div>
                        <div class="form-group ccn-form-icon">
                          <div class="ccn-form-icon-holder">
                            <span data-ccn="form_icon" class="ccn-flaticon-locked"></span>
                          </div>
                          <div class="ccn-form-icon-text">
                            <p data-ccn="form_text">'.format_text($this->content->form_text, FORMAT_HTML, array('filter' => true)).'</p>
                          </div>
                        </div>
                        <input type="hidden" id="sesskey" name="sesskey" value="">
                        <script>document.getElementById(\'sesskey\').value = M.cfg.sesskey;</script>
                        <div class="search_option_button home5">
                          <button type="submit" name="submit" id="submit" class="btn btn-block" data-ccn="form_button_text" data-ccn-c="color_form_button" data-ccn-co="bg" data-ccn-cv="'.$this->content->color_form_button.'">'.format_text($this->content->form_button_text, FORMAT_HTML, array('filter' => true)).'</button>
                        </div>
        							</form>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        	</section>

          <div class="top_courses_iconbox">
            <div class="container">
              <div class="row row_home4">
                <div class="col-md-9">
                  <div class="row ">
                    <div class="col-sm-6 col-lg-3">
                      <div class="home_icon_box home4">
                        <div class="icon ccn_icon_2"><span data-ccn="feature_1_icon" data-ccn-c="color_features" data-ccn-co="content" data-ccn-cv="'.$this->content->color_features.'" class="'.format_text($data->feature_1_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>
                        <p data-ccn="feature_1_title" data-ccn-c="color_features" data-ccn-co="content" data-ccn-cv="'.$this->content->color_features.'">'.format_text($data->feature_1_title, FORMAT_HTML, array('filter' => true)).'</p>
                      </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                      <div class="home_icon_box home4">
                        <div class="icon ccn_icon_2"><span data-ccn="feature_2_icon" data-ccn-c="color_features" data-ccn-co="content" data-ccn-cv="'.$this->content->color_features.'" class="'.format_text($data->feature_2_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>
                        <p data-ccn="feature_2_title" data-ccn-c="color_features" data-ccn-co="content" data-ccn-cv="'.$this->content->color_features.'">'.format_text($data->feature_2_title, FORMAT_HTML, array('filter' => true)).'</p>
                      </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                      <div class="home_icon_box home4">
                        <div class="icon ccn_icon_2"><span data-ccn="feature_3_icon" data-ccn-c="color_features" data-ccn-co="content" data-ccn-cv="'.$this->content->color_features.'" class="'.format_text($data->feature_3_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>
                        <p data-ccn="feature_3_title" data-ccn-c="color_features" data-ccn-co="content" data-ccn-cv="'.$this->content->color_features.'">'.format_text($data->feature_3_title, FORMAT_HTML, array('filter' => true)).'</p>
                      </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                      <div class="home_icon_box home4">
                        <div class="icon ccn_icon_2"><span data-ccn="feature_4_icon" data-ccn-c="color_features" data-ccn-co="content" data-ccn-cv="'.$this->content->color_features.'" class="'.format_text($data->feature_4_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>
                        <p data-ccn="feature_4_title" data-ccn-c="color_features" data-ccn-co="content" data-ccn-cv="'.$this->content->color_features.'">'.format_text($data->feature_4_title, FORMAT_HTML, array('filter' => true)).'</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <a href="#continue">
                    <div class="discover_scroll home8">
                      <div class="thumb">
                        <img src="'.$CFG->wwwroot .'/theme/edumy/images/resource/mouse.png" alt="">
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div id="continue"></div>';

        return $this->content;
    }

    /**
     * Serialize and store config data
     */
    // function instance_config_save($data, $nolongerused = false) {
    //     global $CFG;
    //
    //     $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
    //                                 'subdirs'       => 0,
    //                                 'maxfiles'      => 1,
    //                                 'accepted_types' => array('.jpg', '.png', '.gif'));
    //
    //     for($i = 1; $i <= $data->slidesnumber; $i++) {
    //         $field = 'file_slide' . $i;
    //         if (!isset($data->$field)) {
    //             continue;
    //         }
    //
    //         file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_hero_4', 'slides', $i, $filemanageroptions);
    //     }
    //
    //     parent::instance_config_save($data, $nolongerused);
    // }

    /**
     * When a block instance is deleted.
     */
    // function instance_delete() {
    //     global $DB;
    //     $fs = get_file_storage();
    //     $fs->delete_area_files($this->context->id, 'block_cocoon_hero_4');
    //     return true;
    // }

    /**
     * Copy any block-specific data when copying to a new block instance.
     * @param int $fromid the id number of the block instance to copy from
     * @return boolean
     */
    // public function instance_copy($fromid) {
    //     global $CFG;
    //
    //     $fromcontext = context_block::instance($fromid);
    //     $fs = get_file_storage();
    //
    //     if (!empty($this->config) && is_object($this->config)) {
    //         $data = $this->config;
    //         $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 0;
    //     } else {
    //         $data = new stdClass();
    //         $data->slidesnumber = 0;
    //     }
    //
    //     $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
    //                                 'subdirs'       => 0,
    //                                 'maxfiles'      => 1,
    //                                 'accepted_types' => array('.jpg', '.png', '.gif'));
    //
    //     for($i = 1; $i <= $data->slidesnumber; $i++) {
    //         $field = 'file_slide' . $i;
    //         if (!isset($data->$field)) {
    //             continue;
    //         }
    //
    //         // This extra check if file area is empty adds one query if it is not empty but saves several if it is.
    //         if (!$fs->is_area_empty($fromcontext->id, 'block_cocoon_hero_4', 'slides', $i, false)) {
    //             $draftitemid = 0;
    //             file_prepare_draft_area($draftitemid, $fromcontext->id, 'block_cocoon_hero_4', 'slides', $i, $filemanageroptions);
    //             file_save_draft_area_files($draftitemid, $this->context->id, 'block_cocoon_hero_4', 'slides', $i, $filemanageroptions);
    //         }
    //     }
    //
    //     return true;
    // }

    /**
     * The block should only be dockable when the title of the block is not empty
     * and when parent allows docking.
     *
     * @return bool
     */
    // public function instance_can_be_docked() {
    //     return (!empty($this->config->title) && parent::instance_can_be_docked());
    // }
    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }

}
