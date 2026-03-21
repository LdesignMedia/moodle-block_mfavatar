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

/**
 * html render class
 *
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mfavatar
 * @copyright 2015 MFreak.nl
 * @author    Luuk Verhoeven
 **/
defined('MOODLE_INTERNAL') || die;

/**
 * Class block_mfavatar_renderer
 *
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mfavatar
 * @copyright 2015 MFreak.nl
 * @author    Luuk Verhoeven
 */
class block_mfavatar_renderer extends plugin_renderer_base {

    /**
     * add_javascript_module
     *
     * Loads the AMD module block_mfavatar/mfavatar and passes the options
     * required for webcam initialisation and AJAX upload.
     *
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     */
    public function add_javascript_module() : void {
        global $CFG;

        $options = [
            'sessionid' => sesskey(),
            'uploadPath' => $CFG->wwwroot . '/blocks/mfavatar/ajax.php',
        ];

        $this->page->requires->js_call_amd('block_mfavatar/mfavatar', 'init', [$options]);
    }

    /**
     * Add the snapshot tool
     *
     * @return string
     * @throws coding_exception
     */
    public function snapshot_tool() : string {
        // TODO Convert to mustache.
        global $USER, $CFG; // Used for the profile link.

        return '<div id="snapshotholder_webrtc" style="display: none;">
                    <video id="video_webrtc" autoplay></video>
                    <div id="previewholder">
                        <canvas id="canvas_webrtc"></canvas>
                    </div>
                 </div>
                 <div class="pt-3 clearboth">
                    <button id="snapshot_btn" class="btn btn-primary">' .
                        get_string('flash:text_make_snapshot', 'block_mfavatar') . '</button>
                    <a href="' . $CFG->wwwroot . '/user/profile.php?id=' . s($USER->id) . '" class="btn btn-info">' .
                        get_string('returntoprofile', 'block_mfavatar') . '</a>
                 </div>';
    }

}

