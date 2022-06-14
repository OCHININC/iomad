<?php

class block_cocoon_course_enrl_c_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
        global $CFG;
        $ccnFontList = include($CFG->dirroot . '/theme/edumy/ccn/font_handler/ccn_font_select.php');

        if (!empty($this->block->config) && is_object($this->block->config)) {
            $data = $this->block->config;
        } else {
            $data = new stdClass();
            $data->items = 0;
        }

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Price title
        $mform->addElement('text', 'config_price_title', get_string('config_price_title', 'block_cocoon_course_enrl_c'));
        $mform->setDefault('config_price_title', 'Price');
        $mform->setType('config_price_title', PARAM_RAW);

        // Price
        $mform->addElement('text', 'config_price', get_string('config_price', 'block_cocoon_course_enrl_c'));
        $mform->setDefault('config_price', '$49.00');
        $mform->setType('config_price', PARAM_RAW);

        // Full Price
        $mform->addElement('text', 'config_full_price', get_string('config_full_price', 'block_cocoon_course_enrl_c'));
        $mform->setDefault('config_full_price', '$69.00');
        $mform->setType('config_full_price', PARAM_RAW);

        // Add to cart text
        $mform->addElement('text', 'config_add_to_cart_text', get_string('config_add_to_cart_text', 'block_cocoon_course_enrl_c'));
        $mform->setDefault('config_add_to_cart_text', 'Add to Cart');
        $mform->setType('config_add_to_cart_text', PARAM_RAW);

        // Add to cart link
        $mform->addElement('text', 'config_add_to_cart_link', get_string('config_add_to_cart_link', 'block_cocoon_course_enrl_c'));
        $mform->setDefault('config_add_to_cart_link', '#');
        $mform->setType('config_add_to_cart_link', PARAM_RAW);

        // Buy Now text
        $mform->addElement('text', 'config_buy_now_text', get_string('config_buy_now_text', 'block_cocoon_course_enrl_c'));
        $mform->setDefault('config_buy_now_text', 'Buy now');
        $mform->setType('config_buy_now_text', PARAM_RAW);

        // Buy Now link
        $mform->addElement('text', 'config_buy_now_link', get_string('config_buy_now_link', 'block_cocoon_course_enrl_c'));
        $mform->setDefault('config_buy_now_link', '#');
        $mform->setType('config_buy_now_link', PARAM_RAW);

        // Includes title
        $mform->addElement('text', 'config_includes_title', get_string('config_includes_title', 'block_cocoon_course_enrl_c'));
        $mform->setDefault('config_includes_title', 'Includes');
        $mform->setType('config_includes_title', PARAM_RAW);

        // // Video text
        // $mform->addElement('text', 'config_video_text', get_string('config_video_text', 'block_cocoon_course_enrl_c'));
        // $mform->setDefault('config_video_text', '11 hours on-demand video');
        // $mform->setType('config_video_text', PARAM_RAW);
        //
        // // Download text
        // $mform->addElement('text', 'config_download_text', get_string('config_download_text', 'block_cocoon_course_enrl_c'));
        // $mform->setDefault('config_download_text', '69 downloadable resources');
        // $mform->setType('config_download_text', PARAM_RAW);
        //
        // // Access text
        // $mform->addElement('text', 'config_access_text', get_string('config_access_text', 'block_cocoon_course_enrl_c'));
        // $mform->setDefault('config_access_text', 'Full lifetime access');
        // $mform->setType('config_access_text', PARAM_RAW);
        //
        // // Devices text
        // $mform->addElement('text', 'config_devices_text', get_string('config_devices_text', 'block_cocoon_course_enrl_c'));
        // $mform->setDefault('config_devices_text', 'Access on mobile and TV');
        // $mform->setType('config_evices_text', PARAM_RAW);
        //
        // // Assignments text
        // $mform->addElement('text', 'config_assignments_text', get_string('config_assignments_text', 'block_cocoon_course_enrl_c'));
        // $mform->setDefault('config_assignments_text', 'Assignments');
        // $mform->setType('config_assignments_text', PARAM_RAW);
        //
        // // Certificate text
        // $mform->addElement('text', 'config_certificate_text', get_string('config_certificate_text', 'block_cocoon_course_enrl_c'));
        // $mform->setDefault('config_certificate_text', 'Certificate of Completion');
        // $mform->setType('config_certificate_text', PARAM_RAW);

        $itemsrange = range(0, 12);
        $mform->addElement('select', 'config_items', get_string('config_items', 'theme_edumy'), $itemsrange);
        $mform->setDefault('config_items', $data->items);

        for($i = 1; $i <= $data->items; $i++) {

          $mform->addElement('header', 'config_header' . $i , 'Item ' . $i);

          $mform->addElement('text', 'config_item_title' . $i, get_string('config_title', 'theme_edumy', $i));
          $mform->setDefault('config_item_title' .$i , '11 hours on-demand video');
          $mform->setType('config_item_title' . $i, PARAM_TEXT);

          // $mform->addElement('text', 'config_item_icon' . $i, get_string('config_item_icon', 'block_cocoon_course_details', $i));
          // $mform->setDefault('config_item_icon' .$i , 'flaticon-play-button-1');
          // $mform->setType('config_item_icon' . $i, PARAM_TEXT);

          $select = $mform->addElement('select', 'config_item_icon' . $i, get_string('config_icon_class', 'theme_edumy'), $ccnFontList, array('class'=>'ccn_icon_class'));
          $select->setSelected('flaticon-account');

       }

     include($CFG->dirroot . '/theme/edumy/ccn/block_handler/edit.php');

    }
}
