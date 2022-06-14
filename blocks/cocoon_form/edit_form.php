<?php

class block_cocoon_form_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
        global $USER, $DB, $CFG;
        $ccnFontList = include($CFG->dirroot . '/theme/edumy/ccn/font_handler/ccn_font_select.php');
        if (!empty($this->block->config) && is_object($this->block->config)) {
            $ccnStorage = $this->block->config;
        }

        $sql = "SELECT * FROM {cocoon_form_builder_forms}" ;
        $forms = $DB->get_records_sql($sql);

        $options = array();
        foreach ($forms as $form) {
        	 $options[$form->id] = $form->title;
        }

        if(count($options) > 0){
          $select = $mform->addElement('select', 'config_form', get_string('config_title', 'block_cocoon_form'), $options);
          $select->setSelected('0');
        } else {
          $mform->addElement('html', '<div class="alert alert-warning">No forms currently exist. <a href="'.$CFG->wwwroot.'/local/cocoon_form_builder/manage.php?page=add">Create a form?</a></div>');
        }
    }
}
