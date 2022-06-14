<?php

class block_cocoon_gallery_slider_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Media');
        $mform->setType('config_title', PARAM_RAW);

        // Subtitle
        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_subtitle', 'Cum doctus civibus efficiantur in imperdiet deterruisset.');
        $mform->setType('config_subtitle', PARAM_RAW);


        // Image
        $mform->addElement('filemanager', 'config_image', get_string('config_image', 'theme_edumy'), null,
                array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => null, 'maxfiles' => null,
                'accepted_types' => array('.png', '.jpg', '.gif') ));

        $radioarray=array();
        $radioarray[] = $mform->createElement('radio', 'config_columns', '', '1', 0, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_columns', '', '2', 1, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_columns', '', '3', 2, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_columns', '', '4', 3, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_columns', '', '5', 4, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_columns', '', '6', 5, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_columns', '', '7', 6, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_columns', '', '8', 7, $attributes);
        $mform->addGroup($radioarray, 'config_columns', get_string('config_columns', 'theme_edumy'), array(' '), false);

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
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_gallery_slider', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_gallery_slider', 'content', 0,
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
            $defaults->config_bio['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_gallery_slider', 'content', 0, array('subdirs'=>true), $currenttext);
            $defaults->config_bio['itemid'] = $draftid_editor;
            $defaults->config_bio['format'] = $this->block->config->format;
        } else {
            $text = '';
        }


    }
}
