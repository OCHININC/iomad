<?php

class block_cocoon_course_info_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {

        global $CFG;

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'block_cocoon_course_info'));
        $mform->setDefault('config_title', 'Not sure?');
        $mform->setType('config_title', PARAM_RAW);

        // Body
        $mform->addElement('text', 'config_body', get_string('config_body', 'block_cocoon_course_info'));
        $mform->setDefault('config_body', 'Every course comes with a 30-day money-back guarantee');
        $mform->setType('config_lectures', PARAM_RAW);

        // Image
        $mform->addElement('filemanager', 'config_image', get_string('config_image', 'block_cocoon_course_info'), null,
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
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_course_info', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_course_info', 'content', 0,
                array('subdirs' => true));
        }
        // END CCN Image Processing


    }
}
