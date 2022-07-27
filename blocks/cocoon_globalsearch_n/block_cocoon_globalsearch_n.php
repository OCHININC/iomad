<?php


defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_globalsearch_n extends block_base {










  /*    @ccnRef: Block to be discontinued     */










    /**
     * Initialises the block.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_cocoon_globalsearch_n');
    }

    /**
     * The block is usable in all pages
     */
    function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
    }

    /**
     * Gets the block contents.
     *
     * If we can avoid it better not check the server status here as connecting
     * to the server will slow down the whole page load.
     *
     * @return string The block HTML.
     */
    public function get_content() {
        global $OUTPUT;
        if ($this->content !== null) {
            return $this->content;
        }
        $this->title = '';
        $this->content = new stdClass();
        $this->content->footer = '';
        $this->content->text = '';

        if (\core_search\manager::is_global_search_enabled() === false) {
            $this->content->text .= get_string('globalsearchdisabled', 'search');
            return $this->content;
        }

        $url = new moodle_url('/search/index.php');

        $this->content->text .= html_writer::start_tag('form', array('class' => 'form-inline mailchimp_form', 'action' => $url->out()));
        $this->content->text .= html_writer::start_tag('fieldset');
        // Input.
        $inputoptions = array('id' => 'searchform_search', 'name' => 'q', 'class' => 'form-control mb-2 mr-sm-2', 'placeholder' => get_string('search_string', 'theme_edumy'), 'type' => 'text', 'size' => '15');
        $this->content->text .= html_writer::empty_tag('input', $inputoptions);
        // Context id.
        if ($this->page->context && $this->page->context->contextlevel !== CONTEXT_SYSTEM) {
            $this->content->text .= html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'context', 'value' => $this->page->context->id]);
        }
        $this->content->text .= '<button type="submit" class="btn btn-primary mb-2"><span class="flaticon-magnifying-glass"></span></button>';
        $this->content->text .= html_writer::end_tag('fieldset');
        $this->content->text .= html_writer::end_tag('form');
        return $this->content;
    }
}
