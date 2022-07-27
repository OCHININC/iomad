<?php

class block_cocoon_course_instructor_edit_form extends block_edit_form
{

    private function get_users()
    {
        global $DB, $OUTPUT, $PAGE;

        $usernames = [];

        if(empty($this->block->config->user)) return [];
        $ids = $this->block->config->user;

        list($uids, $params) = $DB->get_in_or_equal($ids);
        $rs = $DB->get_recordset_select('user', 'id ' . $uids, $params, '', 'id,firstname,lastname,email');

        foreach ($rs as $record)
        {
            $usernames[$record->id] = fullname($record) . ' ' . $record->email;
        }
        $rs->close();

        return $usernames;
    }


    protected function specific_definition($mform)
    {
      global $CFG;


        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'block_cocoon_course_instructor'));
        $mform->setDefault('config_title', 'About the instructor');
        $mform->setType('config_title', PARAM_RAW);

        $usernames = $this->get_users();
        $mform->addElement('autocomplete', 'config_user', get_string('config_teacher', 'theme_edumy'), $usernames, [
        	'multiple' => false,
            'ajax' => 'tool_lp/form-user-selector',
        ]);
        $mform->addRule('config_user', null, 'required');


        // Section header title according to language file.
        $mform->addElement('header', 'config_overrides', get_string('config_overrides', 'theme_edumy'));

        // Name
        $mform->addElement('text', 'config_name', get_string('config_name', 'block_cocoon_course_instructor'));
        $mform->setDefault('config_name', '');
        $mform->setType('config_name', PARAM_RAW);

        // Position
        $mform->addElement('text', 'config_position', get_string('config_position', 'block_cocoon_course_instructor'));
        $mform->setDefault('config_position', '');
        $mform->setType('config_position', PARAM_RAW);

        // Students
        $mform->addElement('text', 'config_students', get_string('config_students', 'block_cocoon_course_instructor'));
        $mform->setDefault('config_students', '');
        $mform->setType('config_students', PARAM_RAW);

        // Reviews
        // $mform->addElement('text', 'config_reviews', get_string('config_reviews', 'block_cocoon_course_instructor'));
        // $mform->setDefault('config_reviews', '');
        // $mform->setType('config_reviews', PARAM_RAW);

        // Reviews
        // $mform->addElement('text', 'config_rating', get_string('config_rating', 'block_cocoon_course_instructor'));
        // $mform->setDefault('config_rating', '');
        // $mform->setType('config_rating', PARAM_RAW);

        // Courses
        $mform->addElement('text', 'config_courses', get_string('config_courses', 'block_cocoon_course_instructor'));
        $mform->setDefault('config_courses', '');
        $mform->setType('config_courses', PARAM_RAW);

        // Image
        $mform->addElement('filemanager', 'config_image', get_string('config_image', 'theme_edumy'), null,
                array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 1,
                'accepted_types' => array('.png', '.jpg', '.gif') ));

        // Bio
        $editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'noclean'=>true, 'context'=>$this->block->context);
        $mform->addElement('editor', 'config_bio', get_string('config_bio', 'block_cocoon_course_instructor'), null, $editoroptions);
        // $mform->addRule('config_bio', null, 'required', null, 'client');
        $mform->setType('config_bio', PARAM_RAW); // XSS is prevented when printing the block contents and serving files

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
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_course_instructor', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_course_instructor', 'content', 0,
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
            $defaults->config_bio['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_course_instructor', 'content', 0, array('subdirs'=>true), $currenttext);
            $defaults->config_bio['itemid'] = $draftid_editor;
            $defaults->config_bio['format'] = $this->block->config->format;
        } else {
            $text = '';
        }


    }
}
