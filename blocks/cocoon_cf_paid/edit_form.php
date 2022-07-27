<?php

class block_cocoon_cf_paid_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;
        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Category Filter');
        $mform->setType('config_title', PARAM_RAW);

        $options = array(
            '0' => 'Never',
            '1' => 'While viewing parent category',
            '2' => 'Always',
        );
        $select = $mform->addElement('select', 'config_child_categories', get_string('config_child_categories', 'theme_edumy'), $options);
        $select->setSelected('0');


        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }

}
