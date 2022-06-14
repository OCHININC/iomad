<?php

require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_boxes extends block_base {
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_boxes');
    }

    function has_config() {
        return true;
    }

    function instance_allow_multiple() {
        return true;
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
    }

    function specialization() {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->items = '4';
          $this->config->title1 = 'Create Account';
          $this->config->title2 = 'Create Account';
          $this->config->title3 = 'Create Account';
          $this->config->title4 = 'Create Account';
          $this->config->link1 = '#';
          $this->config->link2 = '#';
          $this->config->link3 = '#';
          $this->config->link4 = '#';
          $this->config->body1 = 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.';
          $this->config->body2 = 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.';
          $this->config->body3 = 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.';
          $this->config->body4 = 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.';
          $this->config->color1 = 'rgb(245, 245, 246)';
          $this->config->color2 = 'rgb(245, 245, 246)';
          $this->config->color3 = 'rgb(245, 245, 246)';
          $this->config->color4 = 'rgb(245, 245, 246)';
          $this->config->color_hover1 = 'rgb(62, 68, 72)';
          $this->config->color_hover2 = 'rgb(62, 68, 72)';
          $this->config->color_hover3 = 'rgb(62, 68, 72)';
          $this->config->color_hover4 = 'rgb(62, 68, 72)';
          $this->config->color_icon1 = 'rgb(205, 190, 156)';
          $this->config->color_icon2 = 'rgb(205, 190, 156)';
          $this->config->color_icon3 = 'rgb(205, 190, 156)';
          $this->config->color_icon4 = 'rgb(205, 190, 156)';
          $this->config->color_icon_hover1 = 'rgb(205, 190, 156)';
          $this->config->color_icon_hover2 = 'rgb(205, 190, 156)';
          $this->config->color_icon_hover3 = 'rgb(205, 190, 156)';
          $this->config->color_icon_hover4 = 'rgb(205, 190, 156)';
          $this->config->color_title1 = 'rgb(62, 68, 72)';
          $this->config->color_title2 = 'rgb(62, 68, 72)';
          $this->config->color_title3 = 'rgb(62, 68, 72)';
          $this->config->color_title4 = 'rgb(62, 68, 72)';
          $this->config->color_title_hover1 = 'rgb(255,255,255)';
          $this->config->color_title_hover2 = 'rgb(255,255,255)';
          $this->config->color_title_hover3 = 'rgb(255,255,255)';
          $this->config->color_title_hover4 = 'rgb(255,255,255)';
          $this->config->color_body_hover1 = 'rgb(255,255,255)';
          $this->config->color_body_hover2 = 'rgb(255,255,255)';
          $this->config->color_body_hover3 = 'rgb(255,255,255)';
          $this->config->color_body_hover4 = 'rgb(255,255,255)';
          $this->config->color_body1 = 'rgb(62, 68, 72)';
          $this->config->color_body2 = 'rgb(62, 68, 72)';
          $this->config->color_body3 = 'rgb(62, 68, 72)';
          $this->config->color_body4 = 'rgb(62, 68, 72)';
          $this->config->icon1 = 'flaticon-student-3';
          $this->config->icon2 = 'flaticon-trophy';
          $this->config->icon3 = 'flaticon-student-1';
          $this->config->icon4 = 'flaticon-rating';

          $this->config->title = 'What We Do';
          $this->config->subtitle = 'Cum doctus civibus efficiantur in imperdiet deterruisset.';
          $this->config->color_bg = '#fff';
          $this->config->color_title = '#0a0a0a';
          $this->config->color_subtitle = '#6f7074';
        }

    }


    function instance_allow_config() {
        return true;
    }

    function get_content() {
        global $CFG, $USER, $DB, $OUTPUT;

        if($this->content !== NULL) {
            return $this->content;
        }

        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->items = is_numeric($data->items) ? (int)$data->items : 4;
        } else {
            $data = new stdClass();
            $data->items = 4;
        }

        $this->content = new stdClass;
        $this->content->text = '';
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->subtitle = '';}
        if(!empty($this->config->color_bg)){$this->content->color_bg = $this->config->color_bg;} else {$this->content->color_bg = '#fff';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = '#0a0a0a';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = '#6f7074';}

        // if ($data->items > 0) {
        $this->content->text = '

        <section id="our-courses" class="our-courses pt90 pt650-992" data-ccn-c="color_bg" data-ccn-cv="'.$this->content->color_bg.'" data-ccn-co="bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					'.$this->content->style.'
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="main-title text-center">';
         $this->content->text .=' <h3 data-ccn="title" data-ccn-c="color_title" data-ccn-cv="'.$this->content->color_title.'" class="mt0">'. format_text($this->content->title, FORMAT_HTML, array('filter' => true)) .'</h3>';
          $this->content->text .='<p data-ccn="subtitle" data-ccn-c="color_subtitle" data-ccn-cv="'.$this->content->color_subtitle.'" >'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
        $this->content->text .='
        </div>
      </div>

			</div>
			<div class="row">
      <div class="col-12">
      <div class="row justify-content-center">';

          $col_class = "";
          if ($data->items == 1) {
            $col_class = "col-sm-12 col-lg-12";
          } else if ($data->items == 2) {
            $col_class = "col-sm-6 col-lg-6";
          } else if ($data->items == 3) {
            $col_class = "col-sm-6 col-lg-4";
          } else {
            $col_class = "col-sm-6 col-lg-3";
          }
          if ($data->items > 0) {
            for ($i = 1; $i <= $data->items; $i++) {
              $icon = 'icon' . $i;
              $icon_color = 'color_icon' . $i;
              $icon_color_hover = 'color_icon_hover' . $i;
              $title_color = 'color_title' . $i;
              $title_color_hover = 'color_title_hover' . $i;
              $body_color = 'color_body' . $i;
              $body_color_hover = 'color_body_hover' . $i;
              $color = 'color' . $i;
              $color_hover = 'color_hover' . $i;
              $title = 'title' . $i;
              $body = 'body' . $i;
              $link = 'link' . $i;
              $link_target = 'link_target' . $i;

              $this->content->text .='
              <style type="text/css">
              .icon_hvr_img_box.ccn-box[data-ccn-c=color'.$i.']:hover {
                background-color:'.$data->$color_hover.'!important;
              }
              .icon_hvr_img_box.ccn-box[data-ccn-c=color'.$i.']:hover h5 {
                color:'.$data->$title_color_hover.'!important;
              }
              .icon_hvr_img_box.ccn-box[data-ccn-c=color'.$i.']:hover p {
                color:'.$data->$body_color_hover.'!important;
              }
              .icon_hvr_img_box.ccn-box[data-ccn-c=color'.$i.']:hover .icon span {
                color:'.$data->$icon_color_hover.'!important;
              }
              </style>
              <div class="col-sm-6 col-lg-3">';
              if(!empty($data->$link)){
                $this->content->text .='<a href="'.$data->$link.'" target="'.$data->$link_target.'">';
              }
              $this->content->text .='
      					<div class="icon_hvr_img_box ccn-box sbbg1" data-ccn-c="color'.$i.'" data-ccn-co="bg" style="background-color: '.$data->$color.';">
      						<div class="overlay">
      							<div class="ccn_icon_2 icon"><span data-ccn="icon'.$i.'" data-ccn-c="color_icon'.$i.'" data-ccn-co="content" class="'.$data->$icon.'" style="color:'.$data->$icon_color.'"></span></div>
      							<div class="details">
      								<h5 data-ccn="title'.$i.'" data-ccn-c="color_title'.$i.'" data-ccn-co="content" style="color:'.$data->$title_color.'">'.format_text($data->$title, FORMAT_HTML, array('filter' => true)).'</h5>
      								<p data-ccn="body'.$i.'" data-ccn-c="color_body'.$i.'" data-ccn-co="content" style="color:'.$data->$body_color.'">'.format_text($data->$body, FORMAT_HTML, array('filter' => true)).'</p>
      							</div>
      						</div>
      					</div>';
              if(!empty($data->$link)){
                $this->content->text .='</a>';
              }
              $this->content->text .='
      				</div>';
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
}
