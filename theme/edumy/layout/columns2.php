<?php
defined('MOODLE_INTERNAL') || die();
include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler.php');
array_push($extraclasses, "ccn_context_frontend");
$bodyclasses = implode(" ",$extraclasses);
$bodyattributes = $OUTPUT->body_attributes($bodyclasses);
include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler_context.php');
if($ccnMdlVersion == "400") {
  echo $OUTPUT->render_from_template('theme_edumy/ccn_mdl_400/columns2', $templatecontext);
} else {
  echo $OUTPUT->render_from_template('theme_boost/columns2', $templatecontext);
}
