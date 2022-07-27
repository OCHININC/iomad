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

require_once($CFG->dirroot . '/blocks/myoverview/classes/output/renderer.php');
require_once($CFG->dirroot . '/theme/edumy/ccn/mdl_handler/ccn_mdl_handler.php');

use \block_myoverview\output\main;


class block_myoverview_renderer extends \block_myoverview\output\renderer {


  /**
   * Return the image URL, if any.
   *
   * Note that maximum sizes are not applied to the image.
   *
   * @param int $maxwidth The maximum width, or null when the maximum width does not matter.
   * @param int $maxheight The maximum height, or null when the maximum height does not matter.
   * @return moodle_url|false
   */
   public function render_main(main $main) {

      $ccnMdlHandler = new \ccnMdlHandler();
      $ccnMdlVersion = $ccnMdlHandler->ccnGetCoreVersion();
      $ccnMdlVersion = (int)$ccnMdlVersion;
      if($ccnMdlVersion >= 400) {
        return $this->render_from_template('theme_edumy/ccn_mdl_400/block_myoverview/main', $main->export_for_template($this));
      } else {
        return $this->render_from_template('block_myoverview/main', $main->export_for_template($this));
      }
   }

}
