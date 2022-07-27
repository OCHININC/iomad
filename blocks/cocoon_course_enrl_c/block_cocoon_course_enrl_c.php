<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_course_enrl_c extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_course_enrl_c', 'block_cocoon_course_enrl_c');
    }

    // Declare second
    public function specialization()
    {
      global $CFG;
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('course-view'));
    }

    public function get_content()
    {
        global $CFG, $DB, $COURSE, $USER;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new \stdClass();
        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->items = is_numeric($data->items) ? (int)$data->items : 0;
        } else {
            $data = new stdClass();
            $data->items = 0;
        }
        $context = context_course::instance($COURSE->id, MUST_EXIST);


        if(!empty($this->config->price_title)){$this->content->price_title = format_text($this->config->price_title, FORMAT_HTML, array('filter' => true));}
        if(!empty($this->config->price)){$this->content->price = format_text($this->config->price, FORMAT_HTML, array('filter' => true));}
        if(!empty($this->config->full_price)){$this->content->full_price = format_text($this->config->full_price, FORMAT_HTML, array('filter' => true));}
        if(!empty($this->config->add_to_cart_text)){$this->content->add_to_cart_text = format_text($this->config->add_to_cart_text, FORMAT_HTML, array('filter' => true));}
        if(!empty($this->config->add_to_cart_link)){$this->content->add_to_cart_link = format_text($this->config->add_to_cart_link, FORMAT_HTML, array('filter' => true));}
        if(!empty($this->config->buy_now_text)){$this->content->buy_now_text = format_text($this->config->buy_now_text, FORMAT_HTML, array('filter' => true));}
        if(!empty($this->config->buy_now_link)){$this->content->buy_now_link = format_text($this->config->buy_now_link, FORMAT_HTML, array('filter' => true));}
        // if(!empty($this->config->includes_title)){$this->content->includes_title = $this->config->includes_title;}
        // if(!empty($this->config->video_text)){$this->content->video_text = $this->config->video_text;}
        // if(!empty($this->config->download_text)){$this->content->download_text = $this->config->download_text;}
        // if(!empty($this->config->access_text)){$this->content->access_text = $this->config->access_text;}
        // if(!empty($this->config->devices_text)){$this->content->devices_text = $this->config->devices_text;}
        // if(!empty($this->config->assignments_text)){$this->content->assignments_text = $this->config->assignments_text;}
        // if(!empty($this->config->certificate_text)){$this->content->certificate_text = $this->config->certificate_text;}

        $this->content->text = '
        <div class="instructor_pricing_widget">';
        if (is_enrolled($context, $USER, '', true)) {
          $this->content->text .='
                                  <div class="price"> '. get_string('course_enrolled', 'theme_edumy') .' </div>
                                  <p class="mt10">'. get_string('course_enrolled_text', 'theme_edumy') .'</p>';
        } else {

          if(!empty($this->content->price) || !empty($this->content->price_title) || !empty($this->content->full_price)){
            $this->content->text .='<div class="price"><span>'. $this->content->price_title .'</span> '. $this->content->price .' <small>'. $this->content->full_price .'</small></div>';
          }
          if(!empty($this->content->add_to_cart_link) && !empty($this->content->add_to_cart_text)){
            $this->content->text .=' <a href="'. $this->content->add_to_cart_link .'" class="cart_btnss">'. $this->content->add_to_cart_text .'</a>';
          }
          if(!empty($this->content->buy_now_link) && !empty($this->content->buy_now_text)){
            $this->content->text .='<a href="'. $this->content->buy_now_link .'" class="cart_btnss_white">'. $this->content->buy_now_text .'</a>';
          }
          // if(!empty($this->content->includes_title)){
          //   $this->content->text .='<h5 class="subtitle text-left">'. $this->content->includes_title .'</h5>';
          // }
          $this->content->text .='<ul class="price_quere_list text-left">';
          if ($data->items > 0) {
            $this->content->text .='<ul class="price_quere_list text-left">';

            for ($i = 1; $i <= $data->items; $i++) {
              $item_title = 'item_title' . $i;
              $item_icon = 'item_icon' . $i;
              $this->content->text .='<li><div class="ccn-course-details-item"><span class="'.format_text($data->$item_icon, FORMAT_HTML, array('filter' => true)).'"></span> '.format_text($data->$item_title, FORMAT_HTML, array('filter' => true)).'</div></li>';
            }

            $this->content->text .='</ul>';

          }

          $this->content->text .='
          </ul>';
        }
         $this->content->text .='
        </div>';
        return $this->content;
    }
    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }

}
