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
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     */
    public function add_javascript_module() : void {
        global $CFG, $USER;

        $jsmodule = [
            'name' => 'block_mfavatar',
            'fullpath' => '/blocks/mfavatar/module.js',
            'requires' => ['io-base'],
        ];

        $this->page->requires->js_init_call('M.block_mfavatar.init', [
            [
                'sessionid' => $USER->sesskey,
                'uploadPath' => $CFG->wwwroot . '/blocks/mfavatar/ajax.php',
                'text_select_device' => get_string('flash:textselectdevice', 'block_mfavatar'),
                'text_make_snapshot' => get_string('flash:text_make_snapshot', 'block_mfavatar'),
                'text_result_field' => get_string('flash:text_result_field', 'block_mfavatar'),
                'text_feed_field' => get_string('flash:text_feed_field', 'block_mfavatar'),
                'failed_saving' => get_string('flash:failed_saving', 'block_mfavatar'),
                'success_saving' => get_string('flash:success_saving', 'block_mfavatar'),
            ],
        ], false, $jsmodule);
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
                    <video autoplay></video>
                    <div id="previewholder">
                        <canvas id="render"></canvas>
                        <canvas id="preview"></canvas>
                    </div>
                 </div>
                 <div class="pt-3 clearboth">
                    <button id="snapshot" class="btn btn-primary">' .
                        get_string('flash:text_make_snapshot', 'block_mfavatar') . '</button>
                                <a href="' . $CFG->wwwroot . '/user/profile.php?id=' . $USER->id . '" class="btn btn-info">' .
                        get_string('returntoprofile', 'block_mfavatar') . '</a>
                 </div>';
    }

}
