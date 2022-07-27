<?php

/**
 * Cocoon Form Builder integration for Moodle
 *
 * @package    cocoon_form_builder
 * @copyright  ©2021 Cocoon, XTRA Enterprises Ltd. createdbycocoon.com
 * @author     Cocoon
 */

defined('MOODLE_INTERNAL') || die;
require_once($CFG->libdir . '/authlib.php');
global $PAGE, $DB;
if ($hassiteconfig) {
  $settings = new admin_externalpage('cocoon_form_builder_settings',
      get_string('pluginname', 'local_cocoon_form_builder'),
      new moodle_url('/local/cocoon_form_builder/manage.php'),
      'moodle/site:config');
  $ADMIN->add('localplugins', $settings);
}
