<?php
/*
@ccnRef: @ MDL HANDLER
*/

defined('MOODLE_INTERNAL') || die();

class ccnMdlHandler {

  public function ccnGetCoreVersion() {
    // Should be returning 37, 38, 39, etc.
    global $CFG;

    $ccnMdlBranch = $CFG->branch;
    $ccnReturn = $ccnMdlBranch;

    return $ccnReturn;
  }

  public function ccnReflection($ccnObj) {
    $ccnReflection = new ReflectionClass($ccnObj);
    $ccnProperties = $ccnReflection->getProperties();
    $ccnReturn = new \stdClass();
    foreach($ccnProperties as $k=>$ccnProperty){
      $ccnProp = $ccnReflection->getProperty($ccnProperty->name);
      $ccnProp->setAccessible(true);
      $ccnReturn->{$ccnProperty->name} = $ccnProp->getValue($ccnObj);
    }
    return $ccnReturn;
  }

}
