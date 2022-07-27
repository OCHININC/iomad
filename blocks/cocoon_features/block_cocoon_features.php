<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_features extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_features', 'block_cocoon_features');
    }

    // Declare second
    public function specialization()
    {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->title1 = 'Learn From The Experts';
          $this->config->icon1 = 'flaticon-student';
          $this->config->title2 = 'Book Library & Store';
          $this->config->icon2 = 'flaticon-book';
          $this->config->title3 = 'Worldwide Recognize';
          $this->config->icon3 = 'flaticon-global';
          $this->config->title4 = 'Best Industry Leaders';
          $this->config->icon4 = 'flaticon-first';
          $this->config->items = 4;
          $this->config->title = 'Dove Kindergarten';
          $this->config->subtitle = 'Cum doctus civibus efficiantur in imperdiet deterruisset';
          $this->config->style = 0;
          $this->config->color_bg = 'rgb(255,255,255)';
          $this->config->color_title = '#0a0a0a';
          $this->config->color_subtitle = '#6f7074';
          $this->config->color_item_title = '#0a0a0a';
          $this->config->color_item_icon = '#192675';
          $this->config->color_item_icon_hover = '#ff1053';
        }
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new \stdClass();
        $this->content->text = '';

        if (!empty($this->config) && is_object($this->config)) {
          $data = $this->config;
          $data->items = $data->items ? (int)$data->items : 4;
        } else {
          $data = new stdClass();
          $data->items = 4;
        }

        $col_class = "col-sm-6 col-lg-3";
        if(!empty($this->config->feature_1_title)){$this->content->feature_1_title = $this->config->feature_1_title;} else { $this->content->feature_1_title = '';}
        if(!empty($this->config->feature_1_icon)){$this->content->feature_1_icon = $this->config->feature_1_icon;}  else { $this->content->feature_1_icon = '';}
        if(!empty($this->config->feature_2_title)){   $this->content->feature_2_title = $this->config->feature_2_title;
                                                      $col_class = "col-sm-6 col-lg-6";
                                                  }  else { $this->content->feature_2_title = '';}
        if(!empty($this->config->feature_2_icon)){$this->content->feature_2_icon = $this->config->feature_2_icon;}  else { $this->content->feature_2_icon = '';}
        if(!empty($this->config->feature_3_title)){   $this->content->feature_3_title = $this->config->feature_3_title;
                                                      $col_class = "col-sm-6 col-lg-4";
                                                  }  else { $this->content->feature_3_title = '';}
        if(!empty($this->config->feature_3_icon)){$this->content->feature_3_icon = $this->config->feature_3_icon;}  else { $this->content->feature_3_icon = '';}
        if(!empty($this->config->feature_4_title)){   $this->content->feature_4_title = $this->config->feature_4_title;
                                                      $col_class = "col-sm-6 col-lg-3";
                                                  }  else { $this->content->feature_4_title = '';}
        if(!empty($this->config->feature_4_icon)){$this->content->feature_4_icon = $this->config->feature_4_icon;}  else { $this->content->feature_4_icon = '';}
        if(!empty($this->config->title)){
          $this->content->title = $this->config->title;
          $ccnPaddingCx = 'pb10 pt30';
        } else {
          $this->content->title = '';
          $ccnPaddingCx = '';
        }
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;}  else { $this->content->subtitle = '';}
        if(!empty($this->config->style)){$this->content->style = $this->config->style;}  else { $this->content->style = 0;}
        if(!empty($this->config->color_bg)){$this->content->color_bg = $this->config->color_bg;} else {$this->content->color_bg = 'rgb(255,255,255)';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = '#0a0a0a';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = '#6f7074';}
        if(!empty($this->config->color_item_title)){$this->content->color_item_title = $this->config->color_item_title;} else {$this->content->color_item_title = '#0a0a0a';}
        if(!empty($this->config->color_item_icon)){$this->content->color_item_icon = $this->config->color_item_icon;} else {$this->content->color_item_icon = '#192675';}
        if(!empty($this->config->color_item_icon_hover)){$this->content->color_item_icon_hover = $this->config->color_item_icon_hover;} else {$this->content->color_item_icon_hover = '#ff1053';}

        if(!empty($this->content->style) && $this->content->style == 1){
          $class = 'text-center';
          $rowClass = 'justify-content-center';
        } else {
          $class = '';
          $rowClass = '';
        }

        $this->content->text .= '
        <section class="home3_about2 '.$ccnPaddingCx .'"
          data-ccn-c="color_bg"
          data-ccn-co="ccnBg"
          data-ccn-cv="'.$this->content->color_bg.'"
          >
          <div class="container">
              <div class="row ccn-ctl-emp">
                <div class="col-lg-6 offset-lg-3">
  					       <div class="main-title text-center">
  						        <h3 class="mt0"
                        data-ccn="title"
                        data-ccn-c="color_title"
                        data-ccn-co="ccnCn"
                        data-ccn-cv="'.$this->content->color_title.'"
                        >'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
  						        <p
                        data-ccn="subtitle"
                        data-ccn-c="color_subtitle"
                        data-ccn-co="ccnCn"
                        data-ccn-cv="'.$this->content->color_subtitle.'"
                        >'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
  					       </div>
  				       </div>
  			      </div>';
      if(!empty($this->content->title)){
        $this->content->text .='<div class="row '.$rowClass.'">';
      } else {
        $this->content->text .='<div class="row mt40 '.$rowClass.'">';
      }
      if (!empty($data->items) && $data->items > 0) {
        for ($i = 1; $i <= $data->items; $i++) {
            $title = 'title' . $i;
            $icon = 'icon' . $i;

            $this->content->text .= '
              <div class="ccn-ctl-emp '.$col_class.' '.$class.'">
                <div class="home_icon_box home6"
                  data-ccn-cv
                  data-ccn-ch-parent
                  >';
                  $this->content->text .='<div class="icon ccn-icon-reset"><span
                                                                            class="'.format_text($data->$icon, FORMAT_HTML, array('filter' => true)).'"
                                                                            data-ccn="'.$icon.'"
                                                                            data-ccn-c="color_item_icon"
                                                                            data-ccn-co="ccnCn"
                                                                            data-ccn-cv="'.$this->content->color_item_icon.'"
                                                                            data-ccn-ch-co="ccnCn"
                                                                            data-ccn-ch-cv="'.$this->content->color_item_icon_hover.'"
                                                                            data-ccn-ch="color_item_icon_hover"
                                                                            data-ccn-ch-child></span></div>';
                  $this->content->text .='<p
                                            data-ccn="'.$title.'"
                                            data-ccn-c="color_item_title"
                                            data-ccn-co="ccnCn"
                                            data-ccn-cv="'.$this->content->color_item_title.'"
                                            >'.format_text($data->$title, FORMAT_HTML, array('filter' => true)).'</p>';
                  $this->content->text .='
                </div>
              </div>';
          }
        } else {
          $this->content->text .='
          <div class="ccn-ctl-emp '.$col_class.' '.$class.'">
            <div class="home_icon_box home6">';
              $this->content->text .='<div class="icon ccn-icon-reset"><span data-ccn="feature_1_icon" class="'.format_text($this->content->feature_1_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>';
              $this->content->text .='<p data-ccn="feature_1_title">'.format_text($this->content->feature_1_title, FORMAT_HTML, array('filter' => true)).'</p>';
              $this->content->text .='
            </div>
          </div>';
         $this->content->text .='
          <div class="ccn-ctl-emp '.$col_class.' '.$class.'">
            <div class="home_icon_box home6">';
              $this->content->text .='<div class="icon ccn-icon-reset"><span data-ccn="feature_2_icon" class="'.format_text($this->content->feature_2_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>';
              $this->content->text .='<p data-ccn="feature_2_title">'.format_text($this->content->feature_2_title, FORMAT_HTML, array('filter' => true)).'</p>';
              $this->content->text .='
            </div>
          </div>';
         $this->content->text .=' <div class="ccn-ctl-emp '.$col_class.' '.$class.'">
            <div class="home_icon_box home6">';
              $this->content->text .='<div class="icon ccn-icon-reset"><span data-ccn="feature_3_icon" class="'.format_text($this->content->feature_3_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>';
              $this->content->text .='  <p data-ccn="feature_3_title">'.format_text($this->content->feature_3_title, FORMAT_HTML, array('filter' => true)).'</p>';
            $this->content->text .='
            </div>
          </div>';
          $this->content->text .='
          <div class="ccn-ctl-emp '.$col_class.' '.$class.'">
            <div class="home_icon_box home6">';
              $this->content->text .='<div class="icon ccn-icon-reset"><span data-ccn="feature_4_icon" class="'.format_text($this->content->feature_4_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>';
              $this->content->text .='<p data-ccn="feature_4_title">'.format_text($this->content->feature_4_title, FORMAT_HTML, array('filter' => true)).'</p>';
            $this->content->text .='
            </div>
          </div>';
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
