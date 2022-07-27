<?php

class block_cocoon_parallax_subscribe_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'REGISTER TO GET IT');
        $mform->setType('config_title', PARAM_RAW);

        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_subtitle', 'Get 100 Online Courses for Free');
        $mform->setType('config_subtitle', PARAM_RAW);

        $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edumy'));
        $mform->setDefault('config_button_text', 'Get it Now');
        $mform->setType('config_button_text', PARAM_RAW);

        // Date
        $mform->addElement('date_selector', 'config_date', get_string('config_countdown_date', 'block_cocoon_event_body'));


                // Image
                $mform->addElement('filemanager', 'config_image', get_string('config_image', 'theme_edumy'), null,
                        array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 1,
                        'accepted_types' => array('.png', '.jpg', '.gif') ));

                include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');
                

        $mform->addElement('header', 'configform', get_string('config_form', 'theme_edumy'));

        $mform->addElement('text', 'config_form_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_form_title', 'SIGNUP TO NEWSLETTER TO GET IT');
        $mform->setType('config_form_title', PARAM_RAW);

        $mform->addElement('text', 'config_form_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_form_subtitle', 'THE COMPLETE WEB DEVELOPER COURSE');
        $mform->setType('config_form_subtitle', PARAM_RAW);




    }

    function set_data($defaults)
    {

        // Begin CCN Image Processing
        if (empty($entry->id)) {
            $entry = new stdClass;
            $entry->id = null;
        }
        $draftitemid = file_get_submitted_draft_itemid('config_image');
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_parallax_subscribe', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_parallax_subscribe', 'content', 0,
                array('subdirs' => true));
        }
        // END CCN Image Processing



    }
  }
