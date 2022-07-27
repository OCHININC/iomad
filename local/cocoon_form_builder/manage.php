<?php

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir.'/adminlib.php');

admin_externalpage_setup('cocoon_form_builder_settings');

$PAGE->set_title(get_string('pluginname', 'local_cocoon_form_builder'));
$PAGE->set_heading(get_string('pluginname', 'local_cocoon_form_builder'));
// $PAGE->set_pagelayout('cocoon.core');
$PAGE->requires->css(new moodle_url($CFG->wwwroot . '/local/cocoon_form_builder/style.css'));
echo $OUTPUT->header();
// echo "helloWorld";

$url=__DIR__ . '/dist/index.html'; // tạo biến url cần lấy
$lines_array=file($url); // dùng hàm file() lấy dữ liệu theo url
$lines_string=implode('',$lines_array); // chuyển dữ liệu lấy được kiểu mảng thành một biến string
echo $lines_string; // hiển thị dữ liệu


echo $OUTPUT->footer();
