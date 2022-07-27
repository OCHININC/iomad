<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_globalsearch_sb extends block_base {

    /**
     * Initialises the block.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_cocoon_globalsearch_sb');
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

        $this->content = new stdClass();
        $this->content->footer = '';
        $this->content->text = '';

        if (\core_search\manager::is_global_search_enabled() === false) {
            $this->content->text .= get_string('globalsearchdisabled', 'search');
            return $this->content;
        }

        $url = new moodle_url('/search/index.php');

        $this->content->text .= html_writer::start_tag('form', array('action' => $url->out()));
        $this->content->text .= html_writer::start_tag('fieldset');

        $this->content->text .= '						<div class="blog_search_widget">
							<div class="input-group mb-3">';
        // Input.
        $inputoptions = array('id' => 'searchform_search', 'name' => 'q', 'class' => 'form-control', 'placeholder' => get_string('search', 'search'),
            'type' => 'text', 'size' => '15');
        $this->content->text .= html_writer::empty_tag('input', $inputoptions);

        // Context id.
        if ($this->page->context && $this->page->context->contextlevel !== CONTEXT_SYSTEM) {
            $this->content->text .= html_writer::empty_tag('input', ['type' => 'hidden',
                    'name' => 'context', 'value' => $this->page->context->id]);
        }

        $this->content->text .= '					<div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit" id="searchform_button"><span class="flaticon-magnifying-glass"></span></button>
        </div>
      </div>
    </div>';
        $this->content->text .= html_writer::end_tag('fieldset');
        $this->content->text .= html_writer::end_tag('form');
        return $this->content;
    }
}
