<?php

class block_cocoon_blog_recent_edit_form extends block_edit_form {
    protected function specific_definition($mform) {

        global $CFG;

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'block_cocoon_blog_recent'));
        $mform->setDefault('config_title', 'Latest News And Events');
        $mform->setType('config_title', PARAM_RAW);

        // Subtitle
        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'block_cocoon_blog_recent'));
        $mform->setDefault('config_subtitle', 'Cum doctus civibus efficiantur in imperdiet deterruisset.');
        $mform->setType('config_subtitle', PARAM_RAW);

        // Footer text
        $mform->addElement('text', 'config_footer_text', get_string('config_footer_text', 'theme_edumy'));
        $mform->setDefault('config_footer_text', 'Like what you see?');
        $mform->setType('config_footer_text', PARAM_RAW);

        $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edumy'));
        $mform->setDefault('config_button_text', 'See more posts');
        $mform->setType('config_button_text', PARAM_RAW);

        $mform->addElement('text', 'config_button_link', get_string('config_button_link', 'theme_edumy'));
        $mform->setDefault('config_button_link', '/blog/index.php');
        $mform->setType('config_button_link', PARAM_RAW);

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }
}
