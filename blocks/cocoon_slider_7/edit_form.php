<?php

class block_cocoon_slider_7_edit_form extends block_edit_form {
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
        );

        $slidesmax = 4;

        $mform->addElement('select', 'config_slidesnumber', get_string('config_items', 'theme_edumy'), $slidesrange);
        $mform->setDefault('config_slidesnumber', 4);

        for($i = 1; $i <= $slidesmax; $i++) {
            $mform->addElement('header', 'config_ccn_item' . $i , 'Slide ' . $i);

            $mform->addElement('text', 'config_title_' . $i, get_string('config_title', 'theme_edumy', $i));
            $mform->setDefault('config_title_' .$i , 'Learn Remotely From ');
            $mform->setType('config_title_' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_title_2_' . $i, get_string('config_title_2', 'theme_edumy', $i));
            $mform->setDefault('config_title_2_' .$i , 'Anywhere');
            $mform->setType('config_title_2_' . $i, PARAM_TEXT);

            $f = $mform->addElement('filemanager', 'config_image_' . $i, get_string('config_image', 'theme_edumy', $i), null, $filemanageroptions);

            $options = array(
                '0' => 'Video popup',
                '1' => 'Link',
                '2' => 'None',
            );
            $select = $mform->addElement('select', 'config_button_type_' .$i , get_string('config_button_type', 'theme_edumy'), $options, array('class'=>'ccnCommLcRef_change'));
            $select->setSelected('0');

            $mform->addElement('text', 'config_video_' . $i, get_string('config_video', 'theme_edumy', $i));
            $mform->hideIf('config_video_' .$i , 'config_button_type_' . $i, 'neq', '0');
            $mform->setDefault('config_video_' .$i , 'https://www.youtube.com/watch?v=UdDwKI4DcGw');
            $mform->setType('config_video_' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_subtitle_' . $i, get_string('config_button_text', 'theme_edumy', $i));
            $mform->hideIf('config_subtitle_' .$i , 'config_button_type_' . $i, 'neq', '0');
            $mform->setDefault('config_subtitle_' .$i , 'Watch our video');
            $mform->setType('config_subtitle_' . $i, PARAM_TEXT);
            $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                        'subdirs'       => 0,
                                        'maxfiles'      => 1,
                                        'accepted_types' => array('.jpg', '.png', '.gif'));

          $mform->addElement('text', 'config_button_text_' . $i, get_string('config_button_text', 'theme_edumy', $i));
          $mform->hideIf('config_button_text_' .$i , 'config_button_type_' . $i, 'neq', '1');
          $mform->setDefault('config_button_text_' .$i , 'Learn more');
          $mform->setType('config_button_text_' . $i, PARAM_TEXT);

          $mform->addElement('text', 'config_button_link_' . $i, get_string('config_button_link', 'theme_edumy', $i));
          $mform->hideIf('config_button_link_' .$i , 'config_button_type_' . $i, 'neq', '1');
          $mform->setDefault('config_button_link_' .$i , '#');
          $mform->setType('config_button_link_' . $i, PARAM_TEXT);



        }

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit/edit_ccn_carousel.php');
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }

    function set_data($defaults) {
        if (!empty($this->block->config) && is_object($this->block->config)) {

            for($i = 1; $i <= $this->block->config->slidesnumber; $i++) {
                $field = 'image_' . $i;
                $conffield = 'config_image_' . $i;
                $draftitemid = file_get_submitted_draft_itemid($conffield);
                file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_slider_7', 'slides', $i, array('subdirs'=>false));
                $defaults->$conffield['itemid'] = $draftitemid;
                $this->block->config->$field = $draftitemid;
            }
        }

        parent::set_data($defaults);
    }
}
