<?php

class block_cocoon_event_slider_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG;

        if (!empty($this->block->config) && is_object($this->block->config)) {
            $data = $this->block->config;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 0;
        }


        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Upcoming Events');
        $mform->setType('config_title', PARAM_TEXT);

        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_subtitle', 'Cum doctus civibus efficiantur in imperdiet deterruisset.');
        $mform->setType('config_subtitle', PARAM_TEXT);

        $radioarray=array();
        $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Standard', 0, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Fullsize', 1, $attributes);
        $mform->addGroup($radioarray, 'config_style', 'Slider Size', array(' '), false);

        $slidesrange = range(0, 12);
        $mform->addElement('select', 'config_slidesnumber', get_string('config_items', 'theme_edumy'), $slidesrange);
        $mform->setDefault('config_slidesnumber', $data->slidesnumber);

        for($i = 1; $i <= $data->slidesnumber; $i++) {
            $mform->addElement('header', 'config_header' . $i , 'Slide ' . $i);

            $mform->addElement('text', 'config_slide_title' . $i, get_string('config_title', 'theme_edumy', $i));
            $mform->setDefault('config_slide_title' .$i , 'An Overworked Newspaper Editor');
            $mform->setType('config_slide_title' . $i, PARAM_TEXT);

            $mform->addElement('date_selector', 'config_slide_date' . $i, get_string('config_date', 'theme_edumy', $i));

            $mform->addElement('text', 'config_slide_location' . $i, get_string('config_location', 'theme_edumy', $i));
            $mform->setDefault('config_slide_location' .$i , 'Vancouver, Canada');
            $mform->setType('config_slide_location' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_slide_time' . $i, get_string('config_time', 'theme_edumy', $i));
            $mform->setDefault('config_slide_time' .$i , '8:00 am - 5:00 pm');
            $mform->setType('config_slide_time' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_slide_url' . $i, get_string('config_link', 'theme_edumy', $i));
            $mform->setDefault('config_slide_url' .$i , '#');
            $mform->setType('config_slide_url' . $i, PARAM_TEXT);

            $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                        'subdirs'       => 0,
                                        'maxfiles'      => 1,
                                        'accepted_types' => array('.jpg', '.png', '.gif'));

            $f = $mform->addElement('filemanager', 'config_file_slide' . $i, get_string('config_image', 'theme_edumy', $i), null, $filemanageroptions);
        }

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }

    function set_data($defaults) {
        if (!empty($this->block->config) && is_object($this->block->config)) {

            for($i = 1; $i <= $this->block->config->slidesnumber; $i++) {
                $field = 'file_slide' . $i;
                $conffield = 'config_file_slide' . $i;
                $draftitemid = file_get_submitted_draft_itemid($conffield);
                file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_event_slider', 'slides', $i, array('subdirs'=>false));
                $defaults->$conffield['itemid'] = $draftitemid;
                $this->block->config->$field = $draftitemid;
            }
        }

        parent::set_data($defaults);
    }
}
