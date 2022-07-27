<?php
/*
@ccnRef: @
*/

require_once('../../../../config.php');
require_once('../../../../lib/blocklib.php');

global $CFG, $DB, $USER;

require_once($CFG->dirroot. '/theme/edumy/ccn/user_handler/ccn_user_handler.php');

/* @ccnComm: Initialize */
$ccnUserHandler = new ccnUserHandler();
$ccnIsCourseCreator = $ccnUserHandler->ccnCheckRoleIsCourseCreatorAnywhere($USER->id);
$ccnIsManager = $ccnUserHandler->ccnCheckRoleIsManagerAnywhere($USER->id);

require_login();

header('Content-Type: application/json');
$_RESTREQUEST = file_get_contents("php://input");
$_POST = json_decode($_RESTREQUEST, true);

if(is_siteadmin() || $ccnIsManager || $ccnIsCourseCreator){
  $bid = $_POST['instance_id'];
  $fields = $_POST['fields'];

    function ccn_block_instance_by_id($blockinstanceid, $fields) {
      global $DB;
      $ccnBlockInstance = $DB->get_record('block_instances', ['id' => $blockinstanceid]);
      $ccnBlockName = $ccnBlockInstance->blockname;
      $ccnInstance = block_instance($ccnBlockName, $ccnBlockInstance);
      $ccnConfig = $ccnInstance->config;

      if (!empty($ccnConfig)) {
        $config = clone($ccnConfig);
      } else {
        $config = new stdClass;
      }
      foreach ($fields as $configfield => $value) {
        $config->$configfield = $value;
      }
      $ccnInstance->instance_config_save($config);
      return $config;
    }

    $ccnBlock = ccn_block_instance_by_id($bid, $fields);
    echo json_encode($ccnBlock);
}
