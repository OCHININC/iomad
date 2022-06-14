<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_services extends block_base {

  public function init(){
    $this->title = get_string('pluginname', 'block_cocoon_services');
  }

  public function specialization() {
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
    $files = $fs->get_area_files($this->context->id, 'block_cocoon_services', 'content');
    $this->content->image = '';
    foreach ($files as $file) {
        $filename = $file->get_filename();
        if ($filename <> '.') {
            $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
            $this->content->image .=  $url;
        }
    }



    $this->content->text = '
    <section class="whychose_us">
  		<div class="container">
  			<div class="row">
  				<div class="col-lg-6 offset-lg-3">
  					<div class="main-title text-center">
  						<h3 class="mt0" data-ccn="title">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
  						<p class="" data-ccn="subtitle">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
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
<div class="why_chose_us '.$this->content->style.'">';
if(!empty($data->$link)){
$this->content->text .='<a href="'.$data->$link.'">';
}
$this->content->text .='
				<div class="icon">
					<span data-ccn="icon'.$i.'" class="'.format_text($data->$icon, FORMAT_HTML, array('filter' => true)).'"></span>
				</div>
				<div class="details">
					<h4 data-ccn="title'.$i.'">'.format_text($data->$title, FORMAT_HTML, array('filter' => true)).'</h4>
					<p data-ccn="body'.$i.'">'.format_text($data->$body, FORMAT_HTML, array('filter' => true)).'</p>
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
