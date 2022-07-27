<?php
/*
@ccnRef: @
*/

require_once('../../../../config.php');
require_once('../../../../lib/blocklib.php');

global $CFG, $DB, $USER, $PAGE;

require_once($CFG->dirroot. '/theme/edumy/ccn/user_handler/ccn_user_handler.php');

/* @ccnComm: Initialize */
$ccnUserHandler = new ccnUserHandler();
$ccnIsCourseCreator = $ccnUserHandler->ccnCheckRoleIsCourseCreatorAnywhere($USER->id);
$ccnIsManager = $ccnUserHandler->ccnCheckRoleIsManagerAnywhere($USER->id);

required_param('ccn_block', PARAM_TEXT);
require_login();

header('Content-Type: application/json');

if(is_siteadmin() || $ccnIsManager || $ccnIsCourseCreator){
  if (isset($_GET['ccn_block'])) {
    $ccnBlockName = $_GET['ccn_block'];


    // if (!$PAGE->user_can_edit_blocks()) {
    //   var_dump('nopermissions');
    // }

    $Stest = new block_manager($PAGE);
    $Stest->load_blocks();
    $addableblocks = $Stest->get_addable_blocks();

    if (!array_key_exists($ccnBlockName, $addableblocks)) {
      var_dump('cannotaddthisblocktype');
    }

    $classname = 'block_'.$ccnBlockName;
    $ccnBlockClass = new $classname();
    // $a = $ccnBlockClass->init();
    $b = $ccnBlockClass->specialization();
    // var_dump($a);
    // var_dump($b);


    $final = new \stdClass();
    $final->name = $ccnBlockName;
    $final->markup = $ccnBlockClass->get_content()->text;
    echo json_encode($final);




    // function ccnGetBlockSampleContent($blockMachineName) {
    //   global $DB;
    //
    // }








    // function ccn_block_instance_by_id($blockinstanceid) {
    //     global $DB;
    //     $ccnBlockInstance = $DB->get_record('block_instances', ['id' => $blockinstanceid]);
    //     $ccnBlockName = $ccnBlockInstance->blockname;
    //     $ccnBlockFullName = 'block_'.$ccnBlockInstance->blockname;
    //     $ccnBlockTitle = ucwords(str_replace("_", " ", $ccnBlockName));
    //     $ccnInstance = block_instance($ccnBlockName, $ccnBlockInstance);
    //     // @ccnBreak
    //     $ccnReturn = new \stdClass();
    //     $ccnReturn->ccnBlockRender = '<div class="'.$ccnBlockFullName.'">'.$ccnInstance->get_content()->text.'</div>';
    //     return $ccnReturn;
    // }
    // $ccnBlock = ccn_block_instance_by_id($ccnBlockName);
    // echo json_encode($ccnBlock);
  }
}
