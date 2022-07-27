<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_gallery extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_gallery', 'block_cocoon_gallery');
    }

    // Declare second
    public function specialization()
    {
        // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
        global $CFG;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content         =  new \stdClass();
        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;}
        if(!empty($this->config->columns)){
          if($this->config->columns == 4) { //6
            $columns = 'col-sm-6 col-md-6 col-lg-2 ccn_gallery_col_6';
          } elseif($this->config->columns == 3) { //4
            $columns = 'col-sm-6 col-md-6 col-lg-3 ccn_gallery_col_4';
          } elseif($this->config->columns == 2) { //3
            $columns = 'col-sm-6 col-md-4 col-lg-4 ccn_gallery_col_3';
          } elseif($this->config->columns == 1) { //2
            $columns = 'col-sm-6 col-md-6 col-lg-6 ccn_gallery_col_2';
          } else { //1
            $columns = 'col-sm-12 col-md-12 col-lg-12';
          }
        } else {
          $columns = 'col-sm-6 col-md-6 col-lg-3';
        }
        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_gallery', 'content');
        $this->content->image = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image .= '
                  <div class="'.$columns.'">
					          <div class="gallery_item">
						          <img class="img-fluid img-circle-rounded w100" src="' . $url . '" alt="' . $filename . '">
						            <div class="gallery_overlay">
                          <a class="ccn-icon popup-img" href="' . $url . '"><span class="flaticon-zoom-in"></span></a>
                        </div>
				              </div>
                    </div>';
            }
        }

        $this->content->text = '
        <section class="about-section pb30">
      		<div class="container">';
          if($this->content->title || $this->content->subtitle){
            $this->content->text .='
            <div class="row">
				      <div class="col-lg-6 offset-lg-3">
					      <div class="main-title text-center">
						      <h3 class="mt0">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
						      <p>'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
					      </div>
				      </div>
			      </div>';
          }
          $this->content->text .='
      			<div class="row">
              '. $this->content->image .'
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
