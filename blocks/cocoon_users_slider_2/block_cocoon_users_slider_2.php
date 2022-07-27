<?php
require_once($CFG->dirroot. '/theme/edumy/ccn/user_handler/ccn_user_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_users_slider_2 extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_cocoon_users_slider_2');
    }

    public function specialization() {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $ccnUserHandler = new ccnUserHandler();
          $ccnUsers = $ccnUserHandler->ccnGetExampleUsersIds(8);
          $this->config = new \stdClass();
          $this->config->title = 'Top Rating Instructors';
          $this->config->subtitle = 'Cum doctus civibus efficiantur in imperdiet deterruisset.';
          $this->config->users = $ccnUsers;
          $this->config->color_bg = 'rgb(255,255,255)';
          $this->config->color_title = '#0a0a0a';
          $this->config->color_subtitle = '#6f7074';
          $this->config->color_item_title = '#1b2032';
          $this->config->color_item_body = '#484848';
        }
    }

    /**
     * Returns the block contents.
     *
     * @return stdClass The block contents.
     */
    public function get_content() {

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';

        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->subtitle = '';}
        if(!empty($this->config->users)){$this->content->users = $this->config->users;} else {$this->content->users = '';}
        if(!empty($this->config->color_bg)){$this->content->color_bg = $this->config->color_bg;} else {$this->content->color_bg = 'rgb(255,255,255)';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = '#0a0a0a';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = '#6f7074';}
        if(!empty($this->config->color_item_title)){$this->content->color_item_title = $this->config->color_item_title;} else {$this->content->color_item_title = '#1b2032';}
        if(!empty($this->config->color_item_body)){$this->content->color_item_body = $this->config->color_item_body;} else {$this->content->color_item_body = '#484848';}


        $this->content->text = '
          <section class="our-team instructor-page pb40" data-ccn-c="color_bg" data-ccn-co="bg" data-ccn-cv="'.$this->content->color_bg.'">
           <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="main-title text-center">
                  <h3 class="mb0 mt0" data-ccn="title" data-ccn-c="color_title" data-ccn-cv="'.$this->content->color_title.'">'.$this->content->title.'</h3>
                  <p data-ccn="subtitle" data-ccn-c="color_subtitle" data-ccn-co="content" style="color: '.$this->content->color_subtitle.';">'.$this->content->subtitle.'</p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="team_slider">';
                if(!empty($this->content->users)){
                  foreach($this->content->users as $key => $ccnUserId){
                    if($ccnUserId){
                      $ccnUserHandler = new ccnUserHandler();
                      $ccnUser = $ccnUserHandler->ccnGetUserDetails($ccnUserId);
                      $teacherRating = '';
                      if($ccnUser->teacherRating){
                       $teacherRating = '<span class="float-right">'.$ccnUser->teacherRating.' <i class="fa fa-star color-golden"></i></span>';
                      }
                      $this->content->text .= '
                        <div class="our_agent">
                          <div class="thumb">
                        <a href="'.$ccnUser->profileUrl.'">
                          <img class="img-fluid w100" src="'.$ccnUser->rawAvatar.'" alt="">
                          </a>
                          <div class="overylay">
                          <div class="ccn-control">
                            <ul class="social_icon">
                              '.$ccnUserHandler->ccnOutputUserSocials($userId, 'li', 'list-inline-item').'
                            </ul>
                            <a href="'.$ccnUser->profileUrl.'">
                            <div class="ccn-instructor-meta">
                            <span class="float-left">'.$ccnUser->teachingCoursesCount.' '.get_string('courses').'</span>
                            <span class="float-right">'.$ccnUser->teachingStudentCount.' '.get_string('students').'</span>
                            </div>
                            </a>
                            </div>
                          </div>
                        </div>
                        <a href="'.$ccnUser->profileUrl.'">
                        <div class="details">
                          <h4 data-ccn-c="color_item_title" data-ccn-cv="'.$this->content->color_item_title.'">'. $ccnUser->fullname .'</h4>
                          <p data-ccn-c="color_item_body" data-ccn-cv="'.$this->content->color_item_body.'">'.get_string('speaks', 'theme_edumy').' '.$ccnUser->lang . $teacherRating .'</p>
                        </div>
                        </a>
                      </div>';
                    }
                  }
                }

                $this->content->text .='
                </div>
                </div>
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
