<?php

/**
 * Cocoon Form Builder integration for Moodle
 *
 * @package    cocoon_form_builder
 * @copyright  ©2021 Cocoon, XTRA Enterprises Ltd. createdbycocoon.com
 * @author     Cocoon
 */

defined('MOODLE_INTERNAL') || die();

 function xmldb_local_cocoon_form_builder_upgrade($oldversion) {
     global $CFG, $DB;
     $dbman = $DB->get_manager();
     $result = TRUE;

     if ($oldversion < 2021060823) {
        $table = new xmldb_table('cocoon_form_builder_forms');
        $field = new xmldb_field('url', XMLDB_TYPE_CHAR, '255', null, XMLDB_NULL, null, null, 'data');

        if (!$dbman->field_exists($table, $field)) {
          $dbman->add_field($table, $field, $continue=true, $feedback=true);
        }
        upgrade_plugin_savepoint(true, 2021060823, 'local', 'cocoon_form_builder');
     }

     if ($oldversion < 2021060824) {
        $table = new xmldb_table('cocoon_form_builder_forms');
        $field = new xmldb_field('confirm_message', XMLDB_TYPE_CHAR, '255', null, XMLDB_NULL, null, null, 'url');
        $field_2 = new xmldb_field('ajax', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NULL, null, '0', 'status');

        if (!$dbman->field_exists($table, $field)) {
          $dbman->add_field($table, $field, $continue=true, $feedback=true);
        }
        if (!$dbman->field_exists($table, $field_2)) {
          $dbman->add_field($table, $field_2, $continue=true, $feedback=true);
        }
        upgrade_plugin_savepoint(true, 2021060824, 'local', 'cocoon_form_builder');
     }

   return $result;
 }
