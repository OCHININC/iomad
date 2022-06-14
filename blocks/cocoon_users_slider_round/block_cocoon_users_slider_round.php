<?php
require_once($CFG->dirroot. '/theme/edumy/ccn/user_handler/ccn_user_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_users_slider_round extends block_base {

  public function init() {
    $this->title = get_string('pluginname', 'block_cocoon_users_slider_round');
  }

  function specialization() {
    global $CFG, $DB;
    include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
    if (empty($this->config)) {
      $ccnUserHandler = new ccnUserHandler();
      $ccnUsers = $ccnUserHandler->ccnGetExampleUsersIds(8);
      $this->config = new \stdClass();
      $this->config->title = 'Top Rating Instructors';
      $this->config->subtitle = 'Cum doctus civibus efficiantur in imperdiet deterruisset.';
      $this->config->profile_views = 1;
      $this->config->users = $ccnUsers;
      $this->config->color_bg = 'rgb(255,255,255)';
      $this->config->color_title = '#0a0a0a';
      $this->config->color_subtitle = '#6f7074';
      $this->config->color_owl_dots = '#debf52';
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
        $this->content->text = '';

        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->subtitle = '';}
        if(!empty($this->config->users)){$this->content->users = $this->config->users;} else {$this->content->users = '';}
        if(!empty($this->config->color_bg)){$this->content->color_bg = $this->config->color_bg;} else {$this->content->color_bg = 'rgb(255,255,255)';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = '#0a0a0a';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = '#6f7074';}
        if(!empty($this->config->color_owl_dots)){$this->content->color_owl_dots = $this->config->color_owl_dots;} else {$this->content->color_owl_dots = '#debf52';}
        if(!empty($this->config->profile_views)){$this->content->profile_views = $this->config->profile_views;} else {$this->content->profile_views = 0;}




        $this->content->text .='
        <section class="our-team home8 pb10 pt30" data-ccn-c="color_bg" data-ccn-co="bg" style="background-color: '.$this->content->color_bg.';">
         <div class="container">
           <div class="row">
             <div class="col-lg-6 offset-lg-3">
               <div class="main-title text-center">
                 <h3 class="mt0" data-ccn="title" data-ccn-c="color_title" data-ccn-co="content" style="color: '.$this->content->color_title.';">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
                 <p data-ccn="subtitle" data-ccn-c="color_subtitle" data-ccn-co="content" style="color: '.$this->content->color_subtitle.';">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
               </div>
             </div>
           </div>
           <div class="row">
             <div class="col-lg-12">
               <div class="instructor_slider_home3 home8">';
                  if(!empty($this->content->users)){
                    foreach($this->content->users as $key => $ccnUserId){
                      if($ccnUserId){
                        $ccnUserHandler = new ccnUserHandler();
                        $ccnUser = $ccnUserHandler->ccnGetUserDetails($ccnUserId);
                        $this->content->text .='
                        <div class="item">
                          <a href="'.$ccnUser->profileUrl.'">
                            <div class="instructor_col">
                              <div class="thumb">
                                <img class="img-fluid img-rounded-circle" src="'.$ccnUser->rawAvatar.'" alt="">
                              </div>
                              <div class="details">
                                <ul>
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                </ul>
                                <h4 data-ccn-c="color_title" data-ccn-cv="'.$this->content->color_title.'">'. $ccnUser->fullname.'</h4>';
                                if($this->content->profile_views == 1){
                                  $this->content->text .='<p data-ccn-c="color_subtitle" data-ccn-cv="'.$this->content->color_subtitle.'">'. $ccnUser->ccnRender->profileCount .'</p>';
                                }
                                $this->content->text .='
                              </div>
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





        // print_object($this->content->users);

 //        if (!empty($this->config->text)) {
 //            $this->content->text = $this->config->text;
 //        } else
 //        {
 //            $userconfig = null;
 //            if(!empty($this->config->users))
 //            {
 //                $userconfig = $this->config->users;
 //            }
 //            $users = $this->get_users($userconfig);
 //            if(empty($users))
 //            {
 //                $this->content->text = get_string('empty', 'block_cocoon_users_slider_round');
 //            }
 //            else
 //            {
 //                $list = [];
 //                foreach ($users as $id => $username)
 //                {
 //                    $link = $username;
 //                    $list[] = $link;
 //                }
 //                $this->content->text = '
 //                <section class="our-team home8 pb10 pt30">
 //  <div class="container">
 //    <div class="row">
 //      <div class="col-lg-6 offset-lg-3">
 //        <div class="main-title text-center">
 //          <h3 class="mt0">'.$this->content->title.'</h3>
 //          <p>'.$this->content->subtitle.'</p>
 //        </div>
 //      </div>
 //    </div>
 //    <div class="row">
 //      <div class="col-lg-12">
 //        <div class="instructor_slider_home3 home8">
 // '. implode('', $list) .' </div>
	// 			</div>
	// 		</div>
	// 	</div>
	// </section>
 //                ';
 //            }
 //        }

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
