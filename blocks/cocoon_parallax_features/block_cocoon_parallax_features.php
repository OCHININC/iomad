<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_parallax_features extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('pluginname', 'block_cocoon_parallax_features');
    }

    // Declare second
    public function specialization()
    {
        // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->slidesnumber = '8';
          $this->config->title = 'Included Features';
          $this->config->subtitle = 'Cum doctus civibus efficiantur in imperdiet deterruisset.';
          $this->config->title1 = 'Multimedia Center';
          $this->config->title2 = 'Courses Hub';
          $this->config->title3 = 'Online Study App';
          $this->config->title4 = 'Best Teacher Course';
          $this->config->title5 = 'Unlimited Learning';
          $this->config->title6 = 'Custom Dashboard';
          $this->config->title7 = 'Preimum Recommended';
          $this->config->title8 = 'Infinite Hours';
          $this->config->link1 = '#';
          $this->config->link2 = '#';
          $this->config->link3 = '#';
          $this->config->link4 = '#';
          $this->config->link5 = '#';
          $this->config->link6 = '#';
          $this->config->link7 = '#';
          $this->config->link8 = '#';
          $this->config->icon1 = 'flaticon-student-3';
          $this->config->icon2 = 'flaticon-trophy';
          $this->config->icon3 = 'flaticon-review';
          $this->config->icon4 = 'flaticon-elearning';
          $this->config->icon5 = 'flaticon-play-button';
          $this->config->icon6 = 'flaticon-puzzle-1';
          $this->config->icon7 = 'flaticon-send';
          $this->config->icon8 = 'flaticon-clock';
          $this->config->color_bg = '#2441e7';
          $this->config->color_title = '#ffffff';
          $this->config->color_subtitle = '#ffffff';
          $this->config->color_icon = '#00eb74';
          $this->config->color_hover = '#cdbe9c';
        }
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content         =  new stdClass;
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->subtitle = '';}

        if(!empty($this->config->color_bg)){$this->content->color_bg = $this->config->color_bg;} else {$this->content->color_bg = '#2441e7';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = '#fff';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = '';}
        if(!empty($this->config->color_icon)){$this->content->color_icon = $this->config->color_icon;} else {$this->content->color_icon = '#00eb74';}
        if(!empty($this->config->color_hover)){$this->content->color_hover = $this->config->color_hover;} else {$this->content->color_hover = '#cdbe9c';}




        // if(!empty($this->config->counter_1)){$this->content->counter_1 = $this->config->counter_1;}
        // if(!empty($this->config->counter_1_text)){$this->content->counter_1_text = $this->config->counter_1_text;}
        // if(!empty($this->config->counter_1_icon)){$this->content->counter_1_icon = $this->config->counter_1_icon;}
        // if(!empty($this->config->counter_2)){$this->content->counter_2 = $this->config->counter_2;}
        // if(!empty($this->config->counter_2_text)){$this->content->counter_2_text = $this->config->counter_2_text;}
        // if(!empty($this->config->counter_2_icon)){$this->content->counter_2_icon = $this->config->counter_2_icon;}
        // if(!empty($this->config->counter_3)){$this->content->counter_3 = $this->config->counter_3;}
        // if(!empty($this->config->counter_3_text)){$this->content->counter_3_text = $this->config->counter_3_text;}
        // if(!empty($this->config->counter_3_icon)){$this->content->counter_3_icon = $this->config->counter_3_icon;}
        // if(!empty($this->config->counter_4)){$this->content->counter_4 = $this->config->counter_4;}
        // if(!empty($this->config->counter_4_text)){$this->content->counter_4_text = $this->config->counter_4_text;}
        // if(!empty($this->config->counter_4_icon)){$this->content->counter_4_icon = $this->config->counter_4_icon;}
        if ($this->config->style == 1) {
          $this->content->style = 'divider_home2';
        } else {
          $this->content->style = 'divider_home1';
        }


        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 8;
        } else {
            $data = new stdClass();
            $data->slidesnumber = '8';
        }

        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_parallax_features', 'content');
        $this->content->image = $CFG->wwwroot.'/theme/edumy/images/background/3.jpg';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image =  $url;
            }
        }



        $this->content->text = '

        <style type="text/css">
        .ccn-parallax-bg-'.$this->instance->id.':before{
          background: '.$this->content->color_bg.';
        }
        .ccn-parallax-bg-'.$this->instance->id.' .funfact_ccn_feature:hover .ccn_icon {
          background-color:'.$this->content->color_hover.';
        }
        </style>
        <section class="ccn-parallax-bg-'.$this->instance->id.' '.$this->content->style.' parallax bg-img2" data-ccn="image" data-ccn-img="bg-img-url" data-stellar-background-ratio="0.5"  style="background-image:url('.$this->content->image.');background-size:cover;">
      		<div class="container">
      			<div class="row">
      				<div class="col-lg-6 offset-lg-3">
      					<div class="main-title text-center">
      						<h3 data-ccn="title" data-ccn-c="color_title" data-ccn-co="content" class="ccn-color-white-soft mt0" style="color:'.$this->content->color_title.'">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
      						<p data-ccn="subtitle" data-ccn-c="color_subtitle" data-ccn-co="content" class="ccn-color-white-soft" style="color:'.$this->content->color_subtitle.'">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
      					</div>
      				</div>
      			</div>
      			<div class="row">';

            if ($data->slidesnumber > 0) {

              for ($i = 1; $i <= $data->slidesnumber; $i++) {
                  $title = 'title' . $i;
                  $link = 'link' . $i;
                  $icon = 'icon' . $i;
                  $icon_color = 'color_icon' . $i;

$this->content->text .= '
<div class="col-sm-6 col-lg-3 text-center">
  <div class="funfact_one funfact_ccn_feature">';
  if(!empty($data->$link)){
    $this->content->text .='<a href="'.$data->$link.'">';
  }
   $this->content->text .='
    <div class="ccn_icon"><span data-ccn="icon'.$i.'" data-ccn-c="color_icon'.$i.'" data-ccn-co="content" class="'.format_text($data->$icon, FORMAT_HTML, array('filter' => true)).'" style="color:'.$this->content->color_icon.'"></span></div>
    <div class="details">
      <h5 data-ccn="title'.$i.'">'.format_text($data->$title, FORMAT_HTML, array('filter' => true)).'</h5>
    </div>';
    if(!empty($data->$link)){
      $this->content->text .='</a>';
    }
     $this->content->text .='
  </div>
</div>
';
                }
}
$this->content->text .='

      			</div>
      		</div>
      	</section>
';
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
