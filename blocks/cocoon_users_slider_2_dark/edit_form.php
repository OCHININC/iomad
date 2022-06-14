<?php

class block_cocoon_users_slider_2_dark_edit_form extends block_edit_form {


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
     * Extends the configuration form for block_cocoon_users_slider_2_dark.
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
        $mform->addElement('autocomplete', 'config_users', get_string('cocoon_users_slider_2_dark_users', 'block_cocoon_users_slider_2_dark'), $usernames, [
        	'multiple' => true,
            'ajax' => 'tool_lp/form-user-selector',
        ]);
        $mform->addRule('config_users', null, 'required');

        $mform->addElement('header', 'config_ccn_colors', get_string('block_styles', 'theme_edumy'));

        $mform->addElement('text', 'config_color_bg', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_bg', 'rgb(0, 8, 70)');
        $mform->setType('config_color_bg', PARAM_TEXT);

        $mform->addElement('text', 'config_color_title', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_title', 'rgb(255,255,255)');
        $mform->setType('config_color_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_subtitle', get_string('config_color_subtitle', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_subtitle', 'rgb(255,255,255)');
        $mform->setType('config_color_subtitle', PARAM_TEXT);

        $mform->addElement('text', 'config_color_item_title', get_string('config_color_item_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_item_title', 'rgb(255,255,255)');
        $mform->setType('config_color_item_title', PARAM_TEXT);

        $mform->addElement('text', 'config_color_item_body', get_string('config_color_item_body', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_color_item_body', 'rgba(255, 255, 255, .6)');
        $mform->setType('config_color_item_body', PARAM_TEXT);

        // $mform->addElement('text', 'config_c_ccn_ic', get_string('config_c_ccn_ic', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        // $mform->setDefault('config_c_ccn_ic', 'rgb(22, 32, 90)');
        // $mform->setType('config_c_ccn_ic', PARAM_TEXT);
        //
        // $mform->addElement('text', 'config_c_ccn_i', get_string('config_icon_class', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        // $mform->setDefault('config_c_ccn_i', '#f0d078');
        // $mform->setType('config_c_ccn_i', PARAM_TEXT);

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }
}
