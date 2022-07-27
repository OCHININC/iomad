<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_gallery_slider extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_gallery_slider', 'block_cocoon_gallery_slider');
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
        if(!empty($this->config->title)){$this->content->title = $this->config->title;}else{$this->content->title = 'Media';}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;}else{$this->content->subtitle = 'Cum doctus civibus efficiantur in imperdiet deterruisset.';}
        if(!empty($this->config->columns)){
          if($this->config->columns == 7) { //8
            $columns = '8';
          } elseif($this->config->columns == 6) { //7
            $columns = '7';
          } elseif($this->config->columns == 5) { //6
            $columns = '6';
          } elseif($this->config->columns == 4) { //5
            $columns = '5';
          } elseif($this->config->columns == 3) { //4
            $columns = '4';
          } elseif($this->config->columns == 2) { //3
            $columns = '3';
          } elseif($this->config->columns == 1) { //2
            $columns = '2';
          } else { //1
            $columns = '1';
          }
        } else {
          $columns = '3';
        }

        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_gallery_slider', 'content');
        $this->content->image = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image .= '
                <div class="item">
               	  <div class="media_item_box">
                    <div class="thumb">
                      <img class="img-fluid img-rounded" src="'.$url.'" alt="'. $filename .'">
                    </div>
    							</div>
    						</div>';
            }
        }



        $this->content->text = '
        <section class="our-media">
		      <div class="container-fluid p0">
			       <div class="row">
				        <div class="col-lg-6 offset-lg-3">
					        <div class="main-title text-center">';
						        if($this->content->title){
                     $this->content->text .='<h3 class="mt0">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>';
                    }
                    if($this->content->subtitle){
                      $this->content->text .='<p>'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
                    }
                    $this->content->text .='
					        </div>
	              </div>
             </div>
			       <div class="row">
	             <div class="col-lg-12">
					       <div class="ccn_media_slider_home7 ccn_slider_'.$this->instance->id.'">
                   '. $this->content->image .'
                 </div>
               </div>
             </div>
           </div>
         </section>
         <script type="text/javascript">
           (function($){
             $(window).on("load", function() {
               if($(".ccn_slider_'.$this->instance->id.'").length){
                   $(".ccn_slider_'.$this->instance->id.'").owlCarousel({
                       loop:false,
                       margin:15,
                       dots:false,
                       nav:true,
                       rtl:false,
                       autoplayHoverPause:false,
                       autoplay: true,
                       singleItem: true,
                       smartSpeed: 1200,
                       navText: [
                         \'<i class="flaticon-left-arrow"></i>\',
                         \'<i class="flaticon-right-arrow-1"></i>\'
                       ],
                       responsive: {
                           0: {
                               items: 1,
                               center: false
                           },
                           480:{
                               items:1,
                               center: false
                           },
                           520:{
                               items:1,
                               center: false
                           },
                           600: {
                               items: 1,
                               center: false
                           },
                           768: {
                               items: 2
                           },
                           992: {
                               items: '.$columns.'
                           },
                           1200: {
                               items: '.$columns.'
                           },
                           1366: {
                               items: '.$columns.'
                           },
                           1400: {
                               items: '.$columns.'
                           }
                       }
                   })
               }
             });
           }(jQuery));
         </script>
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
