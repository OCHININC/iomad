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

namespace theme_edumy\output;

defined('MOODLE_INTERNAL') || die;


require_once($CFG->dirroot . '/mod/forum/renderer.php');
require_once($CFG->dirroot . '/theme/edumy/ccn/mdl_handler/ccn_mdl_handler.php');
class mod_forum_renderer extends \mod_forum_renderer {


  /**
   * Return the image URL, if any.
   *
   * Note that maximum sizes are not applied to the image.
   *
   * @param int $maxwidth The maximum width, or null when the maximum width does not matter.
   * @param int $maxheight The maximum height, or null when the maximum height does not matter.
   * @return moodle_url|false
   */
   // public function render_quick_search_form(\mod_forum\output\quick_search_form $form) {
   //     if (strpos($this->page->url->get_path(), "index.php")) {
   //         return $this->render_from_template('mod_forum/quick_search_form', $form->export_for_template($this));
   //     }
   //
   //     return $this->render_from_template('mod_forum/forum_new_discussion_actionbar', $form->export_for_template($this));
   // }


   public function render_quick_search_form(\mod_forum\output\quick_search_form $form) {
     $ccnMdlHandler = new \ccnMdlHandler();
     $ccnGetCoreVersion = $ccnMdlHandler->ccnGetCoreVersion();
     $ccnGetCoreVersion = (int)$ccnGetCoreVersion;

     if($ccnGetCoreVersion >= 400) {
      if (strpos($this->page->url->get_path(), "index.php")) {
        return $this->render_from_template('mod_forum/quick_search_form_400', $form->export_for_template($this));
      }
      return $this->render_from_template('mod_forum/forum_new_discussion_actionbar', $form->export_for_template($this));
     } else {
       if($ccnGetCoreVersion >= 311) return $this->render_from_template('mod_forum/quick_search_form_311', $form->export_for_template($this));
       return $this->render_from_template('mod_forum/quick_search_form', $form->export_for_template($this));
     }




   }

}
