<?php

class block_cocoon_about_2_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;

        // Section header title according to language file.
        $mform->addElement('header', 'config_col_1_header', get_string('config_col_1_header', 'block_cocoon_about_2'));

        // Title
        $mform->addElement('text', 'config_col_1_title', get_string('config_col_1_title', 'block_cocoon_about_2'));
        $mform->setDefault('config_col_1_title', 'Who We Are');
        $mform->setType('config_col_1_title', PARAM_RAW);

        // Body
        $editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'noclean'=>true, 'context'=>$this->block->context);
        $mform->addElement('editor', 'config_col_1_body', get_string('config_col_1_body', 'block_cocoon_about_2'), null, $editoroptions);
        $mform->addRule('config_col_1_body', null, 'required', null, 'client');
        $mform->setType('config_col_1_body', PARAM_RAW); // XSS is prevented when printing the block contents and serving files

        // Section header title according to language file.
        $mform->addElement('header', 'config_col_2_header', get_string('config_col_2_header', 'block_cocoon_about_2'));

        // Title
        $mform->addElement('text', 'config_col_2_title', get_string('config_col_2_title', 'block_cocoon_about_2'));
        $mform->setDefault('config_col_2_title', 'What We Do');
        $mform->setType('config_col_2_title', PARAM_RAW);

        // Body
        $editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'noclean'=>true, 'context'=>$this->block->context);
        $mform->addElement('editor', 'config_col_2_body', get_string('config_col_2_body', 'block_cocoon_about_2'), null, $editoroptions);
        $mform->addRule('config_col_2_body', null, 'required', null, 'client');
        $mform->setType('config_col_2_body', PARAM_RAW); // XSS is prevented when printing the block contents and serving files

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
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_about_2', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_about_2', 'content', 0,
                array('subdirs' => true));
        }
        // END CCN Image Processing



        if (!empty($this->block->config) && is_object($this->block->config)) {
            $text = $this->block->config->col_1_body;
            $draftid_editor = file_get_submitted_draft_itemid('config_col_1_body');
            if (empty($text)) {
                $currenttext = '';
            } else {
                $currenttext = $text;
            }
            $defaults->config_col_1_body['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_about_2', 'content', 0, array('subdirs'=>true), $currenttext);
            $defaults->config_col_1_body['itemid'] = $draftid_editor;
            $defaults->config_col_1_body['format'] = $this->block->config->format;
        } else {
            $text = '';
        }

        if (!empty($this->block->config) && is_object($this->block->config)) {
            $text = $this->block->config->col_2_body;
            $draftid_editor = file_get_submitted_draft_itemid('config_col_2_body');
            if (empty($text)) {
                $currenttext = '';
            } else {
                $currenttext = $text;
            }
            $defaults->config_col_2_body['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_about_2', 'content', 0, array('subdirs'=>true), $currenttext);
            $defaults->config_col_2_body['itemid'] = $draftid_editor;
            $defaults->config_col_2_body['format'] = $this->block->config->format;
        } else {
            $text = '';
        }


    }
}
