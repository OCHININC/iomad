<?php

defined('MOODLE_INTERNAL') || die();

class block_cocoon_courses_slider_edit_form extends block_edit_form {

    protected function specific_definition($mform) {
        global $CFG;

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Featured Courses');
        $mform->setType('config_title', PARAM_RAW);

        // Subtitle
        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'theme_edumy'));
        $mform->setDefault('config_subtitle', 'Cum doctus civibus efficiantur in imperdiet deterruisset.');
        $mform->setType('config_subtitle', PARAM_RAW);

        // Hover text
        $mform->addElement('text', 'config_hover_text', get_string('config_hover_text', 'block_cocoon_featuredcourses'));
        $mform->setDefault('config_hover_text', 'Preview Course');
        $mform->setType('config_hover_text', PARAM_RAW);

        // Hover accent
        $mform->addElement('text', 'config_hover_accent', get_string('config_hover_accent', 'block_cocoon_featuredcourses'));
        $mform->setDefault('config_hover_accent', 'Top Seller');
        $mform->setType('config_hover_accent', PARAM_RAW);

        $radioarray=array();
        $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Standard', 0, $attributes);
        $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Background', 1, $attributes);
        $mform->addGroup($radioarray, 'config_style', 'Style', array(' '), false);

        $options = array(
            '0' => 'Hidden',
            '1' => 'Visible',
        );
        $select = $mform->addElement('select', 'config_course_image', get_string('config_image', 'theme_edumy'), $options);
        $select->setSelected('1');

        // $options = array(
        //     '0' => 'Hidden',
        //     '1' => 'Visible',
        // );
        // $select = $mform->addElement('select', 'config_updated', get_string('config_updated', 'theme_edumy'), $options);
        // $select->setSelected('1');

        // $options = array(
        //     '0' => 'Hidden',
        //     '1' => 'Visible',
        // );
        // $select = $mform->addElement('select', 'config_rating', get_string('config_rating', 'theme_edumy'), $options);
        // $select->setSelected('1');

        $options = array(
            '0' => 'Hidden',
            '1' => 'Visible',
            '2' => 'Visible (max 50 characters)',
            '3' => 'Visible (max 100 characters)',
            '4' => 'Visible (max 150 characters)',
            '5' => 'Visible (max 200 characters)',
            '6' => 'Visible (max 350 characters)',
            '7' => 'Visible (max 500 characters)',
        );
        $select = $mform->addElement('select', 'config_description', get_string('config_description', 'theme_edumy'), $options);
        $select->setSelected('0');

        // $options = array(
        //     '0' => 'Hidden',
        //     '1' => 'Visible',
        // );
        // $select = $mform->addElement('select', 'config_enrolments', get_string('config_enrolments', 'theme_edumy'), $options);
        // $select->setSelected('1');

        // $options = array(
        //     '0' => 'Hidden',
        //     '1' => 'Visible',
        // );
        // $select = $mform->addElement('select', 'config_newsitems', get_string('config_newsitems', 'theme_edumy'), $options);
        // $select->setSelected('1');

        $options = array(
            '0' => 'Hidden',
            '1' => 'Visible',
        );
        $select = $mform->addElement('select', 'config_price', get_string('config_price', 'theme_edumy'), $options);
        $select->setSelected('1');

        $options = array(
            '0' => 'Hidden',
            '1' => 'Visible',
        );
        $select = $mform->addElement('select', 'config_enrol_btn', get_string('config_enrol_btn', 'theme_edumy'), $options);
        $select->setSelected('0');

        $mform->addElement('text', 'config_enrol_btn_text', get_string('config_enrol_btn_text', 'theme_edumy'));
        $mform->setDefault('config_enrol_btn_text', 'Buy Now');
        $mform->setType('config_enrol_btn_text', PARAM_RAW);

        // $mform->addElement('html', '<a class="btn btn-secondary mt20 mb30 " href="'.$CFG->wwwroot.'/blocks/cocoon_courses_slider/cocoon_courses_slider.php">Select Featured Courses</a>');

        $options = array(
            'multiple' => true,
            'noselectionstring' => get_string('select_from_dropdown_multiple', 'theme_edumy'),
        );
        $mform->addElement('course', 'config_courses', get_string('courses'), $options);

        // $mform->addElement('static', 'link',
        //                    get_string('editlink', 'block_cocoon_courses_slider',
        //                               $CFG->wwwroot.'/blocks/cocoon_courses_slider/cocoon_courses_slider.php'));

        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }
}
