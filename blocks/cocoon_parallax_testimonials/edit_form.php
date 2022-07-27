<?php

class block_cocoon_parallax_testimonials_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG;

        if (!empty($this->block->config) && is_object($this->block->config)) {
            $data = $this->block->config;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 5;
        }


        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Testimonials');
        $mform->setType('config_title', PARAM_RAW);

        // Subtitle
        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_subtitle', 'Cum doctus civibus efficiantur in imperdiet deterruisset.');
        $mform->setType('config_subtitle', PARAM_RAW);

        // Image
        $mform->addElement('filemanager', 'config_image', get_string('config_image', 'theme_edumy'), null,
                array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 1,
                'accepted_types' => array('.png', '.jpg', '.gif') ));

        $slidesrange = array(
          1 => '1',
          2 => '2',
          3 => '3',
          4 => '4',
          5 => '5',
          6 => '6',
          7 => '7',
          8 => '8',
          9 => '9',
          10 => '10',
          11 => '11',
          12 => '12',
          13 => '13',
          14 => '14',
          15 => '15',
          16 => '16',
          17 => '17',
          18 => '18',
          19 => '19',
          20 => '20',
          21 => '21',
          22 => '22',
          23 => '23',
          24 => '24',
          25 => '25',
          26 => '26',
          27 => '27',
          28 => '28',
          29 => '29',
          30 => '30',
          31 => '31',
          32 => '32',
          33 => '33',
          34 => '34',
          35 => '35',
          36 => '36',
          37 => '37',
          38 => '38',
          39 => '39',
          40 => '40',
          41 => '41',
          42 => '42',
          43 => '43',
          44 => '44',
          45 => '45',
          46 => '46',
          47 => '47',
          48 => '48',
          49 => '49',
          50 => '50',
        );

        $slidesmax = 50;

        $mform->addElement('select', 'config_slidesnumber', get_string('config_items', 'theme_edumy'), $slidesrange);
        $mform->setDefault('config_slidesnumber', 5);

        for($i = 1; $i <= $slidesmax; $i++) {
            $mform->addElement('header', 'config_ccn_item' . $i , get_string('config_item', 'theme_edumy') . $i);

            $mform->addElement('text', 'config_slide_title' . $i, get_string('config_title', 'theme_edumy', $i));
            $mform->setDefault('config_slide_title' .$i , 'Augusta Silva');
            $mform->setType('config_slide_title' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_subtitle' . $i, get_string('config_subtitle', 'theme_edumy', $i));
            $mform->setDefault('config_subtitle' .$i , 'Client');
            $mform->setType('config_subtitle' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_body' . $i, get_string('config_body', 'theme_edumy', $i));
            $mform->setDefault('config_body' .$i , 'Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.');
            $mform->setType('config_body' . $i, PARAM_TEXT);

            // $radioarray=array();
            // $radioarray[] = $mform->createElement('radio', 'config_style' . $i, '', 'Red', 'box1', $attributes);
            // $radioarray[] = $mform->createElement('radio', 'config_style' . $i, '', 'Green', 'box2', $attributes);
            // $radioarray[] = $mform->createElement('radio', 'config_style' . $i, '', 'Blue', 'box3', $attributes);
            // $radioarray[] = $mform->createElement('radio', 'config_style' . $i, '', 'Turquoise', 'box4', $attributes);
            // $mform->addGroup($radioarray, 'config_style' . $i, 'Style', array(' '), false);


            $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                        'subdirs'       => 0,
                                        'maxfiles'      => 1,
                                        'accepted_types' => array('.jpg', '.png', '.gif'));

            $f = $mform->addElement('filemanager', 'config_image' . $i, get_string('config_image', 'theme_edumy', $i), null, $filemanageroptions);
        }

        $mform->addElement('header', 'config_ccn_colors', get_string('block_styles', 'theme_edumy'));

        $mform->addElement('text', 'config_color_bg', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_bg', '#2441e7');
        $mform->setType('config_color_bg', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title', '#ffffff');
        $mform->setType('config_color_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_subtitle', get_string('config_color_subtitle', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_subtitle', '#ffffff');
        $mform->setType('config_color_subtitle', PARAM_TEXT);

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');
    }

    function set_data($defaults) {

      // Begin CCN Image Processing
      if (empty($entry->id)) {
          $entry = new stdClass;
          $entry->id = null;
      }
      $draftitemid = file_get_submitted_draft_itemid('config_image');
      file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_parallax_testimonials', 'slides', 0,
          array('subdirs' => true));
      $entry->attachments = $draftitemid;
      parent::set_data($defaults);
      if ($data = parent::get_data()) {
          file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_parallax_testimonials', 'slides', 0,
              array('subdirs' => true));
      }
      // END CCN Image Processing


        if (!empty($this->block->config) && is_object($this->block->config)) {

            for($i = 1; $i <= $this->block->config->slidesnumber; $i++) {
                $field = 'image' . $i;
                $conffield = 'config_image' . $i;
                $draftitemid = file_get_submitted_draft_itemid($conffield);
                file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_parallax_testimonials', 'slides', $i, array('subdirs'=>false));
                $defaults->$conffield['itemid'] = $draftitemid;
                $this->block->config->$field = $draftitemid;
            }
        }

        parent::set_data($defaults);
    }
}
