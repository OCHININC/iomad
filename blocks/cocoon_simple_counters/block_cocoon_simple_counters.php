<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_simple_counters extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_simple_counters', 'block_cocoon_simple_counters');
    }

    // Declare second
    public function specialization()
    {
        // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->title = 'Our Story';
          $this->config->counter_1 = '6500';
          $this->config->counter_2 = '58263';
          $this->config->counter_3 = '896673';
          $this->config->counter_4 = '8570';
          $this->config->counter_1_after = '+';
          $this->config->counter_2_after = '+';
          $this->config->counter_3_after = '+';
          $this->config->counter_4_after = '+';
          $this->config->counter_1_text = 'Students learning';
          $this->config->counter_2_text = 'Graduates';
          $this->config->counter_3_text = 'Free courses';
          $this->config->counter_4_text = 'Active courses';
          $this->config->counter_1_icon = 'flaticon-student';
          $this->config->counter_2_icon = 'flaticon-book';
          $this->config->counter_3_icon = 'flaticon-global';
          $this->config->counter_4_icon = 'flaticon-first';
}
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content         =  new stdClass;
        $col_class = "col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3";
        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->counter_1)){$this->content->counter_1 = $this->config->counter_1;}
        if(!empty($this->config->counter_1_after)){$this->content->counter_1_after = $this->config->counter_1_after;}
        if(!empty($this->config->counter_1_text)){$this->content->counter_1_text = $this->config->counter_1_text;}
        if(!empty($this->config->counter_1_icon)){$this->content->counter_1_icon = $this->config->counter_1_icon;}
        if(!empty($this->config->counter_2)){ $this->content->counter_2 = $this->config->counter_2;
                                              $col_class = "col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6";
                                            }
        if(!empty($this->config->counter_2_text)){$this->content->counter_2_text = $this->config->counter_2_text;}
        if(!empty($this->config->counter_2_after)){$this->content->counter_2_after = $this->config->counter_2_after;}
        if(!empty($this->config->counter_2_icon)){$this->content->counter_2_icon = $this->config->counter_2_icon;}
        if(!empty($this->config->counter_3)){ $this->content->counter_3 = $this->config->counter_3;
                                              $col_class = "col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4";
                                            }
        if(!empty($this->config->counter_3_text)){$this->content->counter_3_text = $this->config->counter_3_text;}
        if(!empty($this->config->counter_3_after)){$this->content->counter_3_after = $this->config->counter_3_after;}
        if(!empty($this->config->counter_3_icon)){$this->content->counter_3_icon = $this->config->counter_3_icon;}
        if(!empty($this->config->counter_4)){ $this->content->counter_4 = $this->config->counter_4;
                                              $col_class = "col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3";
                                            }
        if(!empty($this->config->counter_4_text)){$this->content->counter_4_text = $this->config->counter_4_text;}
        if(!empty($this->config->counter_4_after)){$this->content->counter_4_after = $this->config->counter_4_after;}
        if(!empty($this->config->counter_4_icon)){$this->content->counter_4_icon = $this->config->counter_4_icon;}
        if(!empty($this->config->style)){$this->content->style = $this->config->style;}

        if($this->content->style == 1){
          $class = 'text-center';
        } else {
          $class = 'text-left';
        }


        $this->content->text = '
        <div class="container">
          <div class="row mb60">
            <div class="col-lg-12 text-center mt60">
              <h3 class="fz26" data-ccn="title">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
            </div>
            <div class="col-lg-10 text-center mt40 offset-lg-1">
              <div class="row ccn-simple-facts">';
              if(!empty($this->content->counter_1) || !empty($this->content->counter_1_text) || !empty($this->content->counter_1_icon)){
                $this->content->text .='
                <div class="'.$col_class.'">
                  <div class="funfact_two '.$class.'">
                    <div class="home_icon_box home6">';
                      if(!empty($this->content->counter_1_icon)){
                      $this->content->text .='
                        <div class="icon ccn-icon-reset">
                          <i data-ccn="counter_1_icon" class="'.$this->content->counter_1_icon.'"></i>
                        </div>';
                      }
                      $this->content->text .='
                      <div class="details">
                        <h5 data-ccn="counter_1_text">'.format_text($this->content->counter_1_text, FORMAT_HTML, array('filter' => true)).'</h5>
                        <div class="timer" data-ccn="counter_1">'.format_text($this->content->counter_1, FORMAT_HTML, array('filter' => true)).'</div>';
                        if(!empty($this->content->counter_1_after)){$this->content->text .='<span class="ccn-timer-after" data-ccn="counter_1_after">'.format_text($this->content->counter_1_after, FORMAT_HTML, array('filter' => true)).'</span>';}
                        $this->content->text .='
                      </div>
                    </div>
                  </div>
                </div>';
              }
              if(!empty($this->content->counter_2) || !empty($this->content->counter_2_text) || !empty($this->content->counter_2_icon)){
                $this->content->text .='
                <div class="'.$col_class.'">
                  <div class="funfact_two '.$class.'">
                    <div class="home_icon_box home6">';
                      if(!empty($this->content->counter_2_icon)){
                      $this->content->text .='
                        <div class="icon ccn-icon-reset">
                          <i class="'.$this->content->counter_2_icon.'"></i>
                        </div>';
                      }
                      $this->content->text .='
                      <div class="details">
                        <h5 data-ccn="counter_2_text">'.format_text($this->content->counter_2_text, FORMAT_HTML, array('filter' => true)).'</h5>
                        <div class="timer" data-ccn="counter_2">'.format_text($this->content->counter_2, FORMAT_HTML, array('filter' => true)).'</div>';
                        if(!empty($this->content->counter_2_after)){$this->content->text .='<span class="ccn-timer-after" data-ccn="counter_2_after">'.format_text($this->content->counter_2_after, FORMAT_HTML, array('filter' => true)).'</span>';}
                        $this->content->text .='
                      </div>
                    </div>
                  </div>
                </div>';
              }
              if(!empty($this->content->counter_3) || !empty($this->content->counter_3_text) || !empty($this->content->counter_3_icon)){
                $this->content->text .='
                <div class="'.$col_class.'">
                  <div class="funfact_two '.$class.'">
                    <div class="home_icon_box home6">';
                      if(!empty($this->content->counter_3_icon)){
                      $this->content->text .='
                        <div class="icon ccn-icon-reset">
                          <i class="'.$this->content->counter_3_icon.'"></i>
                        </div>';
                      }
                      $this->content->text .='
                      <div class="details">
                        <h5 data-ccn="counter_3_text">'.format_text($this->content->counter_3_text, FORMAT_HTML, array('filter' => true)).'</h5>
                        <div class="timer" data-ccn="counter_3">'.format_text($this->content->counter_3, FORMAT_HTML, array('filter' => true)).'</div>';
                        if(!empty($this->content->counter_3_after)){$this->content->text .='<span class="ccn-timer-after" data-ccn="counter_3_after">'.format_text($this->content->counter_3_after, FORMAT_HTML, array('filter' => true)).'</span>';}
                        $this->content->text .='
                      </div>
                    </div>
                  </div>
                </div>';
              }
              if(!empty($this->content->counter_4) || !empty($this->content->counter_4_text) || !empty($this->content->counter_4_icon)){
                $this->content->text .='
                <div class="'.$col_class.'">
                  <div class="funfact_two '.$class.'">
                    <div class="home_icon_box home6">';
                      if(!empty($this->content->counter_4_icon)){
                      $this->content->text .='
                        <div class="icon ccn-icon-reset">
                          <i class="'.$this->content->counter_4_icon.'"></i>
                        </div>';
                      }
                      $this->content->text .='
                      <div class="details">
                        <h5 data-ccn="counter_4_text">'.format_text($this->content->counter_4_text, FORMAT_HTML, array('filter' => true)).'</h5>
                        <div class="timer" data-ccn="counter_4">'.format_text($this->content->counter_4, FORMAT_HTML, array('filter' => true)).'</div>';
                        if(!empty($this->content->counter_4_after)){$this->content->text .='<span class="ccn-timer-after" data-ccn="counter_4_after">'.format_text($this->content->counter_4_after, FORMAT_HTML, array('filter' => true)).'</span>';}
                        $this->content->text .='
                      </div>
                    </div>
                  </div>
                </div>';
              }
              $this->content->text .='
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
