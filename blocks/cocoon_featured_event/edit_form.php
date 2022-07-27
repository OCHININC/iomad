<?php

class block_cocoon_featured_event_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Everything is Teachable');
        $mform->setType('config_title', PARAM_RAW);

        // Subtitle
        $mform->addElement('textarea', 'config_body', get_string('config_body', 'theme_edumy'));
        $mform->setDefault('config_body', 'Lorem gravida nibh vel veliauctor aliquenean sollicitudin, lorem quis bibendum auctor nisi elit consequat ipsutis sem nibh id elit.');
        $mform->setType('config_body', PARAM_RAW);

        // Date
        $mform->addElement('date_selector', 'config_date', get_string('config_date', 'theme_edumy'));

        // End Date
        $mform->addElement('date_selector', 'config_end_date', get_string('config_end_date', 'theme_edumy'));

        // Time
        $mform->addElement('text', 'config_time', get_string('config_time', 'block_cocoon_featured_event'));
        $mform->setDefault('config_time', 'Time: 8:00 am - 5:00 pm');
        $mform->setType('config_time', PARAM_RAW);

        // Location
        $mform->addElement('text', 'config_location', get_string('config_location', 'theme_edumy'));
        $mform->setDefault('config_location', 'Address: Cambridge, MA 02138, USA');
        $mform->setType('config_location', PARAM_RAW);

        // Button Text
        $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edumy'));
        $mform->setDefault('config_button_text', 'View Details');
        $mform->setType('config_button_text', PARAM_RAW);

        // Button Link
        $mform->addElement('text', 'config_button_link', get_string('config_button_link', 'theme_edumy'));
        $mform->setDefault('config_button_link', '#');
        $mform->setType('config_button_link', PARAM_RAW);

        // Image
        $mform->addElement('filemanager', 'config_image', get_string('config_image', 'theme_edumy'), null,
                array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 1,
                'accepted_types' => array('.png', '.jpg', '.gif') ));

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
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_featured_event', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_featured_event', 'content', 0,
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
            $defaults->config_bio['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_featured_event', 'content', 0, array('subdirs'=>true), $currenttext);
            $defaults->config_bio['itemid'] = $draftid_editor;
            $defaults->config_bio['format'] = $this->block->config->format;
        } else {
            $text = '';
        }


    }
}
