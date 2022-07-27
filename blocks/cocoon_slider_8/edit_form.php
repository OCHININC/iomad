<?php

class block_cocoon_slider_8_edit_form extends block_edit_form {
  protected function specific_definition($mform) {
    global $CFG;
    $ccnFontList = include($CFG->dirroot . '/theme/edumy/ccn/font_handler/ccn_font_select.php');

    if (!empty($this->block->config) && is_object($this->block->config)) {
      $data = $this->block->config;
    } else {
      $data = new stdClass();
      $data->slidesnumber = 4;
    }

    // Fields for editing HTML block title and contents.
    $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

    $slidesrange = array(
      1 => '1',
      2 => '2',
      3 => '3',
      4 => '4',
    );

    $slidesmax = 4;

    $mform->addElement('select', 'config_slidesnumber', get_string('config_items', 'theme_edumy'), $slidesrange);
    $mform->setDefault('config_slidesnumber', 4);

    for($i = 1; $i <= $slidesmax; $i++) {
      $mform->addElement('header', 'config_ccn_item' . $i , 'Slide ' . $i);

      $mform->addElement('text', 'config_title_' . $i, get_string('config_title', 'theme_edumy', $i));
      $mform->setDefault('config_title_' .$i , 'Learn Remotely From ');
      $mform->setType('config_title_' . $i, PARAM_TEXT);

      $mform->addElement('text', 'config_title_2_' . $i, get_string('config_title_2', 'theme_edumy', $i));
      $mform->setDefault('config_title_2_' .$i , 'Anywhere');
      $mform->setType('config_title_2_' . $i, PARAM_TEXT);

      $mform->addElement('text', 'config_subtitle_' . $i, get_string('config_subtitle', 'theme_edumy', $i));
      $mform->setDefault('config_subtitle_' .$i , 'Reach out to the most competent & passionate mentors');
      $mform->setType('config_subtitle_' . $i, PARAM_TEXT);

      $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                  'subdirs'       => 0,
                                  'maxfiles'      => 1,
                                  'accepted_types' => array('.jpg', '.png', '.gif'));

      $f = $mform->addElement('filemanager', 'config_image_' . $i, get_string('config_image', 'theme_edumy', $i), null, $filemanageroptions);

      $mform->addElement('text', 'config_button_text_' . $i, get_string('config_button_text', 'theme_edumy', $i));
      $mform->setDefault('config_button_text_' .$i , 'Learn more');
      $mform->setType('config_button_text_' . $i, PARAM_TEXT);

      $mform->addElement('text', 'config_button_link_' . $i, get_string('config_button_link', 'theme_edumy', $i));
      $mform->setDefault('config_button_link_' .$i , '#');
      $mform->setType('config_button_link_' . $i, PARAM_TEXT);
    }

    // Feature 1
    $mform->addElement('header', 'config_feature_1', get_string('config_feature_1', 'theme_edumy'));

    $mform->addElement('text', 'config_feature_1_title', get_string('config_title', 'theme_edumy'));
    $mform->setDefault('config_feature_1_title', 'Create Account');
    $mform->setType('config_feature_1_title', PARAM_TEXT);

    $mform->addElement('text', 'config_feature_1_subtitle', get_string('config_subtitle', 'theme_edumy'));
    $mform->setDefault('config_feature_1_subtitle', 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.');
    $mform->setType('config_feature_1_subtitle', PARAM_TEXT);

    $select = $mform->addElement('select', 'config_feature_1_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
    $select->setSelected('flaticon-pencil');

    // Feature 2
    $mform->addElement('header', 'config_feature_2', get_string('config_feature_2', 'theme_edumy'));

    $mform->addElement('text', 'config_feature_2_title', get_string('config_title', 'theme_edumy'));
    $mform->setDefault('config_feature_2_title', 'Create Online Course');
    $mform->setType('config_feature_2_title', PARAM_TEXT);

    $mform->addElement('text', 'config_feature_2_subtitle', get_string('config_subtitle', 'theme_edumy'));
    $mform->setDefault('config_feature_2_subtitle', 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.');
    $mform->setType('config_feature_2_subtitle', PARAM_TEXT);

    $select = $mform->addElement('select', 'config_feature_2_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
    $select->setSelected('flaticon-student-1');

    // Feature 3
    $mform->addElement('header', 'config_feature_3', get_string('config_feature_3', 'theme_edumy'));

    $mform->addElement('text', 'config_feature_3_title', get_string('config_title', 'theme_edumy'));
    $mform->setDefault('config_feature_3_title', 'Interact With Students');
    $mform->setType('config_feature_3_title', PARAM_TEXT);

    $mform->addElement('text', 'config_feature_3_subtitle', get_string('config_subtitle', 'theme_edumy'));
    $mform->setDefault('config_feature_3_subtitle', 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.');
    $mform->setType('config_feature_3_subtitle', PARAM_TEXT);

    $select = $mform->addElement('select', 'config_feature_3_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
    $select->setSelected('flaticon-photo-camera');

    // Feature 4
    $mform->addElement('header', 'config_feature_4', get_string('config_feature_4', 'theme_edumy'));

    $mform->addElement('text', 'config_feature_4_title', get_string('config_title', 'theme_edumy'));
    $mform->setDefault('config_feature_4_title', 'Achieve Your Goals');
    $mform->setType('config_feature_4_title', PARAM_TEXT);

    $mform->addElement('text', 'config_feature_4_subtitle', get_string('config_subtitle', 'theme_edumy'));
    $mform->setDefault('config_feature_4_subtitle', 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.');
    $mform->setType('config_feature_4_subtitle', PARAM_TEXT);

    $select = $mform->addElement('select', 'config_feature_4_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
    $select->setSelected('flaticon-medal');



    include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit/edit_ccn_carousel.php');
    include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

  }

  function set_data($defaults) {
    if (!empty($this->block->config) && is_object($this->block->config)) {
      for($i = 1; $i <= $this->block->config->slidesnumber; $i++) {
        $field = 'image_' . $i;
        $conffield = 'config_image_' . $i;
        $draftitemid = file_get_submitted_draft_itemid($conffield);
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_slider_8', 'slides', $i, array('subdirs'=>false));
        $defaults->$conffield['itemid'] = $draftitemid;
        $this->block->config->$field = $draftitemid;
      }
    }

    parent::set_data($defaults);
  }
}
