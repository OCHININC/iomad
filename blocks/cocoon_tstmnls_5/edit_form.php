<?php

class block_cocoon_tstmnls_5_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG;

        if (!empty($this->block->config) && is_object($this->block->config)) {
            $data = $this->block->config;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 5;
        }


        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'What People Say');
        $mform->setType('config_title', PARAM_TEXT);

        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_subtitle', 'Cum doctus civibus efficiantur in imperdiet deterruisset.');
        $mform->setType('config_subtitle', PARAM_TEXT);


        // $options = array(
        //   '0' => 'Style 1',
        //   '1' => 'Style 2',
        //   '2' => 'Style 3',
        // );
        // $select = $mform->addElement('select', 'config_style', get_string('config_style', 'theme_edumy'), $options);
        // $select->setSelected('0');

        // $radioarray=array();
        // $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Style 1', 0, $attributes);
        // $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Style 2', 1, $attributes);
        // $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Style 3', 2, $attributes);
        // $mform->addGroup($radioarray, 'config_style', 'Style', array(' '), false);

        // $options = array(
        //     'true' => 'True',
        //     'false' => 'False',
        // );
        // $select = $mform->addElement('select', 'config_autoplay', get_string('config_autoplay', 'theme_edumy'), $options);
        // $select->setSelected('true');
        //
        // $options = array(
        //     '2000' => '2000ms',
        //     '3000' => '3000ms',
        //     '4000' => '4000ms',
        //     '5000' => '5000ms',
        //     '6000' => '6000ms',
        //     '7000' => '7000ms',
        //     '8000' => '8000ms',
        //     '9000' => '9000ms',
        //     '10000' => '10s',
        //     '15000' => '15s',
        //     '20000' => '20s',
        // );
        // $select = $mform->addElement('select', 'config_speed', get_string('config_speed', 'theme_edumy'), $options);
        // $select->setSelected('2000');
        //
        // $options = array(
        //     'true' => 'True',
        //     'false' => 'False',
        // );
        // $select = $mform->addElement('select', 'config_loop', get_string('config_loop', 'theme_edumy'), $options);
        // $select->setSelected('true');

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
          13 => '13',
          14 => '14',
          15 => '15',
          16 => '16',
          17 => '17',
          18 => '18',
          19 => '19',
          20 => '20',
          21 => '21',
          22 => '22',
          23 => '23',
          24 => '24',
          25 => '25',
          26 => '26',
          27 => '27',
          28 => '28',
          29 => '29',
          30 => '30',
          31 => '31',
          32 => '32',
          33 => '33',
          34 => '34',
          35 => '35',
          36 => '36',
          37 => '37',
          38 => '38',
          39 => '39',
          40 => '40',
          41 => '41',
          42 => '42',
          43 => '43',
          44 => '44',
          45 => '45',
          46 => '46',
          47 => '47',
          48 => '48',
          49 => '49',
          50 => '50',
        );

        $slidesmax = 50;
        $mform->addElement('select', 'config_slidesnumber', get_string('config_items', 'theme_edumy'), $slidesrange);
        $mform->setDefault('config_slidesnumber', 5);

        for($i = 1; $i <= $slidesmax; $i++) {
            $mform->addElement('header', 'config_ccn_item' . $i , get_string('config_item', 'theme_edumy') . $i);

            $mform->addElement('text', 'config_slide_title' . $i, get_string('config_title', 'theme_edumy', $i));
            $mform->setDefault('config_slide_title' . $i, 'Ali Tufan');
            $mform->setType('config_slide_title' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_slide_subtitle' . $i, get_string('config_subtitle', 'theme_edumy', $i));
            $mform->setDefault('config_slide_subtitle' . $i, 'Client');
            $mform->setType('config_slide_subtitle' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_slide_text' . $i, get_string('config_text', 'theme_edumy', $i));
            $mform->setDefault('config_slide_text' . $i, 'Customization is very easy with this theme. Clean and quality design and full support for any kind of request! Great theme!');
            $mform->setType('config_slide_text' . $i, PARAM_TEXT);


            $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                        'subdirs'       => 0,
                                        'maxfiles'      => 1,
                                        'accepted_types' => array('.jpg', '.png', '.gif'));

            $f = $mform->addElement('filemanager', 'config_file_slide' . $i, get_string('config_image', 'theme_edumy', $i), null, $filemanageroptions);
        }

        $mform->addElement('header', 'config_ccn_colors', get_string('block_styles', 'theme_edumy'));

        $mform->addElement('text', 'config_color_bg', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_bg', '#0067da');
        $mform->setType('config_color_bg', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title', '#203367');
        $mform->setType('config_color_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_subtitle', get_string('config_color_subtitle', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_subtitle', '#6f7074');
        $mform->setType('config_color_subtitle', PARAM_TEXT);

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }

    function set_data($defaults) {
        if (!empty($this->block->config) && is_object($this->block->config)) {

            for($i = 1; $i <= $this->block->config->slidesnumber; $i++) {
                $field = 'file_slide' . $i;
                $conffield = 'config_file_slide' . $i;
                $draftitemid = file_get_submitted_draft_itemid($conffield);
                file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_tstmnls_5', 'slides', $i, array('subdirs'=>false));
                $defaults->$conffield['itemid'] = $draftitemid;
                $this->block->config->$field = $draftitemid;
            }
        }

        parent::set_data($defaults);
    }
}
