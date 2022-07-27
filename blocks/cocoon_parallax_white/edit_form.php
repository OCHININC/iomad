<?php

class block_cocoon_parallax_white_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'block_cocoon_parallax_white'));
        $mform->setDefault('config_title', 'Get Personalized Recommendations');
        $mform->setType('config_title', PARAM_RAW);

        // Subtitle
        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'block_cocoon_parallax_white'));
        $mform->setDefault('config_subtitle', 'Answer a few questions for your top picks');
        $mform->setType('config_subtitle', PARAM_RAW);

        // Button Text
        $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'block_cocoon_parallax_white'));
        $mform->setDefault('config_button_text', 'View More');
        $mform->setType('config_button_text', PARAM_RAW);

        // Button Link
        $mform->addElement('text', 'config_button_link', get_string('config_button_link', 'block_cocoon_parallax_white'));
        $mform->setDefault('config_button_link', '#');
        $mform->setType('config_button_link', PARAM_RAW);

        // Button Target
        $options = array(
            '_self' => 'Self (open in same window)',
            '_blank' => 'Blank (open in new window)',
            '_parent' => 'Parent (open in parent frame)',
            '_top' => 'Top (open in full body of the window)',
        );
        $select = $mform->addElement('select', 'config_button_target', get_string('config_button_target', 'theme_edumy'), $options);
        $select->setSelected('_self');


        // Image
        $mform->addElement('filemanager', 'config_image', get_string('config_image', 'block_cocoon_parallax_white'), null,
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
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_parallax_white', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_parallax_white', 'content', 0,
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
            $defaults->config_bio['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_parallax_white', 'content', 0, array('subdirs'=>true), $currenttext);
            $defaults->config_bio['itemid'] = $draftid_editor;
            $defaults->config_bio['format'] = $this->block->config->format;
        } else {
            $text = '';
        }


    }
}
