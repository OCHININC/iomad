<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/user_handler/ccn_user_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_course_instructor extends block_base
{
    public function init()
    {
        $this->title = get_string('cocoon_course_instructor', 'block_cocoon_course_instructor');
    }

    public function specialization() {
      global $CFG, $DB, $USER;
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
      if (empty($this->config)) {
        $this->config = new \stdClass();
        $this->config->title = 'About the instructor';
        $this->config->user = $USER->id;
      }
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('course-view'));
    }

    function instance_allow_multiple() {
        return true;
    }

    public function get_content()
    {
        global $CFG, $DB, $USER, $OUTPUT, $COURSE;
        require_once($CFG->libdir . '/filelib.php');


        $courseid = $COURSE->id;
        $context = context_course::instance($courseid);

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content =  new stdClass;
        $this->content->text = '';

        $userID = $userDescription = $userURL = $userFirst = $userLast = $userLastLogin = $userAvatar = $teachingCoursesCount = $teachingStudentCount = null;

        if(!empty($this->config->user)){
          $ccnUserHandler = new ccnUserHandler();
          $ccnUser = $ccnUserHandler->ccnGetUserDetails($this->config->user);
        }

        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->name)){
          $renderName = $this->config->name;
        } elseif(!empty($this->config->user)){
          $renderName = '<a href="'.$ccnUser->profileUrl.'">'. $ccnUser->fullname .'</a>';
        } else {
          $renderName = 'Name';
        }
        if(!empty($this->config->position)){
          $renderPosition = $this->config->position;
        } elseif(!empty($this->config->user)){
          $renderPosition = get_string('lastsiteaccess').': '.$ccnUser->lastLogin;
        } else {
          $renderPosition = get_string('config_teacher', 'theme_edumy');
        }
        if(!empty($this->config->students)){
          $renderStudents = $this->config->students;
        } elseif(!empty($this->config->user)){
          if($ccnUser->teachingStudentCount !== 0) {
            $renderStudents = $ccnUser->teachingStudentCount . ' ' . get_string('students');
          } else {
            $renderStudents = get_string('no_students_yet', 'theme_edumy');
          }
        } else {
          $renderStudents = count_enrolled_users($context);
        }
        // if(!empty($this->config->reviews)){
        //   $this->content->reviews = $this->config->reviews;
        // }
        if(!empty($this->config->courses)){
          $renderCourses = $this->config->courses;
        }elseif(!empty($this->config->user)){
          if($ccnUser->teachingCoursesCount !== 0) {
            $renderCourses = $ccnUser->teachingCoursesCount . ' ' . get_string('courses');
          } else {
            $renderCourses = get_string('no_courses_yet', 'theme_edumy');
          }
        } else {
          $renderStudents = '';
        }
        if(!empty($this->config->bio) && strlen($this->config->bio['text']) > 2){
          $renderBio = $this->config->bio['text'];
        } elseif(!empty($this->config->user)){
          $renderBio = $ccnUser->description;
        } else {
          $renderBio = '';
        }


        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_course_instructor', 'content');
        $ccnImage = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $ccnImage = '<img src="' . $url . '" alt="' . $filename . '" />';
            }
        }

        if(!empty($ccnImage)){
          $renderImage = $ccnImage;
        } elseif(!empty($this->config->user)){
          $renderImage = $ccnUser->printAvatar;

        } else {
          $renderImage = '<img src="' . $CFG->wwwroot .'/theme/edumy/images/team/6.png" alt="" />';
        }

        $this->content->text .= '
        <div class="cs_row_four">
          <div class="about_ins_container">';
          if($this->content->title){
          $this->content->text .='
            <h4 class="aii_title" data-ccn="title">'. format_text($this->content->title, FORMAT_HTML, array('filter' => true)) .'</h4>';
          }
          if($renderImage){
          $this->content->text .='
            <div class="about_ins_info">
              <div class="thumb mb10">'. $renderImage .'</div>
            </div>';
          }
          $this->content->text .='
            <div class="details">';
          // if($this->content->rating){
            $this->content->text .= $ccnUser->ccnRender->teacherStarRating;
            $this->content->text .='
              <ul class="about_info_list">';
            // if($this->content->reviews){
            //   $this->content->text .='
            //     <li class="list-inline-item"><span class="flaticon-rating"></span> '. format_text($this->content->reviews, FORMAT_HTML, array('filter' => true)) .' </li>';
            // }
            if($renderStudents){
              $this->content->text .='
                <li class="list-inline-item"><span class="flaticon-profile"></span> <span data-ccn="students">'. format_text($renderStudents, FORMAT_HTML, array('filter' => true)) .'</span> </li>';
            }
            if($renderCourses){
              $this->content->text .='
                <li class="list-inline-item"><span class="flaticon-play-button-1"></span> <span data-ccn="courses">'. format_text($renderCourses, FORMAT_HTML, array('filter' => true)) .'</span> </li>';
            }
            $this->content->text .='
              </ul>';
            if($renderName){
            $this->content->text .='
              <h4 data-ccn="name">'. format_text($renderName, FORMAT_HTML, array('filter' => true)) .'</h4>';
            }
            if($renderPosition){
            $this->content->text .='
              <p class="subtitle" data-ccn="position">'. format_text($renderPosition, FORMAT_HTML, array('filter' => true)) .'</p>';
            }
            // if($renderBio){
              $this->content->text .= '<div data-ccn="bio">'.format_text($renderBio, FORMAT_HTML, array('filter' => true)).'</div>';
            // }
            $this->content->text .='
            </div>
          </div>
        </div>';
        return $this->content;
    }
    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }
}
