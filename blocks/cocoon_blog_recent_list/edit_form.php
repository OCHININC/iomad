<?php

class block_cocoon_blog_recent_list_edit_form extends block_edit_form {
    protected function specific_definition($mform) {

        global $CFG;

        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'block_cocoon_blog_recent_list'));
        $mform->setDefault('config_title', 'Recent Posts');
        $mform->setType('config_title', PARAM_RAW);

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }
}
