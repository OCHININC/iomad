<?php

class block_cocoon_tablets_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;
      $ccnFontList = include($CFG->dirroot . '/theme/edumy/ccn/font_handler/ccn_font_select.php');

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'What We Do');
        $mform->setType('config_title', PARAM_RAW);

        // Subtitle
        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_subtitle', 'Striving to make the web a more beautiful place every single day');
        $mform->setType('config_subtitle', PARAM_RAW);

        // Body
        $editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'noclean'=>true, 'context'=>$this->block->context);
        $mform->addElement('editor', 'config_body', get_string('config_body', 'theme_edumy'), null, $editoroptions);
        $mform->addRule('config_body', null, 'required', null, 'client');
        $mform->setType('config_body', PARAM_RAW); // XSS is prevented when printing the block contents and serving files

        // Button Text
        $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edumy'));
        $mform->setDefault('config_button_text', 'View More');
        $mform->setType('config_button_text', PARAM_RAW);

        // Button Link
        $mform->addElement('text', 'config_button_link', get_string('config_button_link', 'theme_edumy'));
        $mform->setDefault('config_button_link', '#');
        $mform->setType('config_button_link', PARAM_RAW);

        $radioarray=array();
        $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Right', 0, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Left', 1, $attributes);
        $mform->addGroup($radioarray, 'config_style', 'Tablet Position', array(' '), false);

        // Image
        $mform->addElement('filemanager', 'config_image', get_string('config_image', 'theme_edumy'), null,
                array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => null,
                'accepted_types' => array('.png', '.jpg', '.gif') ));

        // Feature 1
        $mform->addElement('header', 'config_feature_1', get_string('config_feature_1', 'theme_edumy'));

        $mform->addElement('text', 'config_feature_1_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_feature_1_title', 'Create Account');
        $mform->setType('config_feature_1_title', PARAM_TEXT);

        $mform->addElement('text', 'config_feature_1_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_feature_1_subtitle', 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.');
        $mform->setType('config_feature_1_subtitle', PARAM_TEXT);


        $select = $mform->addElement('select', 'config_feature_1_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-account');

        $mform->addElement('text', 'config_feature_1_link', get_string('config_link', 'theme_edumy'));
        $mform->setDefault('config_feature_1_link', '');
        $mform->setType('config_feature_1_link', PARAM_TEXT);

        $mform->addElement('text', 'config_color_1', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_1', '#2ac4ea');
        $mform->setType('config_color_1', PARAM_TEXT);

        $mform->addElement('text', 'config_color_hover_1', get_string('config_color_bg', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_hover_1' , '#2ac4ea');
        $mform->setType('config_color_hover_1', PARAM_TEXT);

        $mform->addElement('text', 'config_color_icon_1', get_string('config_color_icon', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_icon_1', 'rgb(255,255,255)');
        $mform->setType('config_color_icon_1', PARAM_TEXT);

        $mform->addElement('text', 'config_color_icon_hover_1', get_string('config_color_icon', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_icon_hover_1', 'rgb(255,255,255)');
        $mform->setType('config_color_icon_hover_1', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title_1', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title_1', 'rgb(255,255,255)');
        $mform->setType('config_color_title_1', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title_hover_1', get_string('config_color_title', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title_hover_1', 'rgb(255,255,255)');
        $mform->setType('config_color_title_hover_1', PARAM_TEXT);

        $mform->addElement('text', 'config_color_body_1', get_string('config_color_body', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_body_1', 'rgb(255,255,255)');
        $mform->setType('config_color_body_1', PARAM_TEXT);

        $mform->addElement('text', 'config_color_body_hover_1', get_string('config_color_body', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_body_hover_1', 'rgb(255,255,255)');
        $mform->setType('config_color_body_hover_1', PARAM_TEXT);


        // Feature 2
        $mform->addElement('header', 'config_feature_2', get_string('config_feature_2', 'theme_edumy'));

        $mform->addElement('text', 'config_feature_2_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_feature_2_title', 'Create Online Course');
        $mform->setType('config_feature_2_title', PARAM_TEXT);

        $mform->addElement('text', 'config_feature_2_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_feature_2_subtitle', 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.');
        $mform->setType('config_feature_2_subtitle', PARAM_TEXT);

        $select = $mform->addElement('select', 'config_feature_2_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-online');

        $mform->addElement('text', 'config_feature_2_link', get_string('config_link', 'theme_edumy'));
        $mform->setDefault('config_feature_2_link', '');
        $mform->setType('config_feature_2_link', PARAM_TEXT);

        $mform->addElement('text', 'config_color_2', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_2', '#ff1053');
        $mform->setType('config_color_2', PARAM_TEXT);

        $mform->addElement('text', 'config_color_hover_2', get_string('config_color_bg', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_hover_2' , '#ff1053');
        $mform->setType('config_color_hover_2', PARAM_TEXT);

        $mform->addElement('text', 'config_color_icon_2', get_string('config_color_icon', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_icon_2', 'rgb(255,255,255)');
        $mform->setType('config_color_icon_2', PARAM_TEXT);

        $mform->addElement('text', 'config_color_icon_hover_2', get_string('config_color_icon', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_icon_hover_2', 'rgb(255,255,255)');
        $mform->setType('config_color_icon_hover_2', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title_2', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title_2', 'rgb(255,255,255)');
        $mform->setType('config_color_title_2', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title_hover_2', get_string('config_color_title', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title_hover_2', 'rgb(255,255,255)');
        $mform->setType('config_color_title_hover_2', PARAM_TEXT);

        $mform->addElement('text', 'config_color_body_2', get_string('config_color_body', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_body_2', 'rgb(255,255,255)');
        $mform->setType('config_color_body_2', PARAM_TEXT);

        $mform->addElement('text', 'config_color_body_hover_2', get_string('config_color_body', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_body_hover_2', 'rgb(255,255,255)');
        $mform->setType('config_color_body_hover_2', PARAM_TEXT);


        // Feature 3
        $mform->addElement('header', 'config_feature_3', get_string('config_feature_3', 'theme_edumy'));

        $mform->addElement('text', 'config_feature_3_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_feature_3_title', 'Interact with Students');
        $mform->setType('config_feature_3_title', PARAM_TEXT);

        $mform->addElement('text', 'config_feature_3_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_feature_3_subtitle', 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.');
        $mform->setType('config_feature_3_subtitle', PARAM_TEXT);

        $select = $mform->addElement('select', 'config_feature_3_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-student-1');

        $mform->addElement('text', 'config_feature_3_link', get_string('config_link', 'theme_edumy'));
        $mform->setDefault('config_feature_3_link', '');
        $mform->setType('config_feature_3_link', PARAM_TEXT);

        $mform->addElement('text', 'config_color_3', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_3', '#2441e7');
        $mform->setType('config_color_3', PARAM_TEXT);

        $mform->addElement('text', 'config_color_hover_3', get_string('config_color_bg', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_hover_3' , '#2441e7');
        $mform->setType('config_color_hover_3', PARAM_TEXT);

        $mform->addElement('text', 'config_color_icon_3', get_string('config_color_icon', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_icon_3', 'rgb(255,255,255)');
        $mform->setType('config_color_icon_3', PARAM_TEXT);

        $mform->addElement('text', 'config_color_icon_hover_3', get_string('config_color_icon', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_icon_hover_3', 'rgb(255,255,255)');
        $mform->setType('config_color_icon_hover_3', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title_3', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title_3', 'rgb(255,255,255)');
        $mform->setType('config_color_title_3', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title_hover_3', get_string('config_color_title', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title_hover_3', 'rgb(255,255,255)');
        $mform->setType('config_color_title_hover_3', PARAM_TEXT);

        $mform->addElement('text', 'config_color_body_3', get_string('config_color_body', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_body_3', 'rgb(255,255,255)');
        $mform->setType('config_color_body_3', PARAM_TEXT);

        $mform->addElement('text', 'config_color_body_hover_3', get_string('config_color_body', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_body_hover_3', 'rgb(255,255,255)');
        $mform->setType('config_color_body_hover_3', PARAM_TEXT);


        // Feature 4
        $mform->addElement('header', 'config_feature_4', get_string('config_feature_4', 'theme_edumy'));

        $mform->addElement('text', 'config_feature_4_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_feature_4_title', 'Achieve Your Goals');
        $mform->setType('config_feature_4_title', PARAM_TEXT);

        $mform->addElement('text', 'config_feature_4_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_feature_4_subtitle', 'Sed cursus turpis vitae tortor donec eaque ipsa quaeab illo.');
        $mform->setType('config_feature_4_subtitle', PARAM_TEXT);

        $select = $mform->addElement('select', 'config_feature_4_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-employee');

        $mform->addElement('text', 'config_feature_4_link', get_string('config_link', 'theme_edumy'));
        $mform->setDefault('config_feature_4_link', '');
        $mform->setType('config_feature_4_link', PARAM_TEXT);

        $mform->addElement('text', 'config_color_4', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_4', '#fbbc05');
        $mform->setType('config_color_4', PARAM_TEXT);

        $mform->addElement('text', 'config_color_hover_4', get_string('config_color_bg', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_hover_4' , '#fbbc05');
        $mform->setType('config_color_hover_4', PARAM_TEXT);

        $mform->addElement('text', 'config_color_icon_4', get_string('config_color_icon', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_icon_4', 'rgb(255,255,255)');
        $mform->setType('config_color_icon_4', PARAM_TEXT);

        $mform->addElement('text', 'config_color_icon_hover_4', get_string('config_color_icon', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_icon_hover_4', 'rgb(255,255,255)');
        $mform->setType('config_color_icon_hover_4', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title_4', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title_4', 'rgb(255,255,255)');
        $mform->setType('config_color_title_4', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title_hover_4', get_string('config_color_title', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title_hover_4', 'rgb(255,255,255)');
        $mform->setType('config_color_title_hover_4', PARAM_TEXT);

        $mform->addElement('text', 'config_color_body_4', get_string('config_color_body', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_body_4', 'rgb(255,255,255)');
        $mform->setType('config_color_body_4', PARAM_TEXT);

        $mform->addElement('text', 'config_color_body_hover_4', get_string('config_color_body', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_body_hover_4', 'rgb(255,255,255)');
        $mform->setType('config_color_body_hover_4', PARAM_TEXT);


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
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_tablets', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_tablets', 'content', 0,
                array('subdirs' => true));
        }
        // END CCN Image Processing



        if (!empty($this->block->config) && is_object($this->block->config)) {
            $text = $this->block->config->body;
            $draftid_editor = file_get_submitted_draft_itemid('config_body');
            if (empty($text)) {
                $currenttext = '';
            } else {
                $currenttext = $text;
            }
            $defaults->config_body['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_tablets', 'content', 0, array('subdirs'=>true), $currenttext);
            $defaults->config_body['itemid'] = $draftid_editor;
            $defaults->config_body['format'] = $this->block->config->format;
        } else {
            $text = '';
        }


    }
}
