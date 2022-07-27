<?php
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_accordion extends block_base {

    /**
     * Start block instance.
     */
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_accordion');
    }

    /**
     * The block is usable in all pages
     */
     function applicable_formats() {
       $ccnBlockHandler = new ccnBlockHandler();
       return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
     }


    /**
     * Customize the block title dynamically.
     */
    function specialization() {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->slidesnumber = '4';
          $this->config->title = 'Frequently Asked Questions';
          $this->config->title1 = 'Why won\'t my payment go through?';
          $this->config->title2 = 'How do I get a refund?';
          $this->config->title3 = 'How do I redeem a coupon?';
          $this->config->title4 = 'Changing account name';
          $this->config->subtitle1 = 'Course Description';
          $this->config->subtitle2 = 'Course Description';
          $this->config->subtitle3 = 'Course Description';
          $this->config->subtitle4 = 'Course Description';
          $this->config->text1['text'] = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.';
          $this->config->text2['text'] = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.';
          $this->config->text3['text'] = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.';
          $this->config->text4['text'] = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.';
        }
    }

    /**
     * The block can be used repeatedly in a page.
     */
    function instance_allow_multiple() {
        return true;
    }

    /**
     * Build the block content.
     */
    function get_content() {
        global $CFG, $PAGE;

        require_once($CFG->libdir . '/filelib.php');


        if ($this->content !== NULL) {
            return $this->content;
        }

        if (!empty($this->config) && is_object($this->config)) {
            $this->content = new \stdClass();
            if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = '';}
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 0;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 0;
        }

        $text = '';

        if ($data->slidesnumber > 0) {
            $text .= '
            <div class="shortcode_widget_accprdons">';
            if(!empty($this->config->title)){
              $text .='  <h4 data-ccn="title">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h4>';
            }
            $ccnAccInstance = 'accordion-'.$this->instance->id;
            $text .='
            						<div class="faq_according">
            							<div class="accordion" id="'.$ccnAccInstance.'">';
                           for ($i = 1; $i <= $data->slidesnumber; $i++) {
                             $ccnAccTitle = 'title' . $i;
                             $ccnAccBody = 'text' . $i;
                             $ccnAccLink = 'heading-'.$this->instance->id.'-'.$i;
                             $ccnCollapseLink = 'heading-'.$this->instance->id.'-'.$i;
                             $ccnAriaSelected = 'false';
                             $ccnClass = 'nav-link';
                             if($i == 1){
                               $ccnAriaSelected = 'true';
                               $ccnClass .= ' active';
                             }

                              $text .='
            							  	<div class="card">
              								    <div class="card-header" id="#'.$ccnAccLink.'">
            								    	<h2 class="mb-0">
            								        	<button data-ccn="'.$ccnAccTitle.'" class="btn btn-link" type="button" data-toggle="collapse" data-target="#'.$ccnCollapseLink.'" aria-expanded="false" aria-controls="'.$ccnCollapseLink.'">
            								        		'.format_text($data->$ccnAccTitle, FORMAT_HTML, array('filter' => true)).'
            								        		<span class="flaticon-right-arrow float-right"></span>
            								    		</button>
            								   		</h2>
            								    </div>
            								    <div id="'.$ccnCollapseLink.'" class="collapse" aria-labelledby="'.$ccnAccLink.'" data-parent="#'.$ccnAccInstance.'">
            									    <div class="card-body" data-ccn="'.$ccnAccBody.'">
            									        '.format_text($data->$ccnAccBody['text'], FORMAT_HTML, array('filter' => true)).'
            									    </div>
            								    </div>
            							    </div>';
                            }
                            $text .='
            							</div>
            						</div>
            					</div>';
        }
        $this->content = new stdClass;
        $this->content->footer = '';
        $this->content->text = $text;

        return $this->content;

  }

    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }

}
