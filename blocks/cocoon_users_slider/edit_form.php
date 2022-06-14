<?php

class block_cocoon_users_slider_edit_form extends block_edit_form {


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
     * Extends the configuration form for block_cocoon_users_slider.
     */
    protected function specific_definition($mform)
    {

        global $CFG;

        // Section header title.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Please keep in mind that all elements defined here must start with 'config_'.
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setType('config_title', PARAM_TEXT);

        $usernames = $this->get_users();
        $mform->addElement('autocomplete', 'config_users', get_string('config_users', 'theme_edumy'), $usernames, [
        	'multiple' => true,
            'ajax' => 'tool_lp/form-user-selector',
        ]);
        $mform->addRule('config_users', null, 'required');

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }
}
