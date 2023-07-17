<?php
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot. '/theme/edumy/ccn/mdl_handler/ccn_mdl_handler.php');
$ccnMdlHandler = new ccnMdlHandler();
$ccnMdlVersion = $ccnMdlHandler->ccnGetCoreVersion();
if((int)$ccnMdlVersion >= 400) {



  $templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ["escape" => false]),
    'output' => $OUTPUT
  ];
  echo $OUTPUT->render_from_template('theme_edumy/ccn_mdl_400/ccn_maintenance', $templatecontext);
} else {
  include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler.php');
  array_push($extraclasses, "ccn_context_dashboard");
  $bodyclasses = implode(" ",$extraclasses);
  $bodyattributes = $OUTPUT->body_attributes($bodyclasses);
  include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler_context.php');
  echo $OUTPUT->render_from_template('theme_edumy/ccn_clean', $templatecontext);
}
