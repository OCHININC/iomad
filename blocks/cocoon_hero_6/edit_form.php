<?php

class block_cocoon_hero_6_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Learn From Anywhere');
        $mform->setType('config_title', PARAM_RAW);

        // Subtitle
        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_subtitle', 'Technology is bringing a massive wave of evolution on learning things on different ways.');
        $mform->setType('config_subtitle', PARAM_RAW);

        // Button Text
        $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edumy'));
        $mform->setDefault('config_button_text', 'Get Started');
        $mform->setType('config_button_text', PARAM_RAW);

        // Button Link
        $mform->addElement('text', 'config_button_link', get_string('config_button_link', 'theme_edumy'));
        $mform->setDefault('config_button_link', '#');
        $mform->setType('config_button_link', PARAM_RAW);

        // Button Text
        $mform->addElement('text', 'config_button_text_2', get_string('config_button_text', 'theme_edumy') . ' 2');
        $mform->setDefault('config_button_text_2', 'View Courses');
        $mform->setType('config_button_text_2', PARAM_RAW);

        // Button Link
        $mform->addElement('text', 'config_button_link_2', get_string('config_button_link', 'theme_edumy') . ' 2');
        $mform->setDefault('config_button_link_2', '#');
        $mform->setType('config_button_link_2', PARAM_RAW);

        for($i = 1; $i <= 2; $i++) {
          if($i == 1) {
            $title = "Background image";
          } elseif($i == 2){
            $title = "Parallax image";
          }
            $mform->addElement('header', 'config_header' . $i , $title);

            $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                        'subdirs'       => 0,
                                        'maxfiles'      => 1,
                                        'accepted_types' => array('.jpg', '.png', '.gif'));

            $f = $mform->addElement('filemanager', 'config_image' . $i, get_string('config_image', 'theme_edumy', $i), null, $filemanageroptions);
        }

        $mform->addElement('header', 'config_ccn_colors', get_string('block_styles', 'theme_edumy'));

        $mform->addElement('text', 'config_color_title', get_string('config_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title', '#221538');
        $mform->setType('config_color_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_subtitle', get_string('config_subtitle', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_subtitle', '#6f7074');
        $mform->setType('config_color_subtitle', PARAM_TEXT);

        $mform->addElement('text', 'config_color_btn_1', get_string('config_button', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_btn_1', '#ff1053');
        $mform->setType('config_color_btn_1', PARAM_TEXT);

        $mform->addElement('text', 'config_color_btn_1_hover', get_string('config_button', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_btn_1_hover', '#ff1053');
        $mform->setType('config_color_btn_1_hover', PARAM_TEXT);

        $mform->addElement('text', 'config_color_btn_2', get_string('config_button', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_btn_2', '#051925');
        $mform->setType('config_color_btn_2', PARAM_TEXT);

        $mform->addElement('text', 'config_color_btn_2_hover', get_string('config_button', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_btn_2_hover', '#051925');
        $mform->setType('config_color_btn_2_hover', PARAM_TEXT);

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }

    function set_data($defaults) {

      if (!empty($this->block->config) && is_object($this->block->config)) {

          for($i = 1; $i <= 2; $i++) {
              $field = 'image' . $i;
              $config_field = 'config_image' . $i;
              $draftitemid = file_get_submitted_draft_itemid($config_field);
              file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_hero_6', 'images', $i, array('subdirs'=>false));
              $defaults->$config_field['itemid'] = $draftitemid;
              $this->block->config->$field = $draftitemid;
          }
      }

      parent::set_data($defaults);

      // if (!empty($this->block->config) && is_object($this->block->config)) {
      //     $text = $this->block->config->bio;
      //     $draftid_editor = file_get_submitted_draft_itemid('config_bio');
      //     if (empty($text)) {
      //         $currenttext = '';
      //     } else {
      //         $currenttext = $text;
      //     }
      //     $defaults->config_bio['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_contact_form', 'content', 0, array('subdirs'=>true), $currenttext);
      //     $defaults->config_bio['itemid'] = $draftid_editor;
      //     $defaults->config_bio['format'] = $this->block->config->format;
      // } else {
      //     $text = '';
      // }

    }
}
