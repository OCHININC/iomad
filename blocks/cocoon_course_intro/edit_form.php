<?php

class block_cocoon_course_intro_edit_form extends block_edit_form
{

  private function get_users()
  {
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

    protected function specific_definition($mform)
    {
      global $CFG;

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        $usernames = $this->get_users();
        $mform->addElement('autocomplete', 'config_user', get_string('config_teacher', 'theme_edumy'), $usernames, [
        	'multiple' => false,
            'ajax' => 'tool_lp/form-user-selector',
        ]);
        $mform->addRule('config_user', null, 'required');

        $options = array(
            '0' => 'Hidden',
            '1' => 'Visible',
        );
        $select = $mform->addElement('select', 'config_show_teacher', get_string('config_teacher', 'theme_edumy'), $options);
        $select->setSelected('1');

        // $mform->addElement('text', 'config_video', get_string('config_video', 'block_cocoon_course_intro'));
        // $mform->setDefault('config_video', '//www.youtube.com/embed/57LQI8DKwec');
        // $mform->setType('config_video', PARAM_RAW);

        $mform->addElement('text', 'config_video_url', get_string('config_video', 'block_cocoon_course_intro'));
        $mform->setDefault('config_video_url', 'https://youtu.be/UdDwKI4DcGw');
        $mform->setType('config_video_url', PARAM_RAW);

        $mform->addElement('text', 'config_accent', get_string('config_accent', 'block_cocoon_course_intro'));
        $mform->setDefault('config_accent', 'Best Seller');
        $mform->setType('config_accent', PARAM_RAW);

        // Section header title according to language file.
        $mform->addElement('header', 'config_overrides', get_string('config_overrides', 'theme_edumy'));

        $mform->addElement('text', 'config_teacher', get_string('config_teacher', 'block_cocoon_course_intro'));
        $mform->setDefault('config_teacher', 'Ali Tufan');
        $mform->setType('config_teacher', PARAM_RAW);

        // Image
        $mform->addElement('filemanager', 'config_image', get_string('config_image', 'block_cocoon_course_intro'), null,
                array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 1,
                'accepted_types' => array('.png', '.jpg', '.gif') ));

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');
    }

    function set_data($defaults)
    {

        // Begin CCN Image Processing
        if (empty($entry->id)) {
            $entry = new stdClass;
            $entry->id = null;
        }
        $draftitemid = file_get_submitted_draft_itemid('config_image');
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_course_intro', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_course_intro', 'content', 0,
                array('subdirs' => true));
        }
        // END CCN Image Processing


    }
}
