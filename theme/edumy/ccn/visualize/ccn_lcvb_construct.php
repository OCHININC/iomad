<?php
/*
@ccnRef: @
*/

// require_once('../../../../config.php');
require_once($CFG->dirroot .'/lib/blocklib.php');
//
// global $CFG, $DB, $USER, $PAGE;

require_once($CFG->dirroot. '/theme/edumy/ccn/user_handler/ccn_user_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/mdl_handler/ccn_mdl_handler.php');
$ccnMdlHandler = new ccnMdlHandler();

/* @ccnComm: Initialize */
// $ccnUserHandler = new ccnUserHandler();
// $ccnIsCourseCreator = $ccnUserHandler->ccnCheckRoleIsCourseCreatorAnywhere($USER->id);
// $ccnIsManager = $ccnUserHandler->ccnCheckRoleIsManagerAnywhere($USER->id);


require_login();

// header('Content-Type: application/json');

// if(is_siteadmin() || $ccnIsManager || $ccnIsCourseCreator){
  if (isset($_GET['cocoon_customizer'])) {

    $json = new \stdClass();
    $json->regions = [];

    $a = $this->page->blocks->get_regions();
    $b = $this->page->blocks->get_content_for_region('fullwidth-top', $this);

    function ccn_block_instance_by_id($blockinstanceid) {
        global $DB;
        $ccnBlockInstance = $DB->get_record('block_instances', ['id' => $blockinstanceid]);
        $ccnBlockName = $ccnBlockInstance->blockname;
        $ccnBlockFullName = 'block_'.$ccnBlockInstance->blockname;
        $ccnBlockTitle = ucwords(str_replace("_", " ", $ccnBlockName));
        $ccnInstance = block_instance($ccnBlockName, $ccnBlockInstance);

        // print_object($ccnInstance->instance->blockname);
        // print_object($ccnInstance);


        $ccnInstance = $ccnInstance;
        return $ccnInstance;
    }

    foreach($a as $r=>$region){
      $json->regions[$region] = new stdClass();
      $json->regions[$region]->blocks = [];

      $blocks = $this->page->blocks->get_content_for_region($region, $this);
      foreach($blocks as $b=>$block){
        $blockId = $block->blockinstanceid;
        $ccnBlock = ccn_block_instance_by_id($blockId);
        $ccnBlockFields = $ccnBlock->config;
        $ccnBlockName = $ccnBlock->instance->blockname;
        $ccnBlockIterable = method_exists($ccnBlock, 'ccnIterable') ? $ccnBlock->ccnIterable() : null;
        $json->regions[$region]->blocks[$blockId] = new \stdClass();
        $json->regions[$region]->blocks[$blockId]->instance_id = $block->blockinstanceid;
        $json->regions[$region]->blocks[$blockId]->element_id = $block->attributes['id'];
        $json->regions[$region]->blocks[$blockId]->position_id = $block->blockpositionid;
        $json->regions[$region]->blocks[$blockId]->title = $block->title;
        $json->regions[$region]->blocks[$blockId]->fields = $ccnBlockFields;
        $json->regions[$region]->blocks[$blockId]->name = $ccnBlockName;
        // $json->regions[$region]->blocks[$blockId]->iterable = $ccnBlockIterable;




        //
          $formfile = $CFG->dirroot . '/blocks/' . $ccnBlockName . '/edit_form.php';
          if (is_readable($formfile)) {
            require_once($CFG->dirroot . '/blocks/edit_form.php');
            require_once($formfile);
            $classname = 'block_' . $ccnBlockName . '_edit_form';
            if (!class_exists($classname)) {
                $classname = 'block_edit_form';
            }

if($b == 0){
            $mform = new $classname('', $ccnBlock, $this->page);
            $mform->get_data();
            $mform->set_data($ccnBlock);
            // print_object($mform->_elements);

          }
            // print_object($mform->_form);
            $test = $ccnMdlHandler->ccnReflection($mform);
            // $test2 = $ccnMdlHandler->ccnReflection($test->_elements);
            // print_object($test->_form->_elements);
            // $mform->display();

          }



      // foreach($block->controls as $c => $control){
      //   $json->regions[$region]->blocks[$blockId]->url = strip_tags(html_writer::link($control->url, ''));
      //   if(is_object($control->text)){
      //     $ccnReflection = $ccnMdlHandler->ccnReflection($control->text);
      //     $ccnReflection->identifier;
      //     $ccnReflection->component;
      //   }
      //   // print_object($ccnReflection);
      // }
      // print_object($block);

      }
    }
    // print_object($json);
    echo('<div id="json" style="display:none;">'.json_encode($json)).'</div><style type="text/css">#ccnSearchOverlayWrap{position:absolute!important;}</style><div id="root"></div>';




    if (!$this->page->user_can_edit_blocks()) {
        throw new moodle_exception('nopermissions', '', $this->page->url->out(), get_string('addblock'));
    }


    $Stest = new block_manager($PAGE);
    $Stest->load_blocks();
    $tss = $Stest->get_addable_blocks();

    $allowedCocoonBlocks = [];
    foreach($tss as $k=>$v) {
      if (strpos($k, 'cocoon') !== false) {
        $tmp = new stdClass();
        $tmp->id = $v->id;
        $tmp->name = $v->name;
        $tmp->visible = $v->visible;
        $tmp->title = $v->title;
        $tmp->image = 'http://raphaelv3.sg-host.com/theme/edumy/ccn/visualize/ccn_block/jpeg/thumb' . $v->name . '.jpeg';
        $allowedCocoonBlocks[$k] = $tmp;
      }
    }


echo('<div id="json_add" style="display:none;">'.json_encode($allowedCocoonBlocks)).'</div>';




    $PAGE->requires->css('/theme/edumy/ccn/visualize/src/main.css');
    $PAGE->requires->js('/theme/edumy/ccn/visualize/src/main.js', false);






  }
// }
