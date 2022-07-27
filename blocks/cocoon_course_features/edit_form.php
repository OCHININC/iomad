<?php

class block_cocoon_course_features_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {

        global $CFG;

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'block_cocoon_course_features'));
        $mform->setDefault('config_title', 'Course Features');
        $mform->setType('config_title', PARAM_RAW);

        // Lectures
        $mform->addElement('text', 'config_lectures', get_string('config_lectures', 'block_cocoon_course_features'));
        $mform->setDefault('config_lectures', '6');
        $mform->setType('config_lectures', PARAM_RAW);

        // Quizzes
        $mform->addElement('text', 'config_quizzes', get_string('config_quizzes', 'block_cocoon_course_features'));
        $mform->setDefault('config_quizzes', '1');
        $mform->setType('config_quizzes', PARAM_RAW);

        // Duration
        $mform->addElement('text', 'config_duration', get_string('config_duration', 'block_cocoon_course_features'));
        $mform->setDefault('config_duration', '3 hours');
        $mform->setType('config_duration', PARAM_RAW);

        // Skill level
        $mform->addElement('text', 'config_skill_level', get_string('config_skill_level', 'block_cocoon_course_features'));
        $mform->setDefault('config_skill_level', 'All level');
        $mform->setType('config_skill_level', PARAM_RAW);

        // Language
        $mform->addElement('text', 'config_language', get_string('config_language', 'block_cocoon_course_features'));
        $mform->setDefault('config_language', 'English');
        $mform->setType('config_language', PARAM_RAW);

        // Assessments
        $mform->addElement('text', 'config_assessments', get_string('config_assessments', 'block_cocoon_course_features'));
        $mform->setDefault('config_assessments', 'Yes');
        $mform->setType('config_assessments', PARAM_RAW);

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }
}
