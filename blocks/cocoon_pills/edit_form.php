<?php

class block_cocoon_pills_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG;

        if (!empty($this->block->config) && is_object($this->block->config)) {
            $data = $this->block->config;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 4;
        }


        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $slidesrange = array(
          1 => '1',
          2 => '2',
          3 => '3',
          4 => '4',
          5 => '5',
          6 => '6',
          7 => '7',
          8 => '8',
          9 => '9',
          10 => '10',
          11 => '11',
          12 => '12',
        );

        $slidesmax = 12;

        $mform->addElement('select', 'config_slidesnumber', get_string('config_items', 'theme_edumy'), $slidesrange);
        $mform->setDefault('config_slidesnumber', 4);

        for($i = 1; $i <= $slidesmax; $i++) {
            $mform->addElement('header', 'config_ccn_item' . $i , get_string('config_item', 'theme_edumy') . $i);

            $mform->addElement('text', 'config_slide_title' . $i, get_string('config_title', 'theme_edumy', $i));
            $mform->setDefault('config_slide_title' .$i , 'Program');
            $mform->setType('config_slide_title' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_slide_subtitle' . $i, get_string('config_subtitle', 'theme_edumy', $i));
            $mform->setDefault('config_slide_subtitle' .$i , 'Lorem Ipsum is simply of the printing and industry.');
            $mform->setType('config_slide_subtitle' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_slide_btn_text' . $i, get_string('config_button_text', 'theme_edumy', $i));
            $mform->setDefault('config_slide_btn_text' .$i , 'Learn more');
            $mform->setType('config_slide_btn_text' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_slide_btn_link' . $i, get_string('config_button_link', 'theme_edumy', $i));
            $mform->setDefault('config_slide_btn_link' .$i , '#');
            $mform->setType('config_slide_btn_link' . $i, PARAM_TEXT);

            $options = array(
                '_self' => 'Self (open in same window)',
                '_blank' => 'Blank (open in new window)',
                '_parent' => 'Parent (open in parent frame)',
                '_top' => 'Top (open in full body of the window)',
            );
            $select = $mform->addElement('select', 'config_button_target' . $i, get_string('config_button_target', 'theme_edumy'), $options);
            $select->setSelected('_self');


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
                file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_pills', 'slides', $i, array('subdirs'=>false));
                $defaults->$conffield['itemid'] = $draftitemid;
                $this->block->config->$field = $draftitemid;
            }
        }

        parent::set_data($defaults);
    }
}
