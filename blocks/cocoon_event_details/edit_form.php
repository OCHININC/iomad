<?php

class block_cocoon_event_details_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'block_cocoon_event_details'));
        $mform->setDefault('config_title', 'Event Details');
        $mform->setType('config_title', PARAM_RAW);

        // Date
        $mform->addElement('date_selector', 'config_date', get_string('config_date', 'block_cocoon_event_details'));

        // Time
        $mform->addElement('text', 'config_time', get_string('config_time', 'block_cocoon_event_details'));
        $mform->setDefault('config_time', 'Time: 8:00 am - 5:00 pm');
        $mform->setType('config_time', PARAM_RAW);

        // Location
        $mform->addElement('text', 'config_location', get_string('config_location', 'block_cocoon_event_details'));
        $mform->setDefault('config_location', 'Address: Cambridge, MA 02138, USA');
        $mform->setType('config_location', PARAM_RAW);

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
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_event_details', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_event_details', 'content', 0,
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
            $defaults->config_bio['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_event_details', 'content', 0, array('subdirs'=>true), $currenttext);
            $defaults->config_bio['itemid'] = $draftid_editor;
            $defaults->config_bio['format'] = $this->block->config->format;
        } else {
            $text = '';
        }


    }
}
