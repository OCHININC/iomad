<?php

require_once($CFG->dirroot.'/theme/edumy/ccn/course_handler/ccn_course_handler.php');

class block_cocoon_course_categories_edit_form extends block_edit_form {
  protected function specific_definition($mform) {
    global $CFG;

    if (!empty($this->block->config) && is_object($this->block->config)) {
      $data = $this->block->config;
    } else {
      $data = new stdClass();
      $data->items = 8;
    }

    $ccnCourseHandler = new ccnCourseHandler();
    $ccnCourseCategories = $ccnCourseHandler->ccnListCategories();

    // Section header title according to language file.
    $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

    // Title
    $mform->addElement('text', 'config_title', get_string('config_title', 'block_cocoon_course_categories'));
    $mform->setDefault('config_title', 'Via School Categories Courses');
    $mform->setType('config_title', PARAM_RAW);

    // Subtitle
    $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'block_cocoon_course_categories'));
    $mform->setDefault('config_subtitle', 'Cum doctus civibus efficiantur in imperdiet deterruisset.');
    $mform->setType('config_subtitle', PARAM_RAW);

    // Button Text
    $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edumy'));
    $mform->setDefault('config_button_text', 'View All Courses');
    $mform->setType('config_button_text', PARAM_RAW);

    $options = array(
        '0' => 'Category description',
        '1' => 'Category course count',
        '2' => 'None',
    );
    $select = $mform->addElement('select', 'config_body', get_string('config_body', 'theme_edumy'), $options);
    $select->setSelected('0');

    $options = array(
        'multiple' => true,
        'noselectionstring' => get_string('select_from_dropdown_multiple', 'theme_edumy'),
    );
    $mform->addElement('autocomplete', 'config_categories' . $i, get_string('categories'), $ccnCourseCategories, $options);


    // Style
    $radioarray=array();
    $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Hide arrow', 0, $attributes);
    $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Show arrow', 1, $attributes);
    $mform->addGroup($radioarray, 'config_style', 'Arrow', array(' '), false);

    $mform->addElement('header', 'config_ccn_colors', get_string('block_styles', 'theme_edumy'));

    $mform->addElement('text', 'config_color_bg', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
    $mform->setDefault('config_color_bg', 'rgb(255,255,255)');
    $mform->setType('config_color_bg', PARAM_TEXT);

    $mform->addElement('text', 'config_color_title', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
    $mform->setDefault('config_color_title', '#0a0a0a');
    $mform->setType('config_color_title', PARAM_TEXT);

    $mform->addElement('text', 'config_color_subtitle', get_string('config_color_subtitle', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
    $mform->setDefault('config_color_subtitle', '#6f7074');
    $mform->setType('config_color_subtitle', PARAM_TEXT);

    $mform->addElement('text', 'config_color_overlay', get_string('config_color_overlay', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
    $mform->setDefault('config_color_overlay', 'rgba(10,10,10,.5)');
    $mform->setType('config_color_overlay', PARAM_TEXT);

    $mform->addElement('text', 'config_color_hover', get_string('config_color_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
    $mform->setDefault('config_color_hover', '#2441e7');
    $mform->setType('config_color_hover', PARAM_TEXT);

    $mform->addElement('text', 'config_color_btn', get_string('config_color_btn', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
    $mform->setDefault('config_color_btn', '#2441e7');
    $mform->setType('config_color_btn', PARAM_TEXT);

    $mform->addElement('text', 'config_button_bdrrd', get_string('config_button', 'theme_edumy') . get_string('border_radius', 'theme_edumy') , array('class'=>'ccn_range_class'));
    $mform->setDefault('config_button_bdrrd', '50');
    $mform->setType('config_button_bdrrd', PARAM_TEXT);


    include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

  }
}
