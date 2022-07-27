<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_about_2 extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_about_2', 'block_cocoon_about_2');
    }

    // Declare second
    public function specialization()
    {
      global $CFG, $DB;
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');

      if (empty($this->config)) {
        $this->config = new \stdClass();
        $this->config->col_1_title = 'Who We Are';
        $this->config->col_1_body['text'] = '<p class="mt25">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis,et quasi architecto beatae vitae dicta sunt explicabo.</p><p class="mt25">Nemo enim ipsam,voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia,consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.,Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, adipisci velit, sed quia non numquam eius modi tempora</p>';
        $this->config->col_2_title = 'What We Do';
        $this->config->col_2_body['text'] = '<p class="mt25">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis,et quasi architecto beatae vitae dicta sunt explicabo.</p><p class="mt25">Nemo enim ipsam,voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia,consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.,Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, adipisci velit, sed quia non numquam eius modi tempora</p>';
      }
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            // return $this->content;
        }
        $this->content         =  new stdClass;

        if(!empty($this->config->col_1_title)){$this->content->col_1_title = format_text($this->config->col_1_title, FORMAT_HTML, array('filter' => true));}else {$this->content->col_1_title = '';}
        if(!empty($this->config->col_1_body)){$this->content->col_1_body = format_text($this->config->col_1_body['text'], FORMAT_HTML, array('filter' => true, 'noclean' => true));}else {$this->content->col_1_body = '';}
        if(!empty($this->config->col_2_title)){$this->content->col_2_title = format_text($this->config->col_2_title, FORMAT_HTML, array('filter' => true));} else {$this->content->col_2_title = '';}
        if(!empty($this->config->col_2_body)){$this->content->col_2_body = format_text($this->config->col_2_body['text'], FORMAT_HTML, array('filter' => true, 'noclean' => true));}else {$this->content->col_2_body = '';}

        $this->content->text = '
<div class="container mb70">
<div class="row">
  <div class="col-lg-6">
    <div class="about_whoweare">
      <h4 data-ccn="col_1_title">'.$this->content->col_1_title.'</h4>
      <div data-ccn="col_1_body">'.$this->content->col_1_body.'</div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="about_whoweare">
      <h4 data-ccn="col_2_title">'.$this->content->col_2_title.'</h4>
      <div data-ccn="col_2_body">'.$this->content->col_2_body.'</div>
    </div>
  </div>
</div>
</div>
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
