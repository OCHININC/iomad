<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
use DateTime;
class block_cocoon_event_body extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_event_body', 'block_cocoon_event_body');
    }

    // Declare second
    public function specialization()
    {
        // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
        global $CFG;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content         =  new stdClass;
        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->date)){$this->content->date = $this->config->date;}
        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_event_body', 'content');
        $this->content->image = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image .=  $url;
            }
        }
        $date = new DateTime();
        $date = $date->setTimestamp($this->config->date);
        $date = $date->format('d M Y H:m');
        $this->content->text = '
        <div class="mbp_thumb_post">
							<div class="details pt0">
								<h3 class="mb25">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
							</div>';
              if(!empty($this->content->image)){
                $this->content->text .= '
  							<div class="thumb">
  								<img class="img-fluid" src="'.$this->content->image.'" alt="'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'">
  								<div class="post_date"><h2>'.userdate($this->content->date, '%d').'</h2> <span>'.userdate($this->content->date, '%B').'</span></div>
  							</div>';
              }
              $this->content->text .= '
							<div class="event_counter_plugin_container">
								<div class="event_counter_plugin_content">
									<ul>
										<li>'.get_string('days', 'theme_edumy').'<span id="days"></span></li>
										<li>'.get_string('hours', 'theme_edumy').'<span id="hours"></span></li>
										<li>'.get_string('minutes', 'theme_edumy').'<span id="minutes"></span></li>
										<li>'.get_string('seconds', 'theme_edumy').'<span id="seconds"></span></li>
									</ul>
								</div>
							</div>
              </div>
              <script>
              document.addEventListener(\'DOMContentLoaded\', function() {
              (function($) {
                if ($(".event_counter_plugin_container").length) {
                  const second = 1000,
                    minute = second * 60,
                    hour = minute * 60,
                    day = hour * 24;
                  let countDown = new Date(\''.$date.'\').getTime(),
                    x = setInterval(function() {
                      let now = new Date().getTime(),
                        distance = countDown - now;
                      document.getElementById(\'days\').innerText = Math.floor(distance / (day)),
                        document.getElementById(\'hours\').innerText = Math.floor((distance % (day)) / (hour)),
                        document.getElementById(\'minutes\').innerText = Math.floor((distance % (hour)) / (minute)),
                        document.getElementById(\'seconds\').innerText = Math.floor((distance % (minute)) / second);
                    }, second)
                }
              }(jQuery));
              }, false);
              </script>
              ';
        return $this->content;
    }

    /**
     * Allow multiple instances in a single course?
     *
     * @return bool True if multiple instances are allowed, false otherwise.
     */
    public function instance_allow_multiple() {
        return true;
    }

    /**
     * Enables global configuration of the block in settings.php.
     *
     * @return bool True if the global configuration is enabled.
     */
    function has_config() {
        return true;
    }

    /**
     * Sets the applicable formats for the block.
     *
     * @return string[] Array of pages and permissions.
     */
     function applicable_formats() {
       $ccnBlockHandler = new ccnBlockHandler();
       return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
     }
     public function html_attributes() {
       global $CFG;
       $attributes = parent::html_attributes();
       include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
       return $attributes;
     }

}
