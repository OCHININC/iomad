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

$PAGE->set_url('/local/cocoon_form_builder/getformlist.php');
$PAGE->set_context(context_system::instance());

$sql = "SELECT * FROM {cocoon_form_builder_forms} order by id DESC" ;
$forms = $DB->get_records_sql($sql);

$data = array();

foreach ($forms as $form) {
	$x = [
        "id" => $form->id,
        "title" => $form->title,
        "status" => $form->status,
    ];

    $data[] = $x;
}

echo json_encode($data);
