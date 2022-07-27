<?php

/**
 * Cocoon Form Builder integration for Moodle
 *
 * @package    cocoon_form_builder
 * @copyright  ©2021 Cocoon, XTRA Enterprises Ltd. createdbycocoon.com
 * @author     Cocoon
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot. '/course/renderer.php');
include_once($CFG->dirroot . '/course/lib.php');

class ccnConstruct {

  public function ccnGetForms() {
    global $CFG, $COURSE, $USER, $DB, $SESSION, $SITE, $PAGE, $OUTPUT;

    $ccnForms = $DB->get_records('cocoon_form_builder_forms', array(), $sort='', $fields='*', $limitfrom=0, $limitnum=$maxNum);
    //print_object($ccnForms);
  }

}
