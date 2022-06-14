<?php

class block_cocoon_hero_1_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Find the Best Courses');
        $mform->setType('config_title', PARAM_RAW);

        // Subtitle
        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_subtitle', 'Technology is brining a massive wave of evolution on learning things on different ways.');
        $mform->setType('config_subtitle', PARAM_RAW);

        // Button Text
        $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edumy'));
        $mform->setDefault('config_button_text', 'Ready to Get Started?');
        $mform->setType('config_button_text', PARAM_RAW);

        // Button Link
        $mform->addElement('text', 'config_button_link', get_string('config_button_link_or_video', 'theme_edumy'));
        $mform->setDefault('config_button_link', '#');
        $mform->setType('config_button_link', PARAM_RAW);

        // Image
        $mform->addElement('filemanager', 'config_image', get_string('config_image', 'theme_edumy'), null,
                array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 1,
                'accepted_types' => array('.png', '.jpg', '.gif') ));

        $mform->addElement('header', 'config_ccn_colors', get_string('block_styles', 'theme_edumy'));

        $mform->addElement('text', 'config_color_gradient_start', get_string('color_gradient_start', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_gradient_start', 'rgb(54,159,219)');
        $mform->setType('config_color_gradient_start', PARAM_TEXT);

        $mform->addElement('text', 'config_color_gradient_end', get_string('color_gradient_end', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_gradient_end', 'rgb(5,25,37)');
        $mform->setType('config_color_gradient_end', PARAM_TEXT);

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
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_hero_1', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_hero_1', 'content', 0,
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
        //     $defaults->config_bio['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_hero_1', 'content', 0, array('subdirs'=>true), $currenttext);
        //     $defaults->config_bio['itemid'] = $draftid_editor;
        //     $defaults->config_bio['format'] = $this->block->config->format;
        // } else {
        //     $text = '';
        // }


    }
}
