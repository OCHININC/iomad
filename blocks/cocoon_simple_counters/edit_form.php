<?php

class block_cocoon_simple_counters_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;
      $ccnFontList = include($CFG->dirroot . '/theme/edumy/ccn/font_handler/ccn_font_select.php');

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Our Story');
        $mform->setType('config_title', PARAM_RAW);

        $radioarray=array();
        $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Align left', 0, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Align center', 1, $attributes);
        $mform->addGroup($radioarray, 'config_style', 'Style', array(' '), false);

        // Counter 1
        $mform->addElement('header', 'config_header_2', 'Counter 1');

        $mform->addElement('text', 'config_counter_1', get_string('config_number', 'theme_edumy'));
        $mform->setDefault('config_counter_1', '6500');
        $mform->setType('config_counter_1', PARAM_RAW);

        $mform->addElement('text', 'config_counter_1_after', get_string('config_number_after', 'theme_edumy'));
        $mform->setDefault('config_counter_1_after', '+');
        $mform->setType('config_counter_1_after', PARAM_RAW);

        $mform->addElement('text', 'config_counter_1_text', get_string('config_text', 'theme_edumy'));
        $mform->setDefault('config_counter_1_text', 'Students learning');
        $mform->setType('config_counter_1_text', PARAM_RAW);

        // $mform->addElement('text', 'config_counter_1_icon', get_string('config_icon_class', 'theme_edumy'));
        // $mform->setDefault('config_counter_1_icon', 'flaticon-student');
        // $mform->setType('config_counter_1_icon', PARAM_RAW);

        $select = $mform->addElement('select', 'config_counter_1_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-student');

        // Counter 2
        $mform->addElement('header', 'config_header_3', 'Counter 2');

        $mform->addElement('text', 'config_counter_2', get_string('config_number', 'theme_edumy'));
        $mform->setDefault('config_counter_2', '58263');
        $mform->setType('config_counter_2', PARAM_RAW);

        $mform->addElement('text', 'config_counter_2_after', get_string('config_number_after', 'theme_edumy'));
        $mform->setDefault('config_counter_2_after', '+');
        $mform->setType('config_counter_2_after', PARAM_RAW);

        $mform->addElement('text', 'config_counter_2_text', get_string('config_text', 'theme_edumy'));
        $mform->setDefault('config_counter_2_text', 'Graduates');
        $mform->setType('config_counter_2_text', PARAM_RAW);

        // $mform->addElement('text', 'config_counter_2_icon', get_string('config_icon_class', 'theme_edumy'));
        // $mform->setDefault('config_counter_2_icon', 'flaticon-book');
        // $mform->setType('config_counter_2_icon', PARAM_RAW);

        $select = $mform->addElement('select', 'config_counter_2_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-book');

        // Counter 3
        $mform->addElement('header', 'config_header_4', 'Counter 3');

        $mform->addElement('text', 'config_counter_3', get_string('config_number', 'theme_edumy'));
        $mform->setDefault('config_counter_3', '896673');
        $mform->setType('config_counter_3', PARAM_RAW);

        $mform->addElement('text', 'config_counter_3_after', get_string('config_number_after', 'theme_edumy'));
        $mform->setDefault('config_counter_3_after', '+');
        $mform->setType('config_counter_3_after', PARAM_RAW);

        $mform->addElement('text', 'config_counter_3_text', get_string('config_text', 'theme_edumy'));
        $mform->setDefault('config_counter_3_text', 'Free courses');
        $mform->setType('config_counter_3_text', PARAM_RAW);

        // $mform->addElement('text', 'config_counter_3_icon', get_string('config_icon_class', 'theme_edumy'));
        // $mform->setDefault('config_counter_3_icon', 'flaticon-global');
        // $mform->setType('config_counter_3_icon', PARAM_RAW);

        $select = $mform->addElement('select', 'config_counter_3_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-global');

        // Counter 4
        $mform->addElement('header', 'config_header_5', 'Counter 4');

        $mform->addElement('text', 'config_counter_4', get_string('config_number', 'theme_edumy'));
        $mform->setDefault('config_counter_4', '8570');
        $mform->setType('config_counter_4', PARAM_RAW);

        $mform->addElement('text', 'config_counter_4_after', get_string('config_number_after', 'theme_edumy'));
        $mform->setDefault('config_counter_4_after', '+');
        $mform->setType('config_counter_4_after', PARAM_RAW);

        $mform->addElement('text', 'config_counter_4_text', get_string('config_text', 'theme_edumy'));
        $mform->setDefault('config_counter_4_text', 'Active courses');
        $mform->setType('config_counter_4_text', PARAM_RAW);

        // $mform->addElement('text', 'config_counter_4_icon', get_string('config_icon_class', 'theme_edumy'));
        // $mform->setDefault('config_counter_4_icon', 'flaticon-first');
        // $mform->setType('config_counter_4_icon', PARAM_RAW);

        $select = $mform->addElement('select', 'config_counter_4_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-first');

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
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_simple_counters', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_simple_counters', 'content', 0,
                array('subdirs' => true));
        }
        // END CCN Image Processing



        if (!empty($this->block->config) && is_object($this->block->config)) {
            $text = $this->block->config->bio;
            $draftid_editor = file_get_submitted_draft_itemid('config_bio');
            if (empty($text)) {
                $currenttext = '';
            } else {
                $currenttext = $text;
            }
            $defaults->config_bio['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_simple_counters', 'content', 0, array('subdirs'=>true), $currenttext);
            $defaults->config_bio['itemid'] = $draftid_editor;
            $defaults->config_bio['format'] = $this->block->config->format;
        } else {
            $text = '';
        }


    }
}
