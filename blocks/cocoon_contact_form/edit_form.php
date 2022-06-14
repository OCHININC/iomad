<?php

class block_cocoon_contact_form_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
        global $CFG, $DB;
        $ccnFontList = include($CFG->dirroot . '/theme/edumy/ccn/font_handler/ccn_font_select.php');
        if (!empty($this->block->config) && is_object($this->block->config)) {
            $ccnStorage = $this->block->config;
        } else {
            $ccnStorage = new stdClass();
            $ccnStorage->items = 3;
        }

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $options = array(
            '0' => 'Contact form and map',
            '1' => 'Contact form and image',
            '2' => 'Contact form only',
        );
        $select = $mform->addElement('select', 'config_style', get_string('config_style', 'theme_edumy'), $options, array('class'=>'ccnCommLcRef_change'));
        $select->setSelected('0');

        $ccnItemsRange = array(
          0 => '0',
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

        $ccnItemsMax = 12;

        $mform->addElement('select', 'config_items', get_string('config_items', 'theme_edumy'), $ccnItemsRange, array('class'=>'ccnCommLcRef_change'));
        $mform->setDefault('config_items', 3);

        for($i = 1; $i <= $ccnItemsMax; $i++) {
            $mform->addElement('header', 'config_ccn_item'.$i , get_string('config_item', 'theme_edumy') . $i);

            $mform->addElement('text', 'config_title_'.$i, get_string('config_title', 'theme_edumy', $i));
            $mform->setDefault('config_title_'.$i, 'Our Email');
            $mform->setType('config_title_'.$i, PARAM_TEXT);

            $mform->addElement('textarea', 'config_subtitle_'.$i, get_string('config_body', 'theme_edumy', $i));
            $mform->setDefault('config_subtitle_'.$i , 'info@edumy.com');
            $mform->setType('config_subtitle_'.$i, PARAM_RAW);

            $select = $mform->addElement('select', 'config_icon_'.$i, get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
            $select->setSelected('flaticon-email');

        }

        // Contact Form
        $mform->addElement('header', 'config_header_4', 'Contact form');

        $mform->addElement('text', 'config_title', get_string('config_title', 'block_cocoon_contact_form'));
        $mform->setDefault('config_title', 'Send a Message');
        $mform->setType('config_title', PARAM_RAW);

        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'block_cocoon_contact_form'));
        $mform->setDefault('config_subtitle', 'Ex quem dicta delicata usu, zril vocibus maiestatis in qui.');
        $mform->setType('config_subtitle', PARAM_RAW);

        $options = array(
            '0' => 'Display reCAPTCHA to guests',
            '1' => 'Display reCAPTCHA to all users',
            '2' => 'Do not display reCAPTCHA',
        );
        $select = $mform->addElement('select', 'config_recaptcha', get_string('config_recaptcha', 'theme_edumy'), $options);
        $select->setSelected('0');

        // $sql = "SELECT * FROM {cocoon_form_builder_forms}" ;
        // $forms = $DB->get_records_sql($sql);
        //
        // $options = array();
        // foreach ($forms as $form) {
        // 	 $options[$form->id] = $form->title;
        // }
        //
        // if(count($options) > 0){
        //   $select = $mform->addElement('select', 'config_form', get_string('config_title', 'block_cocoon_form'), $options);
        //   $select->setSelected('0');
        // } else {
        //   $mform->addElement('html', '<div class="alert alert-warning">No forms currently exist. <a href="'.$CFG->wwwroot.'/local/cocoon_form_builder/manage.php?page=add">Create a form?</a></div>');
        // }

        // Google Map
        $mform->addElement('header', 'config_header_5', 'Google map');

        $mform->addElement('text', 'config_map_lat', get_string('config_map_lat', 'block_cocoon_contact_form'));
        $mform->setDefault('config_map_lat', '40.6946703');
        $mform->setType('config_map_lat', PARAM_RAW);

        $mform->addElement('text', 'config_map_lng', get_string('config_map_lng', 'block_cocoon_contact_form'));
        $mform->setDefault('config_map_lng', '-73.9280182');
        $mform->setType('config_map_lng', PARAM_RAW);

        $mform->addElement('text', 'config_map_address', get_string('address_line_1', 'theme_edumy'));
        $mform->setDefault('config_map_address', 'Trafalgar Square, London');
        $mform->setType('config_map_address', PARAM_RAW);

        $range = range(1, 20);
        $mform->addElement('select', 'config_zoom', get_string('config_zoom', 'theme_edumy'), $range);
        $mform->setDefault('config_zoom', '11');

        $radioarray=array();
        $radioarray[] = $mform->createElement('radio', 'config_map_style', '', 'Edumy Default', 0, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_map_style', '', 'Roadmap', 1, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_map_style', '', 'Satellite', 2, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_map_style', '', 'Hybrid', 3, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_map_style', '', 'Terrain', 4, $attributes);
        $mform->addGroup($radioarray, 'config_map_style', 'Style', array(' '), false);

        for($i = 1; $i <= 2; $i++) {
          if($i == 1) {
            $title = "Content image";
          } elseif($i == 2){
            $title = "Map marker image";
          }
            $mform->addElement('header', 'config_header' . $i , $title);

            $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                        'subdirs'       => 0,
                                        'maxfiles'      => 1,
                                        'accepted_types' => array('.jpg', '.png', '.gif'));

            $f = $mform->addElement('filemanager', 'config_image' . $i, get_string('config_image', 'block_cocoon_contact_form', $i), null, $filemanageroptions);
        }

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }

    function set_data($defaults)
    {
      if (!empty($this->block->config) && is_object($this->block->config)) {

          for($i = 1; $i <= 2; $i++) {
              $field = 'image' . $i;
              $config_field = 'config_image' . $i;
              $draftitemid = file_get_submitted_draft_itemid($config_field);
              file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_contact_form', 'images', $i, array('subdirs'=>false));
              $defaults->$config_field['itemid'] = $draftitemid;
              $this->block->config->$field = $draftitemid;
          }
      }

      parent::set_data($defaults);
      if (!empty($this->block->config) && is_object($this->block->config)) {
          $text = $this->block->config->bio;
          $draftid_editor = file_get_submitted_draft_itemid('config_bio');
          if (empty($text)) {
              $currenttext = '';
          } else {
              $currenttext = $text;
          }
          $defaults->config_bio['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_contact_form', 'content', 0, array('subdirs'=>true), $currenttext);
          $defaults->config_bio['itemid'] = $draftid_editor;
          $defaults->config_bio['format'] = $this->block->config->format;
      } else {
          $text = '';
      }




    }
}
