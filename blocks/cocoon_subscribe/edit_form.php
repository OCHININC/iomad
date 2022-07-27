<?php

class block_cocoon_subscribe_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Get Newsletter');
        $mform->setType('config_title', PARAM_RAW);

        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_subtitle', 'Your download should start automatically, if not Click here. Do you want our newsletter?');
        $mform->setType('config_subtitle', PARAM_RAW);

        $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edumy'));
        $mform->setDefault('config_button_text', 'Get it Now');
        $mform->setType('config_button_text', PARAM_RAW);

        $mform->addElement('header', 'config_ccn_colors', get_string('block_styles', 'theme_edumy'));

        $mform->addElement('text', 'config_color_bg', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_bg', '#f9fafc');
        $mform->setType('config_color_bg', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title', '#0a0a0a');
        $mform->setType('config_color_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_subtitle', get_string('config_color_subtitle', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_subtitle', '#6f7074');
        $mform->setType('config_color_subtitle', PARAM_TEXT);

        $mform->addElement('text', 'config_color_btn', get_string('config_color_btn', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_btn', '#2441e7');
        $mform->setType('config_color_btn', PARAM_TEXT);

        $mform->addElement('text', 'config_color_btn_hover', get_string('config_color_btn', 'theme_edumy') . get_string('on_hover', 'theme_edumy') , array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_btn_hover', '#2441e7');
        $mform->setType('config_color_btn_hover', PARAM_TEXT);

        $options = array(
            '0' => 'Yes',
            '1' => 'No',
        );
        $select = $mform->addElement('select', 'config_box_shadow', get_string('config_box_shadow', 'theme_edumy'), $options, array('class'=>'ccnCommLcRef_change'));
        $select->setSelected('0');

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }

    function set_data($defaults)
    {

        // Begin CCN Image Processing
        if (empty($entry->id)) {
            $entry = new stdClass;
            $entry->id = null;
        }
        $draftitemid = file_get_submitted_draft_itemid('config_image');
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_subscribe', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_subscribe', 'content', 0,
                array('subdirs' => true));
        }
        // END CCN Image Processing



        // if (!empty($this->block->config) && is_object($this->block->config)) {
        //     $text = $this->block->config->bio;
        //     $draftid_editor = file_get_submitted_draft_itemid('config_bio');
        //     if (empty($text)) {
        //         $currenttext = '';
        //     } else {
        //         $currenttext = $text;
        //     }
        //     $defaults->config_bio['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_subscribe', 'content', 0, array('subdirs'=>true), $currenttext);
        //     $defaults->config_bio['itemid'] = $draftid_editor;
        //     $defaults->config_bio['format'] = $this->block->config->format;
        // } else {
        //     $text = '';
        // }


    }
}
