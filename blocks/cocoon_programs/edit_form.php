<?php

class block_cocoon_programs_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG;

        if (!empty($this->block->config) && is_object($this->block->config)) {
            $data = $this->block->config;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 0;
        }


        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Smarty Programs');
        $mform->setType('config_title', PARAM_RAW);

        // Subtitle
        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_subtitle', 'Cum doctus civibus efficiantur in imperdiet deterruisset.');
        $mform->setType('config_subtitle', PARAM_RAW);

        // Image
        $mform->addElement('filemanager', 'config_image', get_string('config_image', 'theme_edumy'), null,
                array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 1,
                'accepted_types' => array('.png', '.jpg', '.gif') ));

        $slidesrange = range(0, 4);
        $mform->addElement('select', 'config_slidesnumber', get_string('config_items', 'theme_edumy'), $slidesrange);
        $mform->setDefault('config_slidesnumber', $data->slidesnumber);

        for($i = 1; $i <= $data->slidesnumber; $i++) {
            $mform->addElement('header', 'config_header' . $i , 'Program ' . $i);

            $mform->addElement('text', 'config_slide_title' . $i, get_string('config_title', 'theme_edumy', $i));
            $mform->setDefault('config_slide_title' .$i , 'Toddler (1,5 – 2 years)');
            $mform->setType('config_slide_title' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_slide_subtitle' . $i, get_string('config_subtitle', 'theme_edumy', $i));
            $mform->setDefault('config_slide_subtitle' .$i , 'By creating a safe, consistent and welcoming environment, we help');
            $mform->setType('config_slide_subtitle' . $i, PARAM_TEXT);

            $radioarray=array();
            $radioarray[] = $mform->createElement('radio', 'config_style' . $i, '', 'Red', 'box1', $attributes);
            $radioarray[] = $mform->createElement('radio', 'config_style' . $i, '', 'Green', 'box2', $attributes);
            $radioarray[] = $mform->createElement('radio', 'config_style' . $i, '', 'Blue', 'box3', $attributes);
            $radioarray[] = $mform->createElement('radio', 'config_style' . $i, '', 'Turquoise', 'box4', $attributes);
            $mform->addGroup($radioarray, 'config_style' . $i, 'Style', array(' '), false);


            $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                        'subdirs'       => 0,
                                        'maxfiles'      => 1,
                                        'accepted_types' => array('.jpg', '.png', '.gif'));

            $f = $mform->addElement('filemanager', 'config_file_slide' . $i, get_string('config_image', 'theme_edumy', $i), null, $filemanageroptions);
        }

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');
    }

    function set_data($defaults) {

      // Begin CCN Image Processing
      if (empty($entry->id)) {
          $entry = new stdClass;
          $entry->id = null;
      }
      $draftitemid = file_get_submitted_draft_itemid('config_image');
      file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_programs', 'slides', 0,
          array('subdirs' => true));
      $entry->attachments = $draftitemid;
      parent::set_data($defaults);
      if ($data = parent::get_data()) {
          file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_programs', 'slides', 0,
              array('subdirs' => true));
      }
      // END CCN Image Processing


        if (!empty($this->block->config) && is_object($this->block->config)) {

            for($i = 1; $i <= $this->block->config->slidesnumber; $i++) {
                $field = 'file_slide' . $i;
                $conffield = 'config_file_slide' . $i;
                $draftitemid = file_get_submitted_draft_itemid($conffield);
                file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_programs', 'slides', $i, array('subdirs'=>false));
                $defaults->$conffield['itemid'] = $draftitemid;
                $this->block->config->$field = $draftitemid;
            }
        }

        parent::set_data($defaults);
    }
}
