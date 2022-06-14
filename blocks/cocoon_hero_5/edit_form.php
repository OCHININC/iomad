<?php

class block_cocoon_hero_5_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG;
        $ccnFontList = include($CFG->dirroot . '/theme/edumy/ccn/font_handler/ccn_font_select.php');

        if (!empty($this->block->config) && is_object($this->block->config)) {
            $ccnStorage = $this->block->config;
        } else {
            $ccnStorage = new stdClass();
            $ccnStorage->items = 3;
        }


        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', 'More than 2500 Online Courses');

        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setType('config_subtitle', PARAM_TEXT);
        $mform->setDefault('config_subtitle', 'Own your future learning new skills online');

        $ccnItmsRng = array(
          1 => '1',
          2 => '2',
          3 => '3',
        );

        $ccnItmsMx = 3;

        $mform->addElement('select', 'config_items', get_string('config_items', 'theme_edumy'), $ccnItmsRng);
        $mform->setDefault('config_items', 3);


        for($i = 1; $i <= $ccnItmsMx; $i++) {
            $mform->addElement('header', 'config_ccn_item' . $i , 'Slide ' . $i);

            $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                        'subdirs'       => 0,
                                        'maxfiles'      => 1,
                                        'accepted_types' => array('.jpg', '.png', '.gif'));

            $f = $mform->addElement('filemanager', 'config_image' . $i, get_string('config_image', 'theme_edumy', $i), null, $filemanageroptions);
        }

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }

    function set_data($defaults) {
        if (!empty($this->block->config) && is_object($this->block->config)) {

            for($i = 1; $i <= $this->block->config->items; $i++) {
                $field = 'image' . $i;
                $conffield = 'config_image' . $i;
                $draftitemid = file_get_submitted_draft_itemid($conffield);
                file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_hero_5', 'slides', $i, array('subdirs'=>false));
                $defaults->$conffield['itemid'] = $draftitemid;
                $this->block->config->$field = $draftitemid;
            }
        }

        parent::set_data($defaults);
    }
}
