<?php
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_parallax_apps extends block_base {

    /**
     * Start block instance.
     */
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_parallax_apps');
    }

    /**
     * The block is usable in all pages
     */
     function applicable_formats() {
         $ccnBlockHandler = new ccnBlockHandler();
         return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
     }


    /**
     * Customize the block title dynamically.
     */
    function specialization() {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->title = 'Download & Enjoy';
          $this->config->subtitle = 'Access your courses anywhere, anytime & prepare with practice tests.';
          $this->config->app_store_btn_title = 'App Store';
          $this->config->app_store_btn_subtitle = 'Available on the';
          $this->config->app_store_btn_link = '#';
          $this->config->play_store_btn_title = 'Google Play';
          $this->config->play_store_btn_subtitle = 'Get it on';
          $this->config->play_store_btn_link = '#';

        }
    }

    /**
     * The block can be used repeatedly in a page.
     */
    function instance_allow_multiple() {
        return true;
    }

    /**
     * Build the block content.
     */
    function get_content() {
        global $CFG, $PAGE;

        require_once($CFG->libdir . '/filelib.php');


        if ($this->content !== NULL) {
            return $this->content;
        }

        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
        }
        (!empty($data->app_store_btn_target)) ? $ccnAppStoreBtnTarget = $data->app_store_btn_target : $ccnAppStoreBtnTarget = '';
        (!empty($data->play_store_btn_target)) ? $ccnPlayStoreBtnTarget = $data->play_store_btn_target : $ccnPlayStoreBtnTarget = '';
        // No. of images
        $fs = get_file_storage();
        for ($i = 1; $i <= 2; $i++) {
                $image = 'image' . $i;
                $files = $fs->get_area_files($this->context->id, 'block_cocoon_parallax_apps', 'images', $i, 'sortorder DESC, id ASC', false, 0, 0, 1);
                if (count($files) >= 1) {
                    $mainfile = reset($files);
                    $mainfile = $mainfile->get_filename();
                } else {
                    continue;
                }
                $img_item[] = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/{$this->context->id}/block_cocoon_parallax_apps/images/" . $i . '/' . $mainfile);

        }
            $text = '			<section class="home1-divider2 parallax"  data-ccn="image1" data-ccn-img="bg-img-url" data-stellar-background-ratio="0.3" style="background-image:url('.$img_item[0].');">
		<div class="container">
			<div class="row">
				<div class="col-md-7 col-lg-7">
					<div class="app_grid">
						<h1 data-ccn="title" class="mt0">'.format_text($data->title, FORMAT_HTML, array('filter' => true)).'</h1>
						<p data-ccn="subtitle">'.format_text($data->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
						<a data-ccn="app_store_btn_link" class="ccn-app-grid-btn" target="'.$ccnAppStoreBtnTarget.'" href="'.format_text($data->app_store_btn_link, FORMAT_HTML, array('filter' => true)).'"><button class="apple_btn btn-transparent">
							<span class="icon">
								<span class="flaticon-apple"></span>
							</span>
							<span data-ccn="app_store_btn_title" class="title">'.format_text($data->app_store_btn_title, FORMAT_HTML, array('filter' => true)).'</span>
							<span data-ccn="app_store_btn_subtitle" class="subtitle">'.format_text($data->app_store_btn_subtitle, FORMAT_HTML, array('filter' => true)).'</span>
						</button>
            </a>
            <a class="ccn-app-grid-btn" target="'.$ccnPlayStoreBtnTarget.'" href="'.format_text($data->play_store_btn_link, FORMAT_HTML, array('filter' => true)).'">
						<button class="play_store_btn btn-transparent">
							<span class="icon">
								<span class="flaticon-google-play"></span>
							</span>
							<span data-ccn="play_store_btn_title" class="title">'.format_text($data->play_store_btn_title, FORMAT_HTML, array('filter' => true)).'</span>
							<span data-ccn="play_store_btn_subtitle" class="subtitle">'.format_text($data->play_store_btn_subtitle, FORMAT_HTML, array('filter' => true)).'</span>
						</button>
            </a>
					</div>
				</div>
				<div class="col-md-5 col-lg-5">
					<div class="phone_img">
						<img  data-ccn="image2" data-ccn-img="src" class="img-fluid" src="'.$img_item[1].'" alt="">
					</div>
				</div>
			</div>
		</div>
	</section>';


        $this->content = new stdClass;
        $this->content->footer = '';
        $this->content->text = $text;

        return $this->content;

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

        for($i = 1; $i <= 2; $i++) {
            $field = 'image' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_parallax_apps', 'images', $i, $filemanageroptions);
        }

        parent::instance_config_save($data, $nolongerused);
    }

    /**
     * When a block instance is deleted.
     */
    function instance_delete() {
        global $DB;
        $fs = get_file_storage();
        $fs->delete_area_files($this->context->id, 'block_cocoon_parallax_apps');
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
            $data->ccn_img_count = is_numeric($data->ccn_img_count) ? (int)$data->ccn_img_count : 0;
        } else {
            $data = new stdClass();
            $data->ccn_img_count = 0;
        }

        $ccn_img_count = 2;

        $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                    'subdirs'       => 0,
                                    'maxfiles'      => 1,
                                    'accepted_types' => array('.jpg', '.png', '.gif'));

        for($i = 1; $i <= $ccn_img_count; $i++) {
            $field = 'image' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            // This extra check if file area is empty adds one query if it is not empty but saves several if it is.
            if (!$fs->is_area_empty($fromcontext->id, 'block_cocoon_parallax_apps', 'images', $i, false)) {
                $draftitemid = 0;
                file_prepare_draft_area($draftitemid, $fromcontext->id, 'block_cocoon_parallax_apps', 'images', $i, $filemanageroptions);
                file_save_draft_area_files($draftitemid, $this->context->id, 'block_cocoon_parallax_apps', 'images', $i, $filemanageroptions);
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

    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }

}
