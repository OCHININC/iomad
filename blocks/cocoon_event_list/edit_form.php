<?php

class block_cocoon_event_list_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;
      $ccnFontList = include($CFG->dirroot . '/theme/edumy/ccn/font_handler/ccn_font_select.php');

      require_once($CFG->dirroot . '/theme/edumy/ccn/event_handler/ccn_event_handler.php');
      include_once($CFG->dirroot . '/course/lib.php');
      require_once($CFG->dirroot. '/course/renderer.php');

      $ccnEventHandler = new ccnEventHandler();
      $ccnEventList = $ccnEventHandler->ccnEventList();




      // print_object($ccnEventList);


      // $topcategory = core_course_category::top();
      // $topcategorykids = $topcategory->get_children();
      $searchareas = \core_search\manager::get_search_areas_list(true);
      $areanames = array();
      foreach ($ccnEventList as $k => $ccnEvent) {
          $areanames[$k] = $ccnEvent->name;
          // print_object($areaid->get_formatted_name());
          // print_object($areaid);

      }


      if (!empty($this->block->config) && is_object($this->block->config)) {
          $data = $this->block->config;
      } else {
          $data = new stdClass();
          $data->items = 6;
      }

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Upcoming Events');
        $mform->setType('config_title', PARAM_RAW);

        // Subtitle
        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_subtitle', 'Cum doctus civibus efficiantur in imperdiet deterruisset.');
        $mform->setType('config_subtitle', PARAM_RAW);

        // Button Text
        $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edumy'));
        $mform->setDefault('config_button_text', 'See All Events');
        $mform->setType('config_button_text', PARAM_RAW);

        $items_range = array(
          1 => '1',
          2 => '2',
          3 => '3',
          4 => '4',
          5 => '5',
          6 => '6',
        );

        $items_max = 6;

        $mform->addElement('select', 'config_items', get_string('config_items', 'theme_edumy'), $items_range);
        $mform->setDefault('config_items', 6);
        $mform->addRule('config_items', get_string('required'), 'required', null, 'client', false, false);

        for($i = 1; $i <= $items_max; $i++) {
            $mform->addElement('header', 'config_ccn_item' . $i ,  get_string('config_item', 'theme_edumy') . ' ' . $i);

            $mform->addElement('text', 'config_color' . $i, get_string('config_color', 'theme_edumy', $i), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color' .$i , '#23ad96');
            $mform->setType('config_color' . $i, PARAM_TEXT);
            $mform->addRule('config_color' . $i, get_string('required'), 'required', null, 'client', false, false);

            $mform->addElement('text', 'config_color_hover' . $i, get_string('config_color', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_hover' .$i , '#3f3b64');
            $mform->setType('config_color_hover' . $i, PARAM_TEXT);
            $mform->addRule('config_color_hover' . $i, get_string('required'), 'required', null, 'client', false, false);

            $options = array(
                'multiple' => false,
                'noselectionstring' => get_string('select_from_dropdown', 'theme_edumy'),
            );
            $mform->addElement('autocomplete', 'config_event' . $i, get_string('event', 'theme_edumy'), $areanames, $options);
            $mform->addRule('config_event' . $i, get_string('required'), 'required', null, 'client', false, false);

        }

        $mform->addElement('header', 'config_ccn_colors', get_string('block_styles', 'theme_edumy'));

        $mform->addElement('text', 'config_color_bg', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_bg', '#f8f8f8');
        $mform->setType('config_color_bg', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title', '#0a0a0a');
        $mform->setType('config_color_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_subtitle', get_string('config_color_subtitle', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_subtitle', 'rgb(111, 112, 116)');
        $mform->setType('config_color_subtitle', PARAM_TEXT);

        $mform->addElement('text', 'config_color_btn', get_string('config_color_btn', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_btn', '#555555');
        $mform->setType('config_color_btn', PARAM_TEXT);



        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }

    // function set_data($defaults)
    // {

        // Begin CCN Image Processing
        // if (empty($entry->id)) {
        //     $entry = new stdClass;
        //     $entry->id = null;
        // }
        // $draftitemid = file_get_submitted_draft_itemid('config_image');
        // file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_event_list', 'content', 0,
        //     array('subdirs' => true));
        // $entry->attachments = $draftitemid;
        // parent::set_data($defaults);
        // if ($data = parent::get_data()) {
        //     file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_event_list', 'content', 0,
        //         array('subdirs' => true));
        // }
        // END CCN Image Processing



        // if (!empty($this->block->config) && is_object($this->block->config)) {
        //     $text = $this->block->config->bio;
        //     $draftid_editor = file_get_submitted_draft_itemid('config_bio');
        //     if (empty($text)) {
        //         $currenttext = '';
        //     } else {
        //         $currenttext = $text;
        //     }
        //     $defaults->config_bio['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_event_list', 'content', 0, array('subdirs'=>true), $currenttext);
        //     $defaults->config_bio['itemid'] = $draftid_editor;
        //     $defaults->config_bio['format'] = $this->block->config->format;
        // } else {
        //     $text = '';
        // }


    // }
}
