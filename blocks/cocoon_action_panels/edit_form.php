<?php

class block_cocoon_action_panels_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;

        // Panel Left
        $mform->addElement('header', 'config_panel_1', 'Panel Left');

        $mform->addElement('text', 'config_panel_1_title', get_string('config_panel_1_title', 'block_cocoon_action_panels'));
        $mform->setDefault('config_panel_1_title', 'Become an Instructor');
        $mform->setType('config_panel_1_title', PARAM_RAW);

        $mform->addElement('text', 'config_panel_1_text', get_string('config_panel_1_text', 'block_cocoon_action_panels'));
        $mform->setDefault('config_panel_1_text', 'Teach what you love. Dove Schooll gives you the tools to create an online course.');
        $mform->setType('config_panel_1_text', PARAM_RAW);

        $mform->addElement('text', 'config_panel_1_button_text', get_string('config_panel_1_button_text', 'block_cocoon_action_panels'));
        $mform->setDefault('config_panel_1_button_text', 'Start Teaching');
        $mform->setType('config_panel_1_button_text', PARAM_RAW);

        $mform->addElement('text', 'config_panel_1_button_url', get_string('config_panel_1_button_url', 'block_cocoon_action_panels'));
        $mform->setDefault('config_panel_1_button_url', '#');
        $mform->setType('config_panel_1_button_url', PARAM_RAW);

        $options = array(
            '_self' => 'Self (open in same window)',
            '_blank' => 'Blank (open in new window)',
            '_parent' => 'Parent (open in parent frame)',
            '_top' => 'Top (open in full body of the window)',
        );
        $select = $mform->addElement('select', 'config_panel_1_button_target', get_string('config_button_target', 'theme_edumy'), $options);
        $select->setSelected('_self');

        $mform->addElement('text', 'config_panel_1_color_bg', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_panel_1_color_bg', '#f9f9f9');
        $mform->setType('config_panel_1_color_bg', PARAM_TEXT);

        $mform->addElement('text', 'config_panel_1_color_title', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_panel_1_color_title', '#0a0a0a');
        $mform->setType('config_panel_1_color_title', PARAM_TEXT);

        $mform->addElement('text', 'config_panel_1_color_body', get_string('config_color_body', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_panel_1_color_body', '#6f7074');
        $mform->setType('config_panel_1_color_body', PARAM_TEXT);

        $mform->addElement('text', 'config_panel_1_color_btn', get_string('config_color_btn', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_panel_1_color_btn', '#2441e7');
        $mform->setType('config_panel_1_color_btn', PARAM_TEXT);

        $mform->addElement('text', 'config_panel_1_color_btn_hover', get_string('config_color_btn', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_panel_1_color_btn_hover', '#2441e7');
        $mform->setType('config_panel_1_color_btn_hover', PARAM_TEXT);

        // Panel Right
        $mform->addElement('header', 'config_panel_2', 'Panel Right');

        $mform->addElement('text', 'config_panel_2_title', get_string('config_panel_2_title', 'block_cocoon_action_panels'));
        $mform->setDefault('config_panel_2_title', 'Dove School For Business');
        $mform->setType('config_panel_2_title', PARAM_RAW);

        $mform->addElement('text', 'config_panel_2_text', get_string('config_panel_2_text', 'block_cocoon_action_panels'));
        $mform->setDefault('config_panel_2_text', 'Get unlimited access to 2,500 of Edumy\'s top courses for your team.');
        $mform->setType('config_panel_2_text', PARAM_RAW);

        $mform->addElement('text', 'config_panel_2_button_text', get_string('config_panel_2_button_text', 'block_cocoon_action_panels'));
        $mform->setDefault('config_panel_2_button_text', 'Doing Business');
        $mform->setType('config_panel_2_button_text', PARAM_RAW);

        $mform->addElement('text', 'config_panel_2_button_url', get_string('config_panel_2_button_url', 'block_cocoon_action_panels'));
        $mform->setDefault('config_panel_2_button_url', '#');
        $mform->setType('config_panel_2_button_url', PARAM_RAW);

        $options = array(
            '_self' => 'Self (open in same window)',
            '_blank' => 'Blank (open in new window)',
            '_parent' => 'Parent (open in parent frame)',
            '_top' => 'Top (open in full body of the window)',
        );
        $select = $mform->addElement('select', 'config_panel_2_button_target', get_string('config_button_target', 'theme_edumy'), $options);
        $select->setSelected('_self');

        $mform->addElement('text', 'config_panel_2_color_bg', get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_panel_2_color_bg', '#f9f9f9');
        $mform->setType('config_panel_2_color_bg', PARAM_TEXT);

        $mform->addElement('text', 'config_panel_2_color_title', get_string('config_color_title', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_panel_2_color_title', '#0a0a0a');
        $mform->setType('config_panel_2_color_title', PARAM_TEXT);

        $mform->addElement('text', 'config_panel_2_color_body', get_string('config_color_body', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_panel_2_color_body', '#6f7074');
        $mform->setType('config_panel_2_color_body', PARAM_TEXT);

        $mform->addElement('text', 'config_panel_2_color_btn', get_string('config_color_btn', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_panel_2_color_btn', '#051925');
        $mform->setType('config_panel_2_color_btn', PARAM_TEXT);

        $mform->addElement('text', 'config_panel_2_color_btn_hover', get_string('config_color_btn', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
        $mform->setDefault('config_panel_2_color_btn_hover', '#051925');
        $mform->setType('config_panel_2_color_btn_hover', PARAM_TEXT);

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }
}
