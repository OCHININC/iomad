<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_steps extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('pluginname', 'block_cocoon_steps');
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
          $this->config->title = 'See How It Works';
          $this->config->subtitle = 'Technology is brining a massive wave of evolution on learning things on different ways.';
          $this->config->title1 = 'Choose What To Do';
          $this->config->title2 = 'Choose What To Do';
          $this->config->title3 = 'Choose What To Do';
          $this->config->body1 = 'Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.';
          $this->config->body2 = 'Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.';
          $this->config->body3 = 'Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.';
          $this->config->link1 = '#';
          $this->config->link2 = '#';
          $this->config->link3 = '#';
          $this->config->image1 = $CFG->wwwroot . '/theme/edumy/images/process/1.png';
          $this->config->image2 = $CFG->wwwroot . '/theme/edumy/images/process/2.png';
          $this->config->image3 = $CFG->wwwroot . '/theme/edumy/images/process/3.png';

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
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;} else {$this->content->title = '';}
        // if(!empty($this->config->counter_1)){$this->content->counter_1 = $this->config->counter_1;} else {$this->content->title = '';}
        // if(!empty($this->config->counter_1_text)){$this->content->counter_1_text = $this->config->counter_1_text;} else {$this->content->title = '';}
        // if(!empty($this->config->counter_1_icon)){$this->content->counter_1_icon = $this->config->counter_1_icon;} else {$this->content->title = '';}
        // if(!empty($this->config->counter_2)){$this->content->counter_2 = $this->config->counter_2;} else {$this->content->title = '';}
        // if(!empty($this->config->counter_2_text)){$this->content->counter_2_text = $this->config->counter_2_text;} else {$this->content->title = '';}
        // if(!empty($this->config->counter_2_icon)){$this->content->counter_2_icon = $this->config->counter_2_icon;} else {$this->content->title = '';}
        // if(!empty($this->config->counter_3)){$this->content->counter_3 = $this->config->counter_3;} else {$this->content->title = '';}
        // if(!empty($this->config->counter_3_text)){$this->content->counter_3_text = $this->config->counter_3_text;} else {$this->content->title = '';}
        // if(!empty($this->config->counter_3_icon)){$this->content->counter_3_icon = $this->config->counter_3_icon;} else {$this->content->title = '';}
        // if(!empty($this->config->counter_4)){$this->content->counter_4 = $this->config->counter_4;} else {$this->content->title = '';}
        // if(!empty($this->config->counter_4_text)){$this->content->counter_4_text = $this->config->counter_4_text;} else {$this->content->title = '';}
        // if(!empty($this->config->counter_4_icon)){$this->content->counter_4_icon = $this->config->counter_4_icon;} else {$this->content->title = '';}
        // if ($this->config->style == 1) {
        //   $this->content->style = 'divider_home2';
        // } else {
        //   $this->content->style = 'divider_home1';
        // }


        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 3;
        } else {
            $data = new stdClass();
            $data->slidesnumber = '3';
        }

        // $fs = get_file_storage();
        // $files = $fs->get_area_files($this->context->id, 'block_cocoon_steps', 'items');
        // $this->content->image = '';
        // foreach ($files as $file) {
        //     $filename = $file->get_filename();
        //     if ($filename <> '.') {
        //         $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
        //         $this->content->image .=  $url;
        //     }
        // }



        $this->content->text = '
        <section class="how-it-works">
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
                  // $mainfile = null;
                  $title = 'title' . $i;
                  $link = 'link' . $i;
                  $body = 'body' . $i;
                  $icon = 'icon' . $i;
                  $image = 'image' . $i;

                  $fs = get_file_storage();
                  $files = $fs->get_area_files($this->context->id, 'block_cocoon_steps', 'items', $i, 'sortorder DESC, id ASC', false, 0, 0, 1);
                  if (!empty($data->$image) && count($files) >= 1) {
                    $mainfile = reset($files);
                    $mainfile = $mainfile->get_filename();
                    $data->$image = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php","/{$this->context->id}/block_cocoon_steps/items/" . $i . '/' . $mainfile);
                  } else {
                    $data->$image = $CFG->wwwroot . '/theme/edumy/images/process/1.png';
                  }

$this->content->text .= '

<div class="work-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">';
                      $this->content->text .='<figure class="icon-box"><img data-ccn="image'.$i.'" data-ccn-img="src" src="'.$data->$image.'" alt=""></figure>';
                      $this->content->text .='
                        <h4><a data-ccn="title'.$i.'" href="'.$data->$link.'">'.format_text($data->$title, FORMAT_HTML, array('filter' => true)).'</a></h4>
                        <div class="text" data-ccn="body'.$i.'">'.format_text($data->$body, FORMAT_HTML, array('filter' => true)).'</div>
                    </div>
                </div>';

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

     /**
      * Serialize and store config data
      */
     function instance_config_save($data, $nolongerused = false) {
         global $CFG;

         $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                     'subdirs'       => 0,
                                     'maxfiles'      => 1,
                                     'accepted_types' => array('.jpg', '.png', '.gif'));

         for($i = 1; $i <= $data->slidesnumber; $i++) {
             $field = 'image' . $i;
             if (!isset($data->$field)) {
                 continue;
             }

             file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_steps', 'items', $i, $filemanageroptions);
         }

         parent::instance_config_save($data, $nolongerused);
     }

     /**
      * When a block instance is deleted.
      */
     function instance_delete() {
         global $DB;
         $fs = get_file_storage();
         $fs->delete_area_files($this->context->id, 'block_cocoon_steps');
         return true;
     }

     /**
      * Copy any block-specific data when copying to a new block instance.
      * @param int $fromid the id number of the block instance to copy from
      * @return boolean
      */
     public function instance_copy($fromid) {
         global $CFG;

         $fromcontext = context_block::instance($fromid);
         $fs = get_file_storage();

         if (!empty($this->config) && is_object($this->config)) {
             $data = $this->config;
             $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 0;
         } else {
             $data = new stdClass();
             $data->slidesnumber = 0;
         }

         $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                     'subdirs'       => 0,
                                     'maxfiles'      => 1,
                                     'accepted_types' => array('.jpg', '.png', '.gif'));

         for($i = 1; $i <= $data->slidesnumber; $i++) {
             $field = 'image' . $i;
             if (!isset($data->$field)) {
                 continue;
             }

             // This extra check if file area is empty adds one query if it is not empty but saves several if it is.
             if (!$fs->is_area_empty($fromcontext->id, 'block_cocoon_steps', 'items', $i, false)) {
                 $draftitemid = 0;
                 file_prepare_draft_area($draftitemid, $fromcontext->id, 'block_cocoon_steps', 'items', $i, $filemanageroptions);
                 file_save_draft_area_files($draftitemid, $this->context->id, 'block_cocoon_steps', 'items', $i, $filemanageroptions);
             }
         }

         return true;
     }

     /**
      * The block should only be dockable when the title of the block is not empty
      * and when parent allows docking.
      *
      * @return bool
      */
     public function instance_can_be_docked() {
         return (!empty($this->config->title) && parent::instance_can_be_docked());
     }


}
