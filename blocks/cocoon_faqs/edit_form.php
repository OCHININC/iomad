<?php

class block_cocoon_faqs_edit_form extends block_edit_form {
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

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Frequently Asked Questions');
        $mform->setType('config_title', PARAM_RAW);

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
        );

        $slidesmax = 30;

        $mform->addElement('select', 'config_slidesnumber', get_string('config_items', 'theme_edumy'), $slidesrange);
        $mform->setDefault('config_slidesnumber', 4);



        for($i = 1; $i <= $slidesmax; $i++) {
            $mform->addElement('header', 'config_ccn_item' . $i , 'FAQ ' . $i);

            $mform->addElement('text', 'config_faq_title' . $i, get_string('config_faq_title', 'block_cocoon_faqs', $i));
            $mform->setDefault('config_faq_title' .$i , 'Why won\'t my payment go through?');
            $mform->setType('config_faq_title' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_faq_subtitle' . $i, get_string('config_faq_subtitle', 'block_cocoon_faqs', $i));
            $mform->setDefault('config_faq_subtitle' .$i , 'Course Description');
            $mform->setType('config_faq_subtitle' . $i, PARAM_TEXT);

            $options = array(
                '0' => 'Plain text',
                '1' => 'HTML editor',
            );
            $select = $mform->addElement('select', 'config_body_type' .$i, get_string('config_body_type', 'theme_edumy'), $options);
            $select->setSelected('0');


            $mform->addElement('textarea', 'config_faq_body' . $i, get_string('config_body_plain', 'theme_edumy', $i));
            $mform->disabledIf('config_faq_body' .$i, 'config_body_type' .$i, 'eq', 1);
            $mform->setDefault('config_faq_body' .$i , 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.');
            $mform->setType('config_faq_body' . $i, PARAM_TEXT);

            $editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'noclean'=>true, 'context'=>$this->block->context, 'subdirs' => 0);
            $mform->addElement('editor', 'config_faq_html' .$i , get_string('config_body_html', 'theme_edumy'), null, $editoroptions);
            $mform->disabledIf('config_faq_html' .$i , 'config_body_type' .$i, 'neq', 1);
            // $mform->setDefault('config_faq_html' .$i , 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.');
            $mform->setType('config_faq_html' . $i, PARAM_RAW); // XSS is prevented when printing the block contents and serving files


        }

        $mform->addElement('header', 'config_ccn_colors', get_string('block_styles', 'theme_edumy'));

        $mform->addElement('text', 'config_color_bg', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_bg', 'rgb(255,255,255)');
        $mform->setType('config_color_bg', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title', '#0a0a0a');
        $mform->setType('config_color_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_panel_bg', get_string('config_color_panel_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_panel_bg', '#edeff7');
        $mform->setType('config_color_panel_bg', PARAM_TEXT);

        $mform->addElement('text', 'config_color_panel_title', get_string('config_color_panel_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_panel_title', '#0a0a0a');
        $mform->setType('config_color_panel_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_panel_subtitle', get_string('config_color_panel_subtitle', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_panel_subtitle', '#3b3b3b');
        $mform->setType('config_color_panel_subtitle', PARAM_TEXT);

        $mform->addElement('text', 'config_color_panel_body', get_string('config_color_panel_body', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_panel_body', '#7e7e7e');
        $mform->setType('config_color_panel_body', PARAM_TEXT);


        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }

    function set_data($defaults) {
        if (!empty($this->block->config) && is_object($this->block->config)) {

            for($i = 1; $i <= $this->block->config->slidesnumber; $i++) {
                $field = 'file_slide' . $i;
                $conffield = 'config_file_slide' . $i;
                $draftitemid = file_get_submitted_draft_itemid($conffield);
                file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_faqs', 'slides', $i, array('subdirs'=>false));
                $defaults->$conffield['itemid'] = $draftitemid;
                $this->block->config->$field = $draftitemid;




                // if (!empty($this->block->config) && is_object($this->block->config)) {
                    $text = $this->block->config->faq_html . $i;
                    $conffield = 'config_faq_html' . $i;
                    $draftid_editor = file_get_submitted_draft_itemid($conffield);
                    if (empty($text)) {
                        $currenttext = '';
                    } else {
                        $currenttext = $text;
                    }
                    $defaults->$conffield['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_faqs', 'content', $i, array('subdirs'=>false), $currenttext);
                    $defaults->$conffield['itemid'] = $draftid_editor;
                    $defaults->$conffield['format'] = $this->block->config->format . $i ;
                // } else {
                //     $text = '';
                // }

            }
        }

        parent::set_data($defaults);
    }
}
