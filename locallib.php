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
 * block based function
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mfavatar
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
defined('MOODLE_INTERNAL') || die();

/**
 * load the module needed to make snapshots
 */
function block_mfavatar_add_javascript_module() {
    global $PAGE, $CFG, $USER;

    $config = get_config('block_mfavatar');

    // load swfobject 2.2
    $PAGE->requires->js(new moodle_url($CFG->wwwroot . '/blocks/mfavatar/js/swfobject.js'), true);

    $jsmodule = array(
        'name' => 'block_mfavatar',
        'fullpath' => '/blocks/mfavatar/module.js',
        'requires' => array( 'io-base',)
    );

    $PAGE->requires->js_init_call('M.block_mfavatar.init', array(
        $CFG->wwwroot . '/blocks/mfavatar/swf/snapshot.swf?' . time(),
        $CFG->wwwroot . '/blocks/mfavatar/swf/expressInstall.swf',
        array(
            'sessionid' => $USER->sesskey,
            'uploadPath' => $CFG->wwwroot . '/blocks/mfavatar/upload.php',
            'text_select_device' => get_string('flash:textselectdevice', 'block_mfavatar'),
            'text_make_snapshot' => get_string('flash:text_make_snapshot', 'block_mfavatar'),
            'text_result_field' => get_string('flash:text_result_field', 'block_mfavatar'),
            'text_feed_field' => get_string('flash:text_feed_field', 'block_mfavatar'),
            'failed_saving' => get_string('flash:failed_saving', 'block_mfavatar'),
            'success_saving' => get_string('flash:success_saving', 'block_mfavatar'),
        ),
        $config->webrtc_enabled
    ), false, $jsmodule);
}