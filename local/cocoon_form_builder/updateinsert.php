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

$PAGE->set_url('/local/cocoon_form_builder/updateinsert.php');
$PAGE->set_context(context_system::instance());

$_RESTREQUEST = file_get_contents("php://input");
$_POST = json_decode($_RESTREQUEST, true);

$attachments = array();
if(isset($_POST['attachments']) && $_POST['attachments'] != '') {
	$allowedfileExtensions = array("image/png", "image/jpeg", "image/bmp", "image/vnd.microsoft.icon", "application/pdf", "application/msword",
																 "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.ms-excel",
																 "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
																 "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation",
																 "text/csv", "application/zip");

	foreach ($_POST['attachments'] as $key => $value) {
		define('UPLOAD_DIR', $CFG->dataroot);
		$image_parts = explode(";base64,", $value);
		if(count($image_parts) > 1) {
			$file_type_aux = explode(":", $image_parts[0]);
			$file_type = $file_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);

			$fileExtension = "";

			if((strpos($file_type, "image/png")) || ($file_type == "image/png")) {
				$fileExtension = "png";
			} elseif ((strpos($file_type, "image/jpeg")) || ($file_type == "image/jpeg")) {
				$fileExtension = "jpg";
			} elseif ((strpos($file_type, "image/bmp")) || ($file_type == "image/bmp")) {
				$fileExtension =  "bmp";
			} elseif ((strpos($file_type, "image/vnd.microsoft.icon")) || ($file_type == "image/vnd.microsoft.icon")) {
				$fileExtension =  "ico";
			} elseif ((strpos($file_type, "application/pdf")) || ($file_type == "application/pdf")) {
				$fileExtension = "pdf";
			} elseif ((strpos($file_type, "application/msword")) || ($file_type == "application/msword")) {
				$fileExtension = "doc";
			} elseif ((strpos($file_type, "application/vnd.openxmlformats-officedocument.wordprocessingml.document")) || ($file_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")) {
				$fileExtension = "docx";
			} elseif ((strpos($file_type, "application/vnd.ms-excel")) || ($file_type == "application/vnd.ms-excel")) {
				$fileExtension = "xls";
			} elseif ((strpos($file_type, "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")) || ($file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")) {
				$fileExtension = "xlsx";
			} elseif ((strpos($file_type, "application/vnd.ms-powerpoint")) || ($file_type == "application/vnd.ms-powerpoint")) {
				$fileExtension = "ppt";
			} elseif ((strpos($file_type, "application/vnd.openxmlformats-officedocument.presentationml.presentation")) || ($file_type == "application/vnd.openxmlformats-officedocument.presentationml.presentation")) {
				$fileExtension = "pptx";
			} elseif ((strpos($file_type, "text/csv")) || ($file_type == "text/csv")) {
				$fileExtension = "csv";
			} elseif ((strpos($file_type, "application/zip")) || ($file_type == "application/zip")) {
				$fileExtension = "zip";
			}

			$fileName = uniqid() . '.' . $fileExtension;
			$file = UPLOAD_DIR . "/" . $fileName;
			file_put_contents($file, $image_base64);

			$f = $file;
			// Read image path, convert to base64 encoding
			$fData = base64_encode(file_get_contents($file));

			// Format the image SRC:  data:{mime};base64,{data};
			$src = 'data: '.mime_content_type($f).';base64,'.$fData;

			$attachments[] = $src;
		} else {
			$attachments[] = $value;
		}
	}
}

$reply = new stdClass();
$reply->subject =  $_POST['email_subject'];
$reply->message =  $_POST['email_message'];
$reply->attachments = $attachments;


$obj = new stdClass();
$obj->title = $_POST['title'];
$obj->json = $_POST['json'];
$obj->data = json_encode($reply);
$obj->url = $_POST['url'];
$obj->confirm_message = $_POST['confirm_message'];
$obj->recipients = $_POST['recipients'];
$obj->status = $_POST['status'];
$obj->ajax = $_POST['ajax'];

if(empty(trim($_POST['title']))) {
	$sql = "SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = '{cocoon_form_builder_forms}'";
	$form = $DB->get_records_sql($sql);
	$value = intval(array_values($form)[0]->auto_increment);
	$obj->title = "Form #" . $value;
}

if(isset($_POST['id']) && $_POST['id'] !== '') {
	$obj->id = $_POST['id'];
	$result = $DB->update_record('cocoon_form_builder_forms', $obj);
	echo $result;
} else {
	$result = $DB->insert_record('cocoon_form_builder_forms', $obj, true, false);
	echo $result;
}
