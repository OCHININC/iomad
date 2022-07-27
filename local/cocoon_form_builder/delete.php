<?php

/**
 * Cocoon Form Builder integration for Moodle
 *
 * @package    cocoon_form_builder
 * @copyright  ©2021 Cocoon, XTRA Enterprises Ltd. createdbycocoon.com
 * @author     Cocoon
 */

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

require_once('../../config.php');
global $USER, $DB, $CFG;

$id = 0;

$PAGE->set_url('/local/cocoon_form_builder/delete.php?id=' . $id);
$PAGE->set_context(context_system::instance());

$id = $_GET['id'];

$DB->delete_records('cocoon_form_builder_forms', array('id'=>$id));
