<?php

class block_cocoon_features_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;
      $ccnFontList = include($CFG->dirroot . '/theme/edumy/ccn/font_handler/ccn_font_select.php');

      if (!empty($this->block->config) && is_object($this->block->config)) {
        $data = $this->block->config;
      } else {
        $data = new stdClass();
        $data->items = 4;
      }

      // Section header title according to language file.
      $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

      // Title
      $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
      $mform->setDefault('config_title', 'Dove Kindergarten');
      $mform->setType('config_title', PARAM_RAW);

      // Subtitle
      $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
      $mform->setDefault('config_subtitle', 'Cum doctus civibus efficiantur in imperdiet deterruisset.');
      $mform->setType('config_subtitle', PARAM_RAW);

      $options = array(
          0 => 'Align left',
          1 => 'Align center',
      );
      $select = $mform->addElement('select', 'config_style', get_string('config_style', 'theme_edumy'), $options, array('class'=>'ccnCommLcRef_change'));
      $select->setSelected('0');

      $itemsRange = array(
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
      );

      $itemsMax = 12;

      $mform->addElement('select', 'config_items', get_string('config_items', 'theme_edumy'), $itemsRange, array('class'=>'ccnCommLcRef_change'));
      $mform->setDefault('config_items', 4);

      for($i = 1; $i <= $itemsMax; $i++) {
        $mform->addElement('header', 'config_ccn_item' . $i , get_string('config_item', 'theme_edumy') . $i);

        $mform->addElement('text', 'config_title' . $i, get_string('config_title', 'theme_edumy', $i));
        $mform->setDefault('config_title' .$i , 'Dove Kindergarten');
        $mform->setType('config_title' . $i, PARAM_TEXT);

        $select = $mform->addElement('select', 'config_icon' .$i, get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-student');
      }

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

      $mform->addElement('text', 'config_color_item_title', get_string('config_color_item_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
      $mform->setDefault('config_color_item_title', '#0a0a0a');
      $mform->setType('config_color_item_title', PARAM_TEXT);

      $mform->addElement('text', 'config_color_item_icon', get_string('config_color_icon', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
      $mform->setDefault('config_color_item_icon', '#192675');
      $mform->setType('config_color_item_icon', PARAM_TEXT);

      $mform->addElement('text', 'config_color_item_icon_hover', get_string('config_color_icon', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
      $mform->setDefault('config_color_item_icon_hover', '#ff1053');
      $mform->setType('config_color_item_icon_hover', PARAM_TEXT);

      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }
}
