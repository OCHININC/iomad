<?php

class block_cocoon_hero_4_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG;
        $ccnFontList = include($CFG->dirroot . '/theme/edumy/ccn/font_handler/ccn_font_select.php');

        if (!empty($this->block->config) && is_object($this->block->config)) {
            $data = $this->block->config;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 3;
        }


        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', 'Learn From');

        $mform->addElement('text', 'config_title_2', get_string('config_title_2', 'theme_edumy'));
        $mform->setType('config_title_2', PARAM_TEXT);
        $mform->setDefault('config_title_2', 'Anywhere');

        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setType('config_subtitle', PARAM_TEXT);
        $mform->setDefault('config_subtitle', 'Technology is bringing a massive wave of evolution on learning things in different ways.');

        // Image
        $mform->addElement('filemanager', 'config_image', get_string('config_image', 'theme_edumy'), null,
                array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 1,
                'accepted_types' => array('.png', '.jpg', '.gif') ));

        $mform->addElement('header', 'config_form', get_string('config_form', 'theme_edumy'));

        $mform->addElement('text', 'config_form_title', get_string('config_title', 'theme_edumy'));
        $mform->setType('config_form_title', PARAM_TEXT);
        $mform->setDefault('config_form_title', 'Get your free personalized course list');

        $mform->addElement('text', 'config_form_text', get_string('config_description', 'theme_edumy'));
        $mform->setType('config_form_text', PARAM_TEXT);
        $mform->setDefault('config_form_text', 'Your data is safe and secure with Edumy. We never share your data.');

        $mform->addElement('text', 'config_form_button_text', get_string('button_text', 'theme_edumy'));
        $mform->setType('config_form_button_text', PARAM_TEXT);
        $mform->setDefault('config_form_button_text', 'Recommend My Courses');

        $select = $mform->addElement('select', 'config_form_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('ccn-flaticon-locked');

        // Feature 1
        $mform->addElement('header', 'config_feature_1', get_string('config_feature_1', 'theme_edumy'));

        $mform->addElement('text', 'config_feature_1_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_feature_1_title', 'Design: Over 800 Courses');
        $mform->setType('config_feature_1_title', PARAM_TEXT);

        $select = $mform->addElement('select', 'config_feature_1_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-pencil');

        // Feature 2
        $mform->addElement('header', 'config_feature_2', get_string('config_feature_2', 'theme_edumy'));

        $mform->addElement('text', 'config_feature_2_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_feature_2_title', 'Business: Over 1,400 Courses');
        $mform->setType('config_feature_2_title', PARAM_TEXT);

        $select = $mform->addElement('select', 'config_feature_2_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-student-1');

        // Feature 3
        $mform->addElement('header', 'config_feature_3', get_string('config_feature_3', 'theme_edumy'));

        $mform->addElement('text', 'config_feature_3_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_feature_3_title', 'Photography: Over 740 Courses');
        $mform->setType('config_feature_3_title', PARAM_TEXT);

        $select = $mform->addElement('select', 'config_feature_3_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-photo-camera');

        // Feature 4
        $mform->addElement('header', 'config_feature_4', get_string('config_feature_4', 'theme_edumy'));

        $mform->addElement('text', 'config_feature_4_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_feature_4_title', 'Marketing: Over 200 Courses');
        $mform->setType('config_feature_4_title', PARAM_TEXT);

        $select = $mform->addElement('select', 'config_feature_4_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-medal');

        $mform->addElement('header', 'config_ccn_colors', get_string('block_styles', 'theme_edumy'));

        $mform->addElement('text', 'config_color_title', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title', '#ffffff');
        $mform->setType('config_color_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title_2', get_string('config_title_2', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title_2', '#ffffff');
        $mform->setType('config_color_title_2', PARAM_TEXT);

        $mform->addElement('text', 'config_color_subtitle', get_string('config_color_subtitle', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_subtitle', '#ffffff');
        $mform->setType('config_color_subtitle', PARAM_TEXT);

        $mform->addElement('text', 'config_color_features', get_string('config_features', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_features', '#ffffff');
        $mform->setType('config_color_features', PARAM_TEXT);

        $mform->addElement('text', 'config_color_form_title', get_string('config_form_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_form_title', '#cdbe9c');
        $mform->setType('config_color_form_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_form_button', get_string('config_button', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_form_button', '#3e4448');
        $mform->setType('config_color_form_button', PARAM_TEXT);




        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }

    function set_data($defaults) {

      // Begin CCN Image Processing
      if (empty($entry->id)) {
          $entry = new stdClass;
          $entry->id = null;
      }
      $draftitemid = file_get_submitted_draft_itemid('config_image');
      file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_hero_4', 'content', 0,
          array('subdirs' => true));
      $entry->attachments = $draftitemid;
      parent::set_data($defaults);
      if ($data = parent::get_data()) {
          file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_hero_4', 'content', 0,
              array('subdirs' => true));
      }
      // END CCN Image Processing

    }
}
