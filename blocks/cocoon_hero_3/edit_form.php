<?php

class block_cocoon_hero_3_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG;
        $ccnFontList = include($CFG->dirroot . '/theme/edumy/ccn/font_handler/ccn_font_select.php');

        if (!empty($this->block->config) && is_object($this->block->config)) {
            $data = $this->block->config;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 3;
        }


        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', 'MORE THAN 2500 ONLINE COURSES');

        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setType('config_subtitle', PARAM_TEXT);
        $mform->setDefault('config_subtitle', 'Own your future learning new skills online');

        $slidesrange = array(
          1 => '1',
          2 => '2',
          3 => '3',
        );

        $slidesmax = 3;

        $mform->addElement('select', 'config_slidesnumber', get_string('config_items', 'theme_edumy'), $slidesrange);
        $mform->setDefault('config_slidesnumber', 3);

        // Feature 1
        $mform->addElement('header', 'config_feature_1', get_string('config_feature_1', 'theme_edumy'));

        $mform->addElement('text', 'config_feature_1_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_feature_1_title', 'Design: Over 800 Courses');
        $mform->setType('config_feature_1_title', PARAM_TEXT);

        $select = $mform->addElement('select', 'config_feature_1_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-pencil');

        // Feature 2
        $mform->addElement('header', 'config_feature_2', get_string('config_feature_2', 'theme_edumy'));

        $mform->addElement('text', 'config_feature_2_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_feature_2_title', 'Business: Over 1,400 Courses');
        $mform->setType('config_feature_2_title', PARAM_TEXT);

        $select = $mform->addElement('select', 'config_feature_2_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-student-1');

        // Feature 3
        $mform->addElement('header', 'config_feature_3', get_string('config_feature_3', 'theme_edumy'));

        $mform->addElement('text', 'config_feature_3_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_feature_3_title', 'Photography: Over 740 Courses');
        $mform->setType('config_feature_3_title', PARAM_TEXT);

        $select = $mform->addElement('select', 'config_feature_3_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-photo-camera');

        // Feature 4
        $mform->addElement('header', 'config_feature_4', get_string('config_feature_4', 'theme_edumy'));

        $mform->addElement('text', 'config_feature_4_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_feature_4_title', 'Marketing: Over 200 Courses');
        $mform->setType('config_feature_4_title', PARAM_TEXT);

        $select = $mform->addElement('select', 'config_feature_4_icon', get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
        $select->setSelected('flaticon-medal');

        for($i = 1; $i <= $slidesmax; $i++) {
            $mform->addElement('header', 'config_ccn_item' . $i , 'Slide ' . $i);

            $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                        'subdirs'       => 0,
                                        'maxfiles'      => 1,
                                        'accepted_types' => array('.jpg', '.png', '.gif'));

            $f = $mform->addElement('filemanager', 'config_file_slide' . $i, get_string('config_image', 'theme_edumy', $i), null, $filemanageroptions);
        }

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit/edit_ccn_carousel.php');
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }

    function set_data($defaults) {
        if (!empty($this->block->config) && is_object($this->block->config)) {

            for($i = 1; $i <= $this->block->config->slidesnumber; $i++) {
                $field = 'file_slide' . $i;
                $conffield = 'config_file_slide' . $i;
                $draftitemid = file_get_submitted_draft_itemid($conffield);
                file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_hero_3', 'slides', $i, array('subdirs'=>false));
                $defaults->$conffield['itemid'] = $draftitemid;
                $this->block->config->$field = $draftitemid;
            }
        }

        parent::set_data($defaults);
    }
}
