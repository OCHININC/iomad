<?php
defined('MOODLE_INTERNAL') || die();
include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler.php');
array_push($extraclasses, "ccn_context_dashboard");
$bodyclasses = implode(" ",$extraclasses);
$bodyattributes = $OUTPUT->body_attributes($bodyclasses);
include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler_context.php');

if($ccnMdlVersion == "400") {
  echo $OUTPUT->render_from_template('theme_edumy/ccn_mdl_400/ccn_dashboard', $templatecontext);
} else {
  echo $OUTPUT->render_from_template('theme_edumy/ccn_dashboard', $templatecontext);
}
