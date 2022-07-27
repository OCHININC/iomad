<?php

class block_cocoon_boxes_edit_form extends block_edit_form
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
        $mform->setDefault('config_title', 'What We Do');
        $mform->setType('config_title', PARAM_RAW);

        // Subtitle
        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_subtitle', 'Cum doctus civibus efficiantur in imperdiet deterruisset.');
        $mform->setType('config_subtitle', PARAM_RAW);

        $items_range = array(
          1 => '1',
          2 => '2',
          3 => '3',
          4 => '4',
          5 => '5',
          6 => '6',
          7 => '7',
          8 => '8',
        );

        $items_max = 8;

        $mform->addElement('select', 'config_items', get_string('config_items', 'theme_edumy'), $items_range);
        $mform->setDefault('config_items', 4);

        for($i = 1; $i <= $items_max; $i++) {
            $mform->addElement('header', 'config_ccn_item' . $i , get_string('config_item', 'theme_edumy') . $i);

            $mform->addElement('text', 'config_title' . $i, get_string('config_title', 'theme_edumy', $i));
            $mform->setDefault('config_title' .$i , 'Create Account');
            $mform->setType('config_title' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_body' . $i, get_string('config_body', 'theme_edumy', $i));
            $mform->setDefault('config_body' .$i , 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.');
            $mform->setType('config_body' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_link' . $i, get_string('config_link', 'theme_edumy', $i));
            $mform->setDefault('config_link' .$i , '#');
            $mform->setType('config_link' . $i, PARAM_TEXT);

            $options = array(
                '_self' => 'Self (open in same window)',
                '_blank' => 'Blank (open in new window)',
                '_parent' => 'Parent (open in parent frame)',
                '_top' => 'Top (open in full body of the window)',
            );
            $select = $mform->addElement('select', 'config_link_target' . $i, get_string('config_button_target', 'theme_edumy'), $options);
            $select->setSelected('_self');

            $select = $mform->addElement('select', 'config_icon' .$i, get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
            $select->setSelected('flaticon-student-3');

            $mform->addElement('text', 'config_color' . $i, get_string('config_color_bg', 'theme_edumy', $i), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color' .$i , 'rgb(245, 245, 246)');
            $mform->setType('config_color' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_color_hover' . $i, get_string('config_color_bg', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_hover' .$i , 'rgb(62, 68, 72)');
            $mform->setType('config_color_hover' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_color_icon' . $i, get_string('config_color_icon', 'theme_edumy', $i), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_icon' .$i , 'rgb(240, 208, 120)');
            $mform->setType('config_color_icon' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_color_icon_hover' . $i, get_string('config_color_icon', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_icon_hover' .$i , 'rgb(245, 245, 246)');
            $mform->setType('config_color_icon_hover' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_color_title' . $i, get_string('config_color_title', 'theme_edumy', $i), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_title' .$i , 'rgb(62, 68, 72)');
            $mform->setType('config_color_title' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_color_title_hover' . $i, get_string('config_color_title', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_title_hover' .$i , 'rgb(255,255,255)');
            $mform->setType('config_color_title_hover' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_color_body' . $i, get_string('config_color_body', 'theme_edumy', $i), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_body' .$i , 'rgb(62, 68, 72)');
            $mform->setType('config_color_body' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_color_body_hover' . $i, get_string('config_color_body', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_body_hover' .$i , 'rgb(255,255,255)');
            $mform->setType('config_color_body_hover' . $i, PARAM_TEXT);

        }

        $mform->addElement('header', 'config_ccn_colors', get_string('block_styles', 'theme_edumy'));

        $mform->addElement('text', 'config_color_bg', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_bg', '#fff');
        $mform->setType('config_color_bg', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title', '#0a0a0a');
        $mform->setType('config_color_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_subtitle', get_string('config_color_subtitle', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_subtitle', '#6f7074');
        $mform->setType('config_color_subtitle', PARAM_TEXT);

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }

    // function set_data($defaults)
    // {
    //
    //     // Begin CCN Image Processing
    //     if (empty($entry->id)) {
    //         $entry = new stdClass;
    //         $entry->id = null;
    //     }
    //     $draftitemid = file_get_submitted_draft_itemid('config_image');
    //     file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_boxes', 'content', 0,
    //         array('subdirs' => true));
    //     $entry->attachments = $draftitemid;
    //     parent::set_data($defaults);
    //     if ($data = parent::get_data()) {
    //         file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_boxes', 'content', 0,
    //             array('subdirs' => true));
    //     }
    //     // END CCN Image Processing
    //
    //
    //
    //     if (!empty($this->block->config) && is_object($this->block->config)) {
    //         $text = $this->block->config->bio;
    //         $draftid_editor = file_get_submitted_draft_itemid('config_bio');
    //         if (empty($text)) {
    //             $currenttext = '';
    //         } else {
    //             $currenttext = $text;
    //         }
    //         $defaults->config_bio['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_boxes', 'content', 0, array('subdirs'=>true), $currenttext);
    //         $defaults->config_bio['itemid'] = $draftid_editor;
    //         $defaults->config_bio['format'] = $this->block->config->format;
    //     } else {
    //         $text = '';
    //     }
    //
    //
    // }
}
