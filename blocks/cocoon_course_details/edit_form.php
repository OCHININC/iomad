<?php

class block_cocoon_course_details_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;
      $ccnFontList = include($CFG->dirroot . '/theme/edumy/ccn/font_handler/ccn_font_select.php');

      if (!empty($this->block->config) && is_object($this->block->config)) {
          $data = $this->block->config;
      } else {
          $data = new stdClass();
          $data->items = 0;
      }

      // Section header title according to language file.
      $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

      $itemsrange = range(0, 12);
      $mform->addElement('select', 'config_items', get_string('config_items', 'block_cocoon_course_details'), $itemsrange);
      $mform->setDefault('config_items', $data->items);

        for($i = 1; $i <= $data->items; $i++) {

          $mform->addElement('header', 'config_header' . $i , 'Item ' . $i);

          $mform->addElement('text', 'config_item_title' . $i, get_string('config_item_title', 'block_cocoon_course_details', $i));
          $mform->setDefault('config_item_title' .$i , '11 hours on-demand video');
          $mform->setType('config_item_title' . $i, PARAM_TEXT);

          // $mform->addElement('text', 'config_item_icon' . $i, get_string('config_item_icon', 'block_cocoon_course_details', $i));
          // $mform->setDefault('config_item_icon' .$i , 'flaticon-play-button-1');
          // $mform->setType('config_item_icon' . $i, PARAM_TEXT);

          $select = $mform->addElement('select', 'config_item_icon' . $i, get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
          $select->setSelected('flaticon-account');

       }

     include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');
    }
}
