<?php

defined('MOODLE_INTERNAL') || die();

class block_cocoon_featured_teacher_edit_form extends block_edit_form {

  private function get_users() {
      global $DB, $OUTPUT, $PAGE;

      $usernames = [];

      if(empty($this->block->config->user)) return [];
      $ids = $this->block->config->user;

      list($uids, $params) = $DB->get_in_or_equal($ids);
      $rs = $DB->get_recordset_select('user', 'id ' . $uids, $params, '', 'id,firstname,lastname,email');

      foreach ($rs as $record)
      {
          $usernames[$record->id] = fullname($record) . ' ' . $record->email;
      }
      $rs->close();

      return $usernames;
    }

    protected function specific_definition($mform) {
        global $CFG;

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Teacher of Week');
        $mform->setType('config_title', PARAM_RAW);

        // Courses title
        $mform->addElement('text', 'config_courses_title', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_courses_title', 'Teacher Courses');
        $mform->setType('config_courses_title', PARAM_RAW);

        // Body
        $mform->addElement('textarea', 'config_body', get_string('config_body', 'theme_edumy'));
        $mform->setDefault('config_body', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.');
        $mform->setType('config_body', PARAM_RAW);

        // User
        $usernames = $this->get_users();
        $mform->addElement('autocomplete', 'config_user', get_string('config_teacher', 'theme_edumy'), $usernames, [
        	'multiple' => false,
            'ajax' => 'tool_lp/form-user-selector',
        ]);
        $mform->addRule('config_user', null, 'required');

        // Image
        // $mform->addElement('filemanager', 'config_image', get_string('config_image', 'theme_edumy'), null,
        //         array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 1,
        //         'accepted_types' => array('.png', '.jpg', '.gif') ));

        // Button Text
        // $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edumy'));
        // $mform->setDefault('config_button_text', 'View all courses');
        // $mform->setType('config_button_text', PARAM_RAW);
        //
        // // Button Link
        // $mform->addElement('text', 'config_button_link', get_string('config_button_link', 'theme_edumy'));
        // $mform->setDefault('config_button_link', '#');
        // $mform->setType('config_button_link', PARAM_RAW);

        // Hover text
        $mform->addElement('text', 'config_hover_text', get_string('config_hover_text', 'theme_edumy'));
        $mform->setDefault('config_hover_text', 'Preview Course');
        $mform->setType('config_hover_text', PARAM_RAW);

        // Hover accent
        $mform->addElement('text', 'config_hover_accent', get_string('config_hover_accent', 'theme_edumy'));
        $mform->setDefault('config_hover_accent', 'Top Seller');
        $mform->setType('config_hover_accent', PARAM_RAW);

        $options = array(
            '0' => 'Hidden',
            '1' => 'Visible',
        );
        $select = $mform->addElement('select', 'config_course_image', get_string('config_image', 'theme_edumy'), $options);
        $select->setSelected('1');

        // $options = array(
        //     '0' => 'Hidden',
        //     '1' => 'Visible',
        // );
        // $select = $mform->addElement('select', 'config_updated', get_string('config_updated', 'theme_edumy'), $options);
        // $select->setSelected('1');

        // $options = array(
        //     '0' => 'Hidden',
        //     '1' => 'Visible',
        // );
        // $select = $mform->addElement('select', 'config_rating', get_string('config_rating', 'theme_edumy'), $options);
        // $select->setSelected('1');

        $options = array(
            '0' => 'Hidden',
            '1' => 'Visible',
            '2' => 'Visible (max 50 characters)',
            '3' => 'Visible (max 100 characters)',
            '4' => 'Visible (max 150 characters)',
            '5' => 'Visible (max 200 characters)',
            '6' => 'Visible (max 350 characters)',
            '7' => 'Visible (max 500 characters)',
        );
        $select = $mform->addElement('select', 'config_description', get_string('config_description', 'theme_edumy'), $options);
        $select->setSelected('0');

        // $options = array(
        //     '0' => 'Hidden',
        //     '1' => 'Visible',
        // );
        // $select = $mform->addElement('select', 'config_enrolments', get_string('config_enrolments', 'theme_edumy'), $options);
        // $select->setSelected('1');

        // $options = array(
        //     '0' => 'Hidden',
        //     '1' => 'Visible',
        // );
        // $select = $mform->addElement('select', 'config_newsitems', get_string('config_newsitems', 'theme_edumy'), $options);
        // $select->setSelected('1');

        $options = array(
            '0' => 'Hidden',
            '1' => 'Visible',
        );
        $select = $mform->addElement('select', 'config_price', get_string('config_price', 'theme_edumy'), $options);
        $select->setSelected('1');

        $options = array(
            '0' => 'Hidden',
            '1' => 'Visible',
        );
        $select = $mform->addElement('select', 'config_enrol_btn', get_string('config_enrol_btn', 'theme_edumy'), $options);
        $select->setSelected('0');

        $mform->addElement('text', 'config_enrol_btn_text', get_string('config_enrol_btn_text', 'theme_edumy'));
        $mform->setDefault('config_enrol_btn_text', 'Buy Now');
        $mform->setType('config_enrol_btn_text', PARAM_RAW);

        for($i = 1; $i <= 2; $i++) {
          if($i == 1) {
            $title = "Background image";
          } elseif($i == 2){
            $title = "Teacher image";
          }
          $mform->addElement('header', 'config_header' . $i , $title);

          $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                      'subdirs'       => 0,
                                      'maxfiles'      => 1,
                                      'accepted_types' => array('.jpg', '.png', '.gif'));

          $f = $mform->addElement('filemanager', 'config_image' . $i, get_string('config_image', 'theme_edumy', $i), null, $filemanageroptions);
        }

        $mform->addElement('header', 'config_ccn_colors', get_string('block_styles', 'theme_edumy'));

        $mform->addElement('text', 'config_color_bfbg', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_bfbg', 'rgba(94, 94, 94, 0)');
        $mform->setType('config_color_bfbg', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title', 'rgba(255,255,255,.051)');
        $mform->setType('config_color_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_subtitle', get_string('config_color_subtitle', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_subtitle', '#fff');
        $mform->setType('config_color_subtitle', PARAM_TEXT);

        $mform->addElement('text', 'config_color_course_card', get_string('config_color_course_card', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_course_card', 'rgb(255, 255, 255)');
        $mform->setType('config_color_course_card', PARAM_TEXT);

        $mform->addElement('text', 'config_color_course_title', get_string('config_color_course_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_course_title', '#0a0a0a');
        $mform->setType('config_color_course_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_course_price', get_string('config_color_course_price', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_course_price', 'rgb(199, 85, 51)');
        $mform->setType('config_color_course_price', PARAM_TEXT);

        $mform->addElement('text', 'config_color_course_enrol_btn', get_string('config_color_course_enrol_btn', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_course_enrol_btn', '#79b530');
        $mform->setType('config_color_course_enrol_btn', PARAM_TEXT);

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');
    }


    function set_data($defaults) {
      if (!empty($this->block->config) && is_object($this->block->config)) {
        for($i = 1; $i <= 2; $i++) {
          $field = 'image' . $i;
          $config_field = 'config_image' . $i;
          $draftitemid = file_get_submitted_draft_itemid($config_field);
          file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_featured_teacher', 'images', $i, array('subdirs'=>false));
          $defaults->$config_field['itemid'] = $draftitemid;
          $this->block->config->$field = $draftitemid;
        }
      }
      parent::set_data($defaults);
    }
}
