<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_services_dark extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('pluginname', 'block_cocoon_services_dark');
    }

    // Declare second
    public function specialization()
    {
        // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->slidesnumber = '3';
          $this->config->title = 'Why Choose Us';
          $this->config->subtitle = 'Cum doctus civibus efficiantur in imperdiet deterruisset.';
          $this->config->title1 = 'Trusted by Thousands';
          $this->config->title2 = 'Premium Memberships';
          $this->config->title3 = 'Qualified Instructors';
          $this->config->body1 = 'Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.';
          $this->config->body2 = 'Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.';
          $this->config->body3 = 'Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.';
          $this->config->icon1 = 'flaticon-student-3';
          $this->config->icon2 = 'flaticon-first';
          $this->config->icon3 = 'flaticon-employee';

          $this->config->color_bg = 'rgb(0, 8, 70)';
          $this->config->color_title = 'rgb(255,255,255)';
          $this->config->color_subtitle = 'rgb(255,255,255)';
          $this->config->color_item_title = 'rgb(255,255,255)';
          $this->config->color_item_body = 'rgba(255, 255, 255, .6)';
          $this->config->c_ccn_ic = 'rgb(22, 32, 90)';
          $this->config->c_ccn_i = '#f0d078';
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
        if(!empty($this->config->color_bg)){$this->content->color_bg = $this->config->color_bg;} else {$this->content->color_bg = 'rgb(0, 8, 70)';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = 'rgb(255,255,255)';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = 'rgb(255,255,255)';}
        if(!empty($this->config->color_item_title)){$this->content->color_item_title = $this->config->color_item_title;} else {$this->content->color_item_title = 'rgb(255,255,255)';}
        if(!empty($this->config->color_item_body)){$this->content->color_item_body = $this->config->color_item_body;} else {$this->content->color_item_body = 'rgba(255, 255, 255, .6)';}
        if(!empty($this->config->c_ccn_ic)){$this->content->c_ccn_ic = $this->config->c_ccn_ic;} else {$this->content->c_ccn_ic = 'rgb(22, 32, 90)';}
        if(!empty($this->config->c_ccn_i)){$this->content->c_ccn_i = $this->config->c_ccn_i;} else {$this->content->c_ccn_i = '#f0d078';}

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
          $this->content->style = '';
        } else {
          $this->content->style = 'style2';
        }


        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 3;
        } else {
            $data = new stdClass();
            $data->slidesnumber = '3';
        }

        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_services_dark', 'content');
        $this->content->image = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image .=  $url;
            }
        }



        $this->content->text = '
        <section class="whychose_us" data-ccn-c="color_bg" data-ccn-co="bg" data-ccn-cv="'.$this->content->color_bg.'">
      		<div class="container">
      			<div class="row">
      				<div class="col-lg-6 offset-lg-3">
      					<div class="main-title text-center">
      						<h3 class="mt0" data-ccn="title" data-ccn-c="color_title" data-ccn-cv="'.$this->content->color_title.'">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
      						<p class="" data-ccn="subtitle" data-ccn-c="color_subtitle" data-ccn-cv="'.$this->content->color_subtitle.'">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
      					</div>
      				</div>
      			</div>
      			<div class="row">';

            if ($data->slidesnumber > 0) {

              for ($i = 1; $i <= $data->slidesnumber; $i++) {
                  $title = 'title' . $i;
                  $link = 'link' . $i;
                  $icon = 'icon' . $i;
                  $body = 'body' . $i;

$this->content->text .= '
<div class="col-md-6 col-lg-4 col-xl-4">
<div class="why_chose_us '.$this->content->style.'" data-ccn-c="c_ccn_i_c" data-ccn-co="bg" data-ccn-cv="'.$this->content->c_ccn_ic.'">';
if(!empty($data->$link)){
  $this->content->text .='<a href="'.$data->$link.'">';
}
$this->content->text .='
						<div class="icon">
							<span data-ccn="icon'.$i.'" data-ccn-c="c_ccn_i" data-ccn-cv="'.$this->content->c_ccn_i.'" class="'.format_text($data->$icon, FORMAT_HTML, array('filter' => true)).'"></span>
						</div>
						<div class="details">
							<h4 data-ccn="title'.$i.'" data-ccn-c="color_item_title" data-ccn-cv="'.$this->content->color_item_title.'">'.format_text($data->$title, FORMAT_HTML, array('filter' => true)).'</h4>
							<p data-ccn="body'.$i.'" data-ccn-c="color_item_body" data-ccn-cv="'.$this->content->color_item_body.'">'.format_text($data->$body, FORMAT_HTML, array('filter' => true)).'</p>
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
