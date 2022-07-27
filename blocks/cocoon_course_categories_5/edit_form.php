<?php
require_once($CFG->dirroot.'/theme/edumy/ccn/course_handler/ccn_course_handler.php');
class block_cocoon_course_categories_5_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;
      $ccnFontList = include($CFG->dirroot . '/theme/edumy/ccn/font_handler/ccn_font_select.php');
      // include_once($CFG->dirroot . '/course/lib.php');
      // require_once($CFG->dirroot. '/course/renderer.php');
      // $topcategory = core_course_category::top();
      // $topcategorykids = $topcategory->get_children();
      // $searchareas = \core_search\manager::get_search_areas_list(true);
      // $areanames = array();
      // foreach ($topcategorykids as $areaid => $topcategorykids) {
      //     $areanames[$areaid] = $topcategorykids->get_formatted_name();
      //     // print_object($areaid->get_formatted_name());
      //     // print_object($areaid);
      //
      // }

      $ccnCourseHandler = new ccnCourseHandler();
      $ccnCourseCategories = $ccnCourseHandler->ccnListCategories();

      if (!empty($this->block->config) && is_object($this->block->config)) {
          $data = $this->block->config;
      } else {
          $data = new stdClass();
          $data->items = 5;
      }

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'block_cocoon_course_categories_5'));
        $mform->setDefault('config_title', 'Via School Categories Courses');
        $mform->setType('config_title', PARAM_RAW);

        // Subtitle
        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'block_cocoon_course_categories_5'));
        $mform->setDefault('config_subtitle', 'Cum doctus civibus efficiantur in imperdiet deterruisset.');
        $mform->setType('config_subtitle', PARAM_RAW);

        // Button Text
        $mform->addElement('text', 'config_button_text', get_string('config_button_text', 'theme_edumy'));
        $mform->setDefault('config_button_text', 'View All Courses');
        $mform->setType('config_button_text', PARAM_RAW);

        $options = array(
            '0' => 'Category description',
            '1' => 'Category course count',
        );
        $select = $mform->addElement('select', 'config_body', get_string('config_body', 'theme_edumy'), $options, array('class'=>'ccnCommLcRef_change'));
        $select->setSelected('0');

        $items_range = array(
          1 => '1',
          2 => '2',
          3 => '3',
          4 => '4',
          5 => '5',
          6 => '6',
          7 => '7',
          8 => '8',
          9 => '9',
          10 => '10',
        );

        $items_max = 50;

        $mform->addElement('select', 'config_items', get_string('config_items', 'theme_edumy'), $items_range);
        $mform->setDefault('config_items', 5);
        $mform->addRule('config_items', get_string('required'), 'required', null, 'client', false, false);

        // Style
        // $radioarray=array();
        // $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Hide arrow', 0, $attributes);
        // $radioarray[] = $mform->createElement('radio', 'config_style', '', 'Show arrow', 1, $attributes);
        // $mform->addGroup($radioarray, 'config_style', 'Arrow', array(' '), false);

        for($i = 1; $i <= $items_max; $i++) {
            $mform->addElement('header', 'config_ccn_item' . $i ,  get_string('config_item', 'theme_edumy') . ' ' . $i);

            $mform->addElement('text', 'config_color_bfbg' . $i, get_string('config_color_bg', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_bfbg' .$i , 'rgba(10, 10, 10, .5)');
            $mform->setType('config_color_bfbg' . $i, PARAM_TEXT);
            $mform->addRule('config_color_bfbg' . $i, get_string('required'), 'required', null, 'client', false, false);

            $mform->addElement('text', 'config_color_bfbg_hover' . $i, get_string('config_color_bg', 'theme_edumy') . get_string('on_hover', 'theme_edumy'), array('class'=>'ccn_spectrum_class'));
            $mform->setDefault('config_color_bfbg_hover' .$i , 'rgba(36, 65, 231, .8)');
            $mform->setType('config_color_bfbg_hover' . $i, PARAM_TEXT);
            $mform->addRule('config_color_bfbg_hover' . $i, get_string('required'), 'required', null, 'client', false, false);

            $options = array(
                'multiple' => false,
                'noselectionstring' => get_string('select_from_dropdown', 'theme_edumy'),
            );
            // $mform->addElement('autocomplete', 'config_category' . $i, get_string('category'), $areanames, $options);
            $mform->addElement('autocomplete', 'config_category' . $i, get_string('category'), $ccnCourseCategories, $options);
            $mform->addRule('config_category' . $i, get_string('required'), 'required', null, 'client', false, false);

            $select = $mform->addElement('select', 'config_icon' .$i, get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
            $select->setSelected('flaticon-student-3');
            $mform->addRule('config_icon' . $i, get_string('required'), 'required', null, 'client', false, false);

        }


        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }
}
