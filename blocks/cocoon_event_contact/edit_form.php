<?php

class block_cocoon_event_contact_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'block_cocoon_event_contact'));
        $mform->setDefault('config_title', 'Event Contact');
        $mform->setType('config_title', PARAM_RAW);

        // Phone
        $mform->addElement('text', 'config_phone', get_string('config_phone', 'block_cocoon_event_contact'));
        $mform->setDefault('config_phone', 'Time: 8:00 am - 5:00 pm');
        $mform->setType('config_phone', PARAM_RAW);

        // Email
        $mform->addElement('text', 'config_email', get_string('config_email', 'block_cocoon_event_contact'));
        $mform->setDefault('config_email', '1-896-567-23497');
        $mform->setType('config_email', PARAM_RAW);

        // Location
        $mform->addElement('text', 'config_website', get_string('config_website', 'block_cocoon_event_contact'));
        $mform->setDefault('config_website', 'http://www.edumy.com');
        $mform->setType('config_website', PARAM_RAW);

        $mform->addElement('text', 'config_map_lat', get_string('config_map_lat', 'block_cocoon_event_contact'));
        $mform->setDefault('config_map_lat', '40.6946703');
        $mform->setType('config_map_lat', PARAM_RAW);

        $mform->addElement('text', 'config_map_lng', get_string('config_map_lng', 'block_cocoon_event_contact'));
        $mform->setDefault('config_map_lng', '-73.9280182');
        $mform->setType('config_map_lng', PARAM_RAW);

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
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_event_contact', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_event_contact', 'content', 0,
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
            $defaults->config_bio['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_event_contact', 'content', 0, array('subdirs'=>true), $currenttext);
            $defaults->config_bio['itemid'] = $draftid_editor;
            $defaults->config_bio['format'] = $this->block->config->format;
        } else {
            $text = '';
        }


    }
}
