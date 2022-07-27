<?php

class block_cocoon_users_slider_round_edit_form extends block_edit_form {


    private function get_users()
    {
        global $DB, $OUTPUT, $PAGE;

        $usernames = [];

        if(empty($this->block->config->users)) return [];
        $ids = $this->block->config->users;

        list($uids, $params) = $DB->get_in_or_equal($ids);
        $rs = $DB->get_recordset_select('user', 'id ' . $uids, $params, '', 'id,firstname,lastname,email');

        foreach ($rs as $record)
        {
            $usernames[$record->id] = fullname($record) . ' ' . $record->email;
        }
        $rs->close();

        return $usernames;
    }

    /**
     * Extends the configuration form for block_cocoon_users_slider_round.
     */
    protected function specific_definition($mform)
    {

        global $CFG;

        // Section header title.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Please keep in mind that all elements defined here must start with 'config_'.
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Top Rating Instructors');
        $mform->setType('config_title', PARAM_TEXT);

        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_subtitle', 'Cum doctus civibus efficiantur in imperdiet deterruisset.');
        $mform->setType('config_subtitle', PARAM_TEXT);

        $usernames = $this->get_users();
        $mform->addElement('autocomplete', 'config_users', get_string('cocoon_users_slider_round_users', 'block_cocoon_users_slider_round'), $usernames, [
        	'multiple' => true,
            'ajax' => 'tool_lp/form-user-selector',
        ]);
        $mform->addRule('config_users', null, 'required');

        $options = array(
          0 => 'Hide',
          1 => 'Display',
        );
        $select = $mform->addElement('select', 'config_profile_views', get_string('profile_views', 'theme_edumy'), $options, array('class'=>'ccnCommLcRef_change'));
        $select->setSelected('1');

        $mform->addElement('header', 'config_ccn_colors', get_string('block_styles', 'theme_edumy'));

        $mform->addElement('text', 'config_color_bg', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_bg', 'rgb(255,255,255)');
        $mform->setType('config_color_bg', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title', '#0a0a0a');
        $mform->setType('config_color_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_subtitle', get_string('config_color_subtitle', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_subtitle', '#6f7074');
        $mform->setType('config_color_subtitle', PARAM_TEXT);

        // @ccnTodo
        // $mform->addElement('text', 'config_color_owl_dots', get_string('config_color_owl_dots', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        // $mform->setDefault('config_color_owl_dots', '#debf52');
        // $mform->setType('config_color_owl_dots', PARAM_TEXT);

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }
}
