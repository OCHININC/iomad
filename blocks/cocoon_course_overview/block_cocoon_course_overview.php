<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_course_overview extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_course_overview', 'block_cocoon_course_overview');

    }

    // Declare second
    public function specialization()
    {
        // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->title = 'Overview';
          $this->config->description['text'] = '
										<h4 class="subtitle">Course Description</h4>
										<p class="mb30">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>
										<p class="mb20">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
										<h4 class="subtitle">What you\'ll learn</h4>
										<ul class="cs_course_syslebus">
											<li><i class="fa fa-check"></i><p>Become a UX designer.</p></li>
											<li><i class="fa fa-check"></i><p>You will be able to add UX designer to your CV</p></li>
											<li><i class="fa fa-check"></i><p>Become a UI designer.</p></li>
											<li><i class="fa fa-check"></i><p>Build &amp; test a full website design.</p></li>
											<li><i class="fa fa-check"></i><p>Build &amp; test a full mobile app.</p></li>
										</ul>
										<ul class="cs_course_syslebus2">
											<li><i class="fa fa-check"></i><p>Learn to design websites &amp; mobile phone apps.</p></li>
											<li><i class="fa fa-check"></i><p>You\'ll learn how to choose colors.</p></li>
											<li><i class="fa fa-check"></i><p>Prototype your designs with interactions.</p></li>
											<li><i class="fa fa-check"></i><p>Export production ready assets.</p></li>
											<li><i class="fa fa-check"></i><p>All the techniques used by UX professionals</p></li>
										</ul>
										<h4 class="subtitle">Requirements</h4>
										<ul class="list_requiremetn">
											<li><i class="fa fa-circle"></i><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p></li>
											<li><i class="fa fa-circle"></i><p>No previous design experience is needed.</p></li>
											<li><i class="fa fa-circle"></i><p>No previous Adobe XD skills are needed.</p></li>
										</ul>
									';
        }
    }

    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('course-view'));
    }



    public function get_content()
    {
        global $CFG, $DB;

        if ($this->content !== null) {
            return $this->content;
        }

        // Declare third
        $this->content         =  new stdClass;

        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
        if(!empty($this->config->description)){$this->content->description = $this->config->description['text'];} else {$this->content->description = '';}



        $this->content->text = '
        <div class="cs_row_two">
          <div class="cs_overview">
            <h4 data-ccn="title" class="title">'. format_text($this->content->title, FORMAT_HTML, array('filter' => true)) .'</h4>
            <div data-ccn="description">'. format_text($this->content->description, FORMAT_HTML, array('filter' => true)) .'</div>
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
