<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_action_panels extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_action_panels', 'block_cocoon_action_panels');

    }

    // Declare second
    public function specialization()
    {
      global $CFG, $DB;

      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');

      if (empty($this->config)) {
        $this->config = new \stdClass();
        $this->config->panel_1_title = 'Become an Instructor';
        $this->config->panel_1_text = 'Teach what you love. Dove Schooll gives you the tools to create an online course.';
        $this->config->panel_1_button_text = 'Start Teaching';
        $this->config->panel_1_button_url = '#';
        $this->config->panel_1_button_target = '_self';
        $this->config->panel_2_title = 'Dove School For Business';
        $this->config->panel_2_text = 'Get unlimited access to 2,500 of Udemy’s top courses for your team.';
        $this->config->panel_2_button_text = 'Doing Business';
        $this->config->panel_2_button_url = '#';
        $this->config->panel_2_button_target = '_self';
        $this->config->panel_1_color_bg = '#f9f9f9';
        $this->config->panel_1_color_title = '#0a0a0a';
        $this->config->panel_1_color_body = '#6f7074';
        $this->config->panel_1_color_btn = '#2441e7';
        $this->config->panel_1_color_btn_hover = '#2441e7';
        $this->config->panel_2_color_bg = '#f9f9f9';
        $this->config->panel_2_color_title = '#0a0a0a';
        $this->config->panel_2_color_body = '#6f7074';
        $this->config->panel_2_color_btn = '#051925';
        $this->config->panel_2_color_btn_hover = '#051925';
      }
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            // return $this->content;
        }
        $this->content         =  new stdClass;
        // if(!empty($this->config->title)){$this->content->title = $this->config->title;}


        if(!empty($this->config->panel_1_title)){
          $this->content->panel_1_title = format_text($this->config->panel_1_title, FORMAT_HTML, array('filter' => true));
        } else {
          $this->content->panel_1_title = '';
        }
        if(!empty($this->config->panel_1_text)){
          $this->content->panel_1_text = format_text($this->config->panel_1_text, FORMAT_HTML, array('filter' => true));
        } else {
          $this->content->panel_1_text = '';
        }
        if(!empty($this->config->panel_1_button_text)){
          $this->content->panel_1_button_text = format_text($this->config->panel_1_button_text, FORMAT_HTML, array('filter' => true));
        } else {
          $this->content->panel_1_button_text = '';
        }
        if(!empty($this->config->panel_1_button_url)){
          $this->content->panel_1_button_url = format_text($this->config->panel_1_button_url, FORMAT_HTML, array('filter' => true));
        } else {
          $this->content->panel_1_button_url = '';
        }
        if(!empty($this->config->panel_1_button_target)){
          $this->content->panel_1_button_target = format_text($this->config->panel_1_button_target, FORMAT_HTML, array('filter' => true));
        } else {
          $this->content->panel_1_button_target = '_self';
        }
        if(!empty($this->config->panel_2_title)){
          $this->content->panel_2_title = format_text($this->config->panel_2_title, FORMAT_HTML, array('filter' => true));
        } else {
          $this->content->panel_2_title = '';
        }
        if(!empty($this->config->panel_2_text)){
          $this->content->panel_2_text = format_text($this->config->panel_2_text, FORMAT_HTML, array('filter' => true));
        } else {
          $this->content->panel_2_text = '';
        }
        if(!empty($this->config->panel_2_button_text)){
          $this->content->panel_2_button_text = format_text($this->config->panel_2_button_text, FORMAT_HTML, array('filter' => true));
        } else {
          $this->content->panel_2_button_text = '';
        }
        if(!empty($this->config->panel_2_button_url)){
          $this->content->panel_2_button_url = format_text($this->config->panel_2_button_url, FORMAT_HTML, array('filter' => true));
        } else {
          $this->content->panel_2_button_url = '';
        }
        if(!empty($this->config->panel_2_button_target)){
          $this->content->panel_2_button_target = format_text($this->config->panel_2_button_target, FORMAT_HTML, array('filter' => true));
        } else {
          $this->content->panel_2_button_target = '_self';
        }
        if(!empty($this->config->panel_1_color_bg)){$this->content->panel_1_color_bg = $this->config->panel_1_color_bg;} else {$this->content->panel_1_color_bg = '#f9f9f9';}
        if(!empty($this->config->panel_1_color_title)){$this->content->panel_1_color_title = $this->config->panel_1_color_title;} else {$this->content->panel_1_color_title = '#0a0a0a';}
        if(!empty($this->config->panel_1_color_body)){$this->content->panel_1_color_body = $this->config->panel_1_color_body;} else {$this->content->panel_1_color_body = '#6f7074';}
        if(!empty($this->config->panel_1_color_btn)){$this->content->panel_1_color_btn = $this->config->panel_1_color_btn;} else {$this->content->panel_1_color_btn = '#2441e7';}
        if(!empty($this->config->panel_1_color_btn_hover)){$this->content->panel_1_color_btn_hover = $this->config->panel_1_color_btn_hover;} else {$this->content->panel_1_color_btn_hover = '#2441e7';}
        if(!empty($this->config->panel_2_color_bg)){$this->content->panel_2_color_bg = $this->config->panel_2_color_bg;} else {$this->content->panel_2_color_bg = '#f9f9f9';}
        if(!empty($this->config->panel_2_color_title)){$this->content->panel_2_color_title = $this->config->panel_2_color_title;} else {$this->content->panel_2_color_title = '#0a0a0a';}
        if(!empty($this->config->panel_2_color_body)){$this->content->panel_2_color_body = $this->config->panel_2_color_body;} else {$this->content->panel_2_color_body = '#6f7074';}
        if(!empty($this->config->panel_2_color_btn)){$this->content->panel_2_color_btn = $this->config->panel_2_color_btn;} else {$this->content->panel_2_color_btn = '#051925';}
        if(!empty($this->config->panel_2_color_btn_hover)){$this->content->panel_2_color_btn_hover = $this->config->panel_2_color_btn_hover;} else {$this->content->panel_2_color_btn_hover = '#051925';}

        $this->content->text = '
        <div class="container mb60">
          <div class="row mt60">
            <div class="col-xs-12 col-sm-13 col-md-6 col-lg-6 col-xl-6">
              <div class="becomea_instructor tac-xxsd"
                data-ccn-c="panel_1_color_bg"
                data-ccn-co="bg"
                data-ccn-cv="'.$this->content->panel_1_color_bg.'"
                >
                <div class="bi_grid">';
                  $this->content->text .='<h3 data-ccn="panel_1_title"
                                            data-ccn-c="panel_1_color_title"
                                            data-ccn-cv="'.$this->content->panel_1_color_title.'"
                                            >'. $this->content->panel_1_title .'</h3>';
                if (!empty($this->content->panel_1_text)){
                  $this->content->text .='<p data-ccn="panel_1_text"
                                            data-ccn-c="panel_1_color_body"
                                            data-ccn-cv="'.$this->content->panel_1_color_body.'"
                                            >'.format_text($this->content->panel_1_text, FORMAT_HTML, array('filter' => true)).'</p>';
                }
                if (!empty($this->content->panel_1_button_url) && !empty($this->content->panel_1_button_text)){
                  $this->content->text .='<div data-ccn-btn><a target="'.$this->content->panel_1_button_target.'" class="btn btn-thm" href="'.format_text($this->content->panel_1_button_url, FORMAT_HTML, array('filter' => true)).'"
                                            data-ccn="panel_1_button_text"
                                            data-ccn-c="panel_1_color_btn"
                                            data-ccn-co="ccnBg, ccnBd"
                                            data-ccn-cv="'.$this->content->panel_1_color_btn.'"
                                            data-ccn-ch-co="ccnBd, ccnCn"
                                            data-ccn-ch-cv="'.$this->content->panel_1_color_btn_hover.'"
                                            data-ccn-ch="panel_1_color_btn_hover"
                                            data-ccn-ch-self
                                            >'.format_text($this->content->panel_1_button_text, FORMAT_HTML, array('filter' => true)).' <span class="flaticon-right-arrow-1"></span></a></div>';
                }
                $this->content->text .='</div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-13 col-md-6 col-lg-6 col-xl-6">
              <div class="becomea_instructor style2 text-right tac-xxsd"
                data-ccn-c="panel_2_color_bg"
                data-ccn-co="bg"
                data-ccn-cv="'.$this->content->panel_2_color_bg.'"
                >
                <div class="bi_grid">';
                if (!empty($this->content->panel_2_title)){
                $this->content->text .='  <h3 data-ccn="panel_2_title"
                                              data-ccn-c="panel_2_color_title"
                                              data-ccn-cv="'.$this->content->panel_2_color_title.'"
                                              >'.format_text($this->content->panel_2_title, FORMAT_HTML, array('filter' => true)).'</h3>';
                }
                if (!empty($this->content->panel_2_text)){
                  $this->content->text .='<p data-ccn="panel_2_text"
                                            data-ccn-c="panel_2_color_body"
                                            data-ccn-cv="'.$this->content->panel_2_color_body.'"
                                            >'.format_text($this->content->panel_2_text, FORMAT_HTML, array('filter' => true)).'</p>';
                }
                if (!empty($this->content->panel_2_button_url) && !empty($this->content->panel_2_button_text)){
                  $this->content->text .='<div data-ccn-btn><a target="'.$this->content->panel_2_button_target.'" class="btn btn-dark" href="'.format_text($this->content->panel_2_button_url, FORMAT_HTML, array('filter' => true)).'"
                                            data-ccn="panel_2_button_text"
                                            data-ccn-c="panel_2_color_btn"
                                            data-ccn-co="ccnBg, ccnBd"
                                            data-ccn-cv="'.$this->content->panel_2_color_btn.'"
                                            data-ccn-ch-co="ccnBd, ccnCn"
                                            data-ccn-ch-cv="'.$this->content->panel_2_color_btn_hover.'"
                                            data-ccn-ch="panel_2_color_btn_hover"
                                            data-ccn-ch-self
                                            >'.format_text($this->content->panel_2_button_text, FORMAT_HTML, array('filter' => true)).' <span class="flaticon-right-arrow-1"></span></a></div>';
                }
                $this->content->text .='</div>
              </div>
            </div>
          </div>
        </div>';
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
