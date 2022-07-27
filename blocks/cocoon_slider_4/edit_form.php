<?php

class block_cocoon_slider_4_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG;

        if (!empty($this->block->config) && is_object($this->block->config)) {
            $data = $this->block->config;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 3;
        }


        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Image
        $mform->addElement('filemanager', 'config_image', get_string('config_image', 'theme_edumy'), null,
                array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 1,
                'accepted_types' => array('.png', '.jpg', '.gif') ));

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
        $mform->setDefault('config_slidesnumber', 3);

        for($i = 1; $i <= $slidesmax; $i++) {
            $mform->addElement('header', 'config_ccn_item' . $i , 'Slide ' . $i);

            $mform->addElement('text', 'config_slide_title' . $i, get_string('config_title', 'theme_edumy', $i));
            $mform->setDefault('config_slide_title' .$i , 'We Can');
            $mform->setType('config_slide_title' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_slide_title_2' . $i, get_string('config_title_2', 'theme_edumy', $i));
            $mform->setDefault('config_slide_title_2' .$i , 'Teach You!');
            $mform->setType('config_slide_title_2' . $i, PARAM_TEXT);

            $options = array(
                '0' => 'No',
                '1' => 'Yes',
            );
            $select = $mform->addElement('select', 'config_slide_line_break' . $i, get_string('config_title', 'theme_edumy') . ' ' . strtolower(get_string('config_line_break', 'theme_edumy')), $options);
            $select->setSelected('0');

            $mform->addElement('text', 'config_slide_subtitle' . $i, get_string('config_subtitle', 'theme_edumy', $i));
            $mform->setDefault('config_slide_subtitle' .$i , 'Technology is brining a massive wave of evolution on learning things on different ways.');
            $mform->setType('config_slide_subtitle' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_slide_btn_text' . $i, get_string('config_button_text', 'theme_edumy', $i));
            $mform->setDefault('config_slide_btn_text' .$i , 'Join In Free');
            $mform->setType('config_slide_btn_text' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_slide_btn_url' . $i, get_string('config_button_link', 'theme_edumy', $i));
            $mform->setDefault('config_slide_btn_url' .$i , '#');
            $mform->setType('config_slide_btn_url' . $i, PARAM_TEXT);

            $options = array(
                '_self' => 'Self (open in same window)',
                '_blank' => 'Blank (open in new window)',
                '_parent' => 'Parent (open in parent frame)',
                '_top' => 'Top (open in full body of the window)',
            );
            $select = $mform->addElement('select', 'config_slide_btn_target' . $i, get_string('config_button_target', 'theme_edumy'), $options);
            $select->setSelected('_self');

            $mform->addElement('text', 'config_color_title_' . $i, get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_title_' . $i, '#0a0a0a');
            $mform->setType('config_color_title_' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_color_title_2_' . $i, get_string('config_color_title', 'theme_edumy').' 2', array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_title_2_' . $i, '#2441e7');
            $mform->setType('config_color_title_2_' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_color_body_' . $i, get_string('config_color_body', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_body_' . $i, '#6f7074');
            $mform->setType('config_color_body_' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_color_btn_' . $i, get_string('config_color_btn', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_btn_' . $i, '#0a0a0a');
            $mform->setType('config_color_btn_' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_color_btn_hover_' . $i, get_string('config_color_btn', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_btn_hover_' . $i, '#fff');
            $mform->setType('config_color_btn_hover_' . $i, PARAM_TEXT);


        }

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit/edit_ccn_carousel.php');
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }

    function set_data($defaults) {

        // Begin CCN Image Processing
        if (empty($entry->id)) {
            $entry = new stdClass;
            $entry->id = null;
        }
        $draftitemid = file_get_submitted_draft_itemid('config_image');
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_slider_4', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_slider_4', 'content', 0,
                array('subdirs' => true));
        }
        // END CCN Image Processing

        parent::set_data($defaults);
    }
}
