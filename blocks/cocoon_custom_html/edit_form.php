<?php

class block_cocoon_custom_html_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;
        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'My Custom Block');
        $mform->setType('config_title', PARAM_RAW);

        // Description
        $mform->addElement('editor', 'config_body', get_string('config_body', 'theme_edumy'));
        $mform->setType('config_body', PARAM_RAW);

        $radioarray=array();
        $radioarray[] = $mform->createElement('radio', 'config_style', '', 'No Style', 0, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Border', 1, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Box Shadow', 2, $attributes);
        $mform->addGroup($radioarray, 'config_style', 'Style', array(' '), false);

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');
    }

}
