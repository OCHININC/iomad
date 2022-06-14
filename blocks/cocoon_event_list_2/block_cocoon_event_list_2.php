<?php

include_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot. '/course/renderer.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/event_handler/ccn_event_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_event_list_2 extends block_base {
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_event_list_2');
    }

    function has_config() {
        return true;
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
    }


    function instance_allow_config() {
        return true;
    }

    function specialization() {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');

        if (empty($this->config)) {
          $ccnEventHandler = new ccnEventHandler();
          $ccnEventList = $ccnEventHandler->ccnGetExampleEventIds(6);
          $this->config = new \stdClass();
          $this->config->items = 6;
          $this->config->title = 'Upcoming Events';
          $this->config->subtitle = 'Cum doctus civibus efficiantur in imperdiet deterruisset.';
          $this->config->button_text = 'See All Events';
          $this->config->event1 = isset($ccnEventList[0]) ? $ccnEventList[0] : NULL ;
          $this->config->event2 = isset($ccnEventList[1]) ? $ccnEventList[1] : NULL ;
          $this->config->event3 = isset($ccnEventList[2]) ? $ccnEventList[2] : NULL ;
          $this->config->event4 = isset($ccnEventList[3]) ? $ccnEventList[3] : NULL ;
          $this->config->event5 = isset($ccnEventList[4]) ? $ccnEventList[4] : NULL ;
          $this->config->event6 = isset($ccnEventList[5]) ? $ccnEventList[5] : NULL ;
          $this->config->color_bg1 = '#f9f9f9';
          $this->config->color_date1 = 'rgb(0, 103, 218, 0.102)';
          $this->config->color_bg2 = '#f9f9f9';
          $this->config->color_date2 = 'rgb(0, 103, 218, 0.102)';
          $this->config->color_bg3 = '#f9f9f9';
          $this->config->color_date3 = 'rgb(0, 103, 218, 0.102)';
          $this->config->color_bg4 = '#f9f9f9';
          $this->config->color_date4 = 'rgb(0, 103, 218, 0.102)';
          $this->config->color_bg5 = '#f9f9f9';
          $this->config->color_date5 = 'rgb(0, 103, 218, 0.102)';
          $this->config->color_bg6 = '#f9f9f9';
          $this->config->color_date6 = 'rgb(0, 103, 218, 0.102)';
          $this->config->color_bg = '#ffffff';
          $this->config->color_title = '#0a0a0a';
          $this->config->color_subtitle = 'rgb(111, 112, 116)';
          $this->config->color_btn = '#555555';
        }
    }

    function get_content() {
        global $CFG, $USER, $DB, $OUTPUT;

        if($this->content !== NULL) {
            return $this->content;
        }

        if (!empty($this->config) && is_object($this->config)) {
          $data = $this->config;
          $data->items = is_numeric($data->items) ? (int)$data->items : 6;
        } else {
          $data = new stdClass();
          $data->items = 6;
        }

        $this->content = new stdClass;
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->subtitle = '';}
        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;}else{$this->content->button_text = '';}
        if(!empty($this->config->color_bg)){$this->content->color_bg = $this->config->color_bg;} else {$this->content->color_bg = '#f8f8f8';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = '#0a0a0a';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = 'rgb(111, 112, 116)';}
        if(!empty($this->config->color_btn)){$this->content->color_btn = $this->config->color_btn;} else {$this->content->color_btn = '#555555';}

        $this->content->text = '

        <section class="our-event bgc-f8"
          data-ccn-c="color_bg"
          data-ccn-co="ccnBg"
          data-ccn-cv="'.$this->content->color_bg.'"
          >
          <div class="container">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                  <h3 class="mt0 mb0"
                    data-ccn="title"
                    data-ccn-c="color_title"
                    data-ccn-co="ccnCn"
                    data-ccn-cv="'.$this->content->color_title.'"
                    >'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
                  <p class=""
                    data-ccn="subtitle"
                    data-ccn-c="color_subtitle"
                    data-ccn-co="ccnCn"
                    data-ccn-cv="'.$this->content->color_subtitle.'"
                    >'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
                </div>
              </div>
            </div>
            <div class="blog_post_home6_date home11 mb30-smd">
              <div class="row">';
                $col_class = "col-12 col-md-6";
                if ($data->items == 1) {
                  $col_class = "col-12 col-md-12";
                }
                if ($data->items > 0) {
                  $fs = get_file_storage();
                  for ($i = 0; $i <= $data->items; $i++) {

                    $icon = 'icon' . $i;
                    $color_bg = 'color_bg' . $i;
                    $color_date = 'color_date' . $i;
                    $event = 'event' . $i;
                    $image = 'image' . $i;
                    $files = $fs->get_area_files($this->context->id, 'block_cocoon_event_list_2', 'images', $i, 'sortorder DESC, id ASC', false, 0, 0, 1);

                    if (!empty($data->$image) && count($files) >= 1) {
                      $mainfile = reset($files);
                      $mainfile = $mainfile->get_filename();
                      $data->$image = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php","/{$this->context->id}/block_cocoon_event_list_2/images/" . $i . '/' . $mainfile);
                    } else {
                      $data->$image = $CFG->wwwroot .'/theme/edumy/images/ccnBgSm.png';
                    }

                    // print_object($data->$event);
                    if ($DB->record_exists('event', array('id' => $data->$event))) {

                      $ccnEventHandler = new ccnEventHandler();
                      $ccnGetEvent = $ccnEventHandler->ccnGetEvent((int)$data->$event);

                      // print_object($ccnGetEvent);
                      $this->content->text .='



                      <div class="'.$col_class.'">
                        <div class="post_grid bgc-f9 mb20"
                          data-ccn-c="'.$color_bg.'"
                          data-ccn-co="ccnBg"
                          data-ccn-cv="'.$data->$color_bg.'"
                          >
        									<div class="event-thumb">
                            <div class="event-thumb-img">
                              <img src="'.$data->$image.'" alt="">
                            </div>
                            <div class="post_date_home13 text-center text-thm8"
                              data-ccn-c="'.$color_date.'"
                              data-ccn-co="ccnBg"
                              data-ccn-cv="'.$data->$color_date.'"
                              >'. $ccnGetEvent->dateDay.' '. $ccnGetEvent->dateMonth .'</div>
                          </div>
        									<div class="post_body pl30">
        										<h4 class="post_title">'.$ccnGetEvent->name.'</h4>
        										<div class="post_meta">
        											<ul>';
                              if(!empty($ccnGetEvent->timestart)){
                                $this->content->text .='<li class="list-inline-item"><a><span class="flaticon-calendar"></span>'.$ccnGetEvent->timestart.'</a></li>';
                              }
                              if(!empty($ccnGetEvent->location)){
                                $this->content->text .='<li class="list-inline-item"><a><span class="flaticon-placeholder"></span>'.$ccnGetEvent->location.'</a></li>';
                              }
                              $this->content->text .='
        											</ul>
        										</div>
        									</div>
        								</div>
                      </div>';
                    }
                  }
                }
              $this->content->text .='
              </div>
              <div class="col-lg-12 text-center mt30">
				        <a class="#" href="'.$CFG->wwwroot.'/calendar"
                  data-ccn-c="color_btn"
                  data-ccn-co="ccnCn"
                  data-ccn-cv="'.$this->content->color_btn.'"
                  >
                  <span class="tdu ff-nunito"
                    data-ccn="button_text">'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).'</span>
                  &nbsp;
                  <span class="flaticon-right-arrow-1"></span>
                </a>
			        </div>
            </div>
          </div>
        </section>';

        return $this->content;
    }

    /**
     * Returns the role that best describes the course list block.
     *
     * @return string
     */
    public function get_aria_role() {
        return 'navigation';
    }
    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }


    function instance_config_save($data, $nolongerused = false) {
        global $CFG;

        $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                    'subdirs'       => 0,
                                    'maxfiles'      => 1,
                                    'accepted_types' => array('.jpg', '.png', '.gif'));

        for($i = 1; $i <= $data->items; $i++) {
            $field = 'image' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_event_list_2', 'images', $i, $filemanageroptions);
        }

        parent::instance_config_save($data, $nolongerused);
    }

    /**
     * When a block instance is deleted.
     */
    function instance_delete() {
        global $DB;
        $fs = get_file_storage();
        $fs->delete_area_files($this->context->id, 'block_cocoon_event_list_2');
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
            $data->items = is_numeric($data->items) ? (int)$data->items : 0;
        } else {
            $data = new stdClass();
            $data->items = 0;
        }

        $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                    'subdirs'       => 0,
                                    'maxfiles'      => 1,
                                    'accepted_types' => array('.jpg', '.png', '.gif'));

        for($i = 1; $i <= $data->items; $i++) {
            $field = 'image' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            // This extra check if file area is empty adds one query if it is not empty but saves several if it is.
            if (!$fs->is_area_empty($fromcontext->id, 'block_cocoon_event_list_2', 'images', $i, false)) {
                $draftitemid = 0;
                file_prepare_draft_area($draftitemid, $fromcontext->id, 'block_cocoon_event_list_2', 'images', $i, $filemanageroptions);
                file_save_draft_area_files($draftitemid, $this->context->id, 'block_cocoon_event_list_2', 'images', $i, $filemanageroptions);
            }
        }

        return true;
    }

}
