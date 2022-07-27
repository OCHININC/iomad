<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_tablets extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_tablets', 'block_cocoon_tablets');
    }

    // Declare second
    public function specialization()
    {
        // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->title = 'What We Do';
          $this->config->subtitle = 'Striving to make the web a more beautiful place every single day';
          $this->config->body['text'] = '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes.</p>';
          $this->config->button_text = 'View More';
          $this->config->button_link = '#';
          $this->config->feature_1_title = 'Create Account';
          $this->config->feature_2_title = 'Create Online Course';
          $this->config->feature_3_title = 'Interact with Students';
          $this->config->feature_4_title = 'Achieve Your Goals';
          $this->config->feature_1_subtitle = 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.';
          $this->config->feature_2_subtitle = 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.';
          $this->config->feature_3_subtitle = 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.';
          $this->config->feature_4_subtitle = 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.';
          $this->config->feature_1_icon = 'flaticon-account';
          $this->config->feature_2_icon = 'flaticon-online';
          $this->config->feature_3_icon = 'flaticon-student-1';
          $this->config->feature_4_icon = 'flaticon-employee';
          $this->config->feature_1_link = '#';
          $this->config->feature_2_link = '#';
          $this->config->feature_3_link = '#';
          $this->config->feature_4_link = '#';
          $this->config->style = 0;
          $this->config->color_1 = '#2ac4ea';
          $this->config->color_2 = '#ff1053';
          $this->config->color_3 = '#2441e7';
          $this->config->color_4 = '#fbbc05';
          $this->config->color_hover_1 = '#2ac4ea';
          $this->config->color_hover_2 = '#ff1053';
          $this->config->color_hover_3 = '#2441e7';
          $this->config->color_hover_4 = '#fbbc05';
          $this->config->color_icon_1 = 'rgb(255,255,255)';
          $this->config->color_icon_2 = 'rgb(255,255,255)';
          $this->config->color_icon_3 = 'rgb(255,255,255)';
          $this->config->color_icon_4 = 'rgb(255,255,255)';
          $this->config->color_icon_hover_1 = 'rgb(255,255,255)';
          $this->config->color_icon_hover_2 = 'rgb(255,255,255)';
          $this->config->color_icon_hover_3 = 'rgb(255,255,255)';
          $this->config->color_icon_hover_4 = 'rgb(255,255,255)';
          $this->config->color_title_1 = 'rgb(255,255,255)';
          $this->config->color_title_2 = 'rgb(255,255,255)';
          $this->config->color_title_3 = 'rgb(255,255,255)';
          $this->config->color_title_4 = 'rgb(255,255,255)';
          $this->config->color_title_hover_1 = 'rgb(255,255,255)';
          $this->config->color_title_hover_2 = 'rgb(255,255,255)';
          $this->config->color_title_hover_3 = 'rgb(255,255,255)';
          $this->config->color_title_hover_4 = 'rgb(255,255,255)';
          $this->config->color_body_hover_1 = 'rgb(255,255,255)';
          $this->config->color_body_hover_2 = 'rgb(255,255,255)';
          $this->config->color_body_hover_3 = 'rgb(255,255,255)';
          $this->config->color_body_hover_4 = 'rgb(255,255,255)';
          $this->config->color_body_1 = 'rgb(255,255,255)';
          $this->config->color_body_2 = 'rgb(255,255,255)';
          $this->config->color_body_3 = 'rgb(255,255,255)';
          $this->config->color_body_4 = 'rgb(255,255,255)';

         }
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content         =  new stdClass;
        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;}
        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;}
        if(!empty($this->config->button_link)){$this->content->button_link = $this->config->button_link;}
        if(!empty($this->config->feature_1_title)){$this->content->feature_1_title = $this->config->feature_1_title;}
        if(!empty($this->config->feature_1_subtitle)){$this->content->feature_1_subtitle = $this->config->feature_1_subtitle;}
        if(!empty($this->config->feature_1_icon)){$this->content->feature_1_icon = $this->config->feature_1_icon;}
        if(!empty($this->config->feature_2_title)){$this->content->feature_2_title = $this->config->feature_2_title;}
        if(!empty($this->config->feature_2_subtitle)){$this->content->feature_2_subtitle = $this->config->feature_2_subtitle;}
        if(!empty($this->config->feature_2_icon)){$this->content->feature_2_icon = $this->config->feature_2_icon;}
        if(!empty($this->config->feature_3_title)){$this->content->feature_3_title = $this->config->feature_3_title;}
        if(!empty($this->config->feature_3_subtitle)){$this->content->feature_3_subtitle = $this->config->feature_3_subtitle;}
        if(!empty($this->config->feature_3_icon)){$this->content->feature_3_icon = $this->config->feature_3_icon;}
        if(!empty($this->config->feature_4_title)){$this->content->feature_4_title = $this->config->feature_4_title;}
        if(!empty($this->config->feature_4_subtitle)){$this->content->feature_4_subtitle = $this->config->feature_4_subtitle;}
        if(!empty($this->config->feature_4_icon)){$this->content->feature_4_icon = $this->config->feature_4_icon;}
        if(!empty($this->config->feature_1_link)){$this->content->feature_1_link = $this->config->feature_1_link;}
        if(!empty($this->config->feature_2_link)){$this->content->feature_2_link = $this->config->feature_2_link;}
        if(!empty($this->config->feature_3_link)){$this->content->feature_3_link = $this->config->feature_3_link;}
        if(!empty($this->config->feature_4_link)){$this->content->feature_4_link = $this->config->feature_4_link;}
        if(!empty($this->config->color_1)){$this->content->color_1 = $this->config->color_1;} else {$this->content->color_1 = '#2ac4ea';}
        if(!empty($this->config->color_2)){$this->content->color_2 = $this->config->color_2;} else {$this->content->color_2 = '#ff1053';}
        if(!empty($this->config->color_3)){$this->content->color_3 = $this->config->color_3;} else {$this->content->color_3 = '#2441e7';}
        if(!empty($this->config->color_4)){$this->content->color_4 = $this->config->color_4;} else {$this->content->color_4 = '#fbbc05';}
        if(!empty($this->config->color_hover_1)){$this->content->color_hover_1 = $this->config->color_hover_1;} else {$this->content->color_hover_1 = '#2ac4ea';}
        if(!empty($this->config->color_hover_2)){$this->content->color_hover_2 = $this->config->color_hover_2;} else {$this->content->color_hover_2 = '#ff1053';}
        if(!empty($this->config->color_hover_3)){$this->content->color_hover_3 = $this->config->color_hover_3;} else {$this->content->color_hover_3 = '#2441e7';}
        if(!empty($this->config->color_hover_4)){$this->content->color_hover_4 = $this->config->color_hover_4;} else {$this->content->color_hover_4 = '#fbbc05';}
        if(!empty($this->config->color_icon_1)){$this->content->color_icon_1 = $this->config->color_icon_1;} else {$this->content->color_icon_1 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_icon_2)){$this->content->color_icon_2 = $this->config->color_icon_2;} else {$this->content->color_icon_2 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_icon_3)){$this->content->color_icon_3 = $this->config->color_icon_3;} else {$this->content->color_icon_3 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_icon_4)){$this->content->color_icon_4 = $this->config->color_icon_4;} else {$this->content->color_icon_4 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_icon_hover_1)){$this->content->color_icon_hover_1 = $this->config->color_icon_hover_1;} else {$this->content->color_icon_hover_1 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_icon_hover_2)){$this->content->color_icon_hover_2 = $this->config->color_icon_hover_2;} else {$this->content->color_icon_hover_2 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_icon_hover_3)){$this->content->color_icon_hover_3 = $this->config->color_icon_hover_3;} else {$this->content->color_icon_hover_3 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_icon_hover_4)){$this->content->color_icon_hover_4 = $this->config->color_icon_hover_4;} else {$this->content->color_icon_hover_4 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_title_1)){$this->content->color_title_1 = $this->config->color_title_1;} else {$this->content->color_title_1 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_title_2)){$this->content->color_title_2 = $this->config->color_title_2;} else {$this->content->color_title_2 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_title_3)){$this->content->color_title_3 = $this->config->color_title_3;} else {$this->content->color_title_3 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_title_4)){$this->content->color_title_4 = $this->config->color_title_4;} else {$this->content->color_title_4 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_title_hover_1)){$this->content->color_title_hover_1 = $this->config->color_title_hover_1;} else {$this->content->color_title_hover_1 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_title_hover_2)){$this->content->color_title_hover_2 = $this->config->color_title_hover_2;} else {$this->content->color_title_hover_2 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_title_hover_3)){$this->content->color_title_hover_3 = $this->config->color_title_hover_3;} else {$this->content->color_title_hover_3 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_title_hover_4)){$this->content->color_title_hover_4 = $this->config->color_title_hover_4;} else {$this->content->color_title_hover_4 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_body_hover_1)){$this->content->color_body_hover_1 = $this->config->color_body_hover_1;} else {$this->content->color_body_hover_1 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_body_hover_2)){$this->content->color_body_hover_2 = $this->config->color_body_hover_2;} else {$this->content->color_body_hover_2 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_body_hover_3)){$this->content->color_body_hover_3 = $this->config->color_body_hover_3;} else {$this->content->color_body_hover_3 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_body_hover_4)){$this->content->color_body_hover_4 = $this->config->color_body_hover_4;} else {$this->content->color_body_hover_4 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_body_1)){$this->content->color_body_1 = $this->config->color_body_1;} else {$this->content->color_body_1 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_body_2)){$this->content->color_body_2 = $this->config->color_body_2;} else {$this->content->color_body_2 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_body_3)){$this->content->color_body_3 = $this->config->color_body_3;} else {$this->content->color_body_3 = 'rgb(255,255,255)';}
        if(!empty($this->config->color_body_4)){$this->content->color_body_4 = $this->config->color_body_4;} else {$this->content->color_body_4 = 'rgb(255,255,255)';}








        if(!empty($this->config->style)){$this->content->style = $this->config->style;} else { $this->content->style = 0;}

        if(!empty($this->config->body)){$this->content->body = $this->config->body['text'];}
        if(!empty($this->content->style)){
          if ($this->content->style == 1) {
            $this->content->style = 'ccn-tablets-left';
          } else {
            $this->content->style = 'ccn-tablets-right';
          }
        }

        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_tablets', 'content');
        $this->content->image = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image .= '
                <li class="list-inline-item"><img class="img-fluid" src="'.$url.'" alt="'.$filename.'"></li>';
            }
        }



        $this->content->text = '
        <section class="home4_about">
      		<div class="container">
      			<div class="row '.$this->content->style.'">
      				<div class="col-lg-6 col-xl-6">
      					<div class="about_home3">';
                if (!empty($this->content->title)) {
      						$this->content->text .='<h3 data-ccn="title">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>';
                }
                if (!empty($this->content->subtitle)) {
      						$this->content->text .='<h5 data-ccn="subtitle">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</h5>';
                }
                if (!empty($this->content->body)) {
      						$this->content->text .= '<div data-ccn="body">'.format_text($this->content->body, FORMAT_HTML, array('filter' => true)).'</div>';
                }
                if (!empty($this->content->button_text) && !empty($this->content->button_link)) {
      					  $this->content->text .='	<a data-ccn="button_text" href="'.format_text($this->content->button_link, FORMAT_HTML, array('filter' => true)).'" class="btn about_btn_home3">'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).'</a>';
                }
                if(!empty($this->content->image)){
      						 $this->content->text .='
                   <ul class="partners_thumb_list">
      							'.$this->content->image.'
      						</ul>';
                }
                $this->content->text .='
      					</div>
      				</div>
      				<div class="col-lg-6 col-xl-6">
      					<div class="row">
      						<div class="col-sm-6 col-lg-6">';
                  if(!empty($this->content->feature_1_link)){
                    $this->content->text .= '<a href="'.$this->content->feature_1_link.'">';
                  }
                  $this->content->text .='
      							<div class="home3_about_icon_box five"
                      data-ccn-c="color_1"
                      data-ccn-co="bg"
                      data-ccn-cv="'.$this->content->color_1.'"
                      data-ccn-ch="color_hover_1"
                      data-ccn-ch-parent
                      data-ccn-ch-cv="'.$this->content->color_hover_1.'"
                      >
      								<div class="icon ccn-icon-reset"><span data-ccn="feature_1_icon" class="'.format_text($this->content->feature_1_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>
      								<div class="details">';
                      if(!empty($this->content->feature_1_title)){
      									$this->content->text .='<h4 data-ccn="feature_1_title"
                                                    data-ccn-c="color_title_1"
                                                    data-ccn-cv="'.$this->content->color_title_1.'"
                                                    data-ccn-ch="color_title_hover_1"
                                                    data-ccn-ch-cv="'.$this->content->color_title_hover_1.'"
                                                    data-ccn-ch-child
                                                    >'.format_text($this->content->feature_1_title, FORMAT_HTML, array('filter' => true)).'</h4>';
                      }
                      if(!empty($this->content->feature_1_subtitle)){
      									$this->content->text .=' <p data-ccn="feature_1_subtitle"
                                                    data-ccn-c="color_body_1"
                                                    data-ccn-cv="'.$this->content->color_body_1.'"
                                                    data-ccn-ch="color_body_hover_1"
                                                    data-ccn-ch-cv="'.$this->content->color_body_hover_1.'"
                                                    data-ccn-ch-child
                                                    >'.format_text($this->content->feature_1_subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
                      }
                      $this->content->text .='
      								</div>
      							</div>';
                    if(!empty($this->content->feature_1_link)){
                      $this->content->text .= '</a>';
                    }
                    $this->content->text .='
      						</div>
      						<div class="col-sm-6 col-lg-6">';
                  if(!empty($this->content->feature_2_link)){
                    $this->content->text .= '<a href="'.$this->content->feature_2_link.'">';
                  }
                  $this->content->text .='
      							<div class="home3_about_icon_box two"
                      data-ccn-c="color_2"
                      data-ccn-co="bg"
                      data-ccn-cv="'.$this->content->color_2.'"
                      data-ccn-ch="color_hover_2"
                      data-ccn-ch-parent
                      data-ccn-ch-cv="'.$this->content->color_hover_2.'"
                    >
      								<div class="icon ccn-icon-reset"><span data-ccn="feature_2_icon" class="'.format_text($this->content->feature_2_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>
      								<div class="details">';
                      if(!empty($this->content->feature_2_title)){
      									$this->content->text .='<h4 data-ccn="feature_2_title"
                                                    data-ccn-c="color_title_2"
                                                    data-ccn-cv="'.$this->content->color_title_2.'"
                                                    data-ccn-ch="color_title_hover_2"
                                                    data-ccn-ch-cv="'.$this->content->color_title_hover_2.'"
                                                    data-ccn-ch-child
                                                    >'.format_text($this->content->feature_2_title, FORMAT_HTML, array('filter' => true)).'</h4>';
                      }
                      if(!empty($this->content->feature_2_subtitle)){
                        $this->content->text .='<p  data-ccn="feature_2_subtitle"
                                                    data-ccn-c="color_body_2"
                                                    data-ccn-cv="'.$this->content->color_body_2.'"
                                                    data-ccn-ch="color_body_hover_2"
                                                    data-ccn-ch-cv="'.$this->content->color_body_hover_2.'"
                                                    data-ccn-ch-child
                                                    >'.format_text($this->content->feature_2_subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
                      }
                      $this->content->text .='
      								</div>
      							</div>';
                    if(!empty($this->content->feature_2_link)){
                      $this->content->text .= '</a>';
                    }
                    $this->content->text .='
      						</div>
      						<div class="col-sm-6 col-lg-6">';
                  if(!empty($this->content->feature_3_link)){
                    $this->content->text .= '<a href="'.$this->content->feature_3_link.'">';
                  }
                  $this->content->text .='
      							<div class="home3_about_icon_box six"
                      data-ccn-c="color_3"
                      data-ccn-co="bg"
                      data-ccn-cv="'.$this->content->color_3.'"
                      data-ccn-ch="color_hover_3"
                      data-ccn-ch-parent
                      data-ccn-ch-cv="'.$this->content->color_hover_3.'"
                    >
      								<div class="icon ccn-icon-reset"><span data-ccn="feature_3_icon" class="'.format_text($this->content->feature_3_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>
      								<div class="details">';
                      if(!empty($this->content->feature_3_title)){
      									$this->content->text .='<h4 data-ccn="feature_3_title"
                                                    data-ccn-c="color_title_3"
                                                    data-ccn-cv="'.$this->content->color_title_3.'"
                                                    data-ccn-ch="color_title_hover_3"
                                                    data-ccn-ch-cv="'.$this->content->color_title_hover_3.'"
                                                    data-ccn-ch-child
                                                    >'.format_text($this->content->feature_3_title, FORMAT_HTML, array('filter' => true)).'</h4>';
                      }
                      if(!empty($this->content->feature_3_subtitle)){
      									$this->content->text .=' <p data-ccn="feature_3_subtitle"
                                                    data-ccn-c="color_body_3"
                                                    data-ccn-cv="'.$this->content->color_body_3.'"
                                                    data-ccn-ch="color_body_hover_3"
                                                    data-ccn-ch-cv="'.$this->content->color_body_hover_3.'"
                                                    data-ccn-ch-child
                                                    >'.format_text($this->content->feature_3_subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
                      }
                      $this->content->text .='
      								</div>
      							</div>';
                    if(!empty($this->content->feature_3_link)){
                      $this->content->text .= '</a>';
                    }
                    $this->content->text .= '
      						</div>
      						<div class="col-sm-6 col-lg-6">';
                  if(!empty($this->content->feature_4_link)){
                    $this->content->text .= '<a href="'.$this->content->feature_4_link.'">';
                  }
                  $this->content->text .= '
      							<div class="home3_about_icon_box seven"
                      data-ccn-c="color_4"
                      data-ccn-co="bg"
                      data-ccn-cv="'.$this->content->color_4.'"
                      data-ccn-ch="color_hover_4"
                      data-ccn-ch-parent
                      data-ccn-ch-cv="'.$this->content->color_hover_4.'"
                    >
      								<div class="icon ccn-icon-reset"><span data-ccn="feature_4_icon" class="'.format_text($this->content->feature_4_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>
      								<div class="details">';
                      if(!empty($this->content->feature_4_title)){
      									$this->content->text .='
      									<h4 data-ccn="feature_4_title"
                            data-ccn-c="color_title_4"
                            data-ccn-cv="'.$this->content->color_title_4.'"
                            data-ccn-ch="color_title_hover_4"
                            data-ccn-ch-cv="'.$this->content->color_title_hover_4.'"
                            data-ccn-ch-child
                            >'.format_text($this->content->feature_4_title, FORMAT_HTML, array('filter' => true)).'</h4>';
                      }
                      if(!empty($this->content->feature_4_subtitle)){
      									$this->content->text .='
								         <p data-ccn="feature_4_subtitle"
                            data-ccn-c="color_body_4"
                            data-ccn-cv="'.$this->content->color_body_4.'"
                            data-ccn-ch="color_body_hover_4"
                            data-ccn-ch-cv="'.$this->content->color_body_hover_4.'"
                            data-ccn-ch-child
                            >'.format_text($this->content->feature_4_subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
                      }
                      $this->content->text .='
                            								</div>
      							</div>';
                    if(!empty($this->content->feature_4_link)){
                      $this->content->text .= '</a>';
                    }
                    $this->content->text .='
      						</div>
      					</div>
      				</div>
      			</div>
      			<div class="row">
      				<div class="col-lg-12">
      					<div class="about_home3_shape_container">
      						<div class="about_home3_shape"><img src="'.$CFG->wwwroot.'/theme/edumy/images/about/shape1.png" alt=""></div>
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
