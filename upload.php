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
 * snapshot upload handler
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mfavatar
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/

if (!defined('AJAX_SCRIPT')) {
    define('AJAX_SCRIPT', true);
}
define('NO_DEBUG_DISPLAY', true);

require('../../config.php');
require_once("$CFG->libdir/gdlib.php");
$PAGE->set_url('/blocks/mfavatar/upload.php');

require_login(get_site(), true, null, true, true);
$file = required_param('file', PARAM_RAW);
$sessionid = required_param('sesskey', PARAM_RAW);
$systemcontext = context_system::instance();
$array = array('errors' => array(), 'status' => false);

echo $OUTPUT->header(); // Send headers.

if ($CFG->disableuserimages) {

    $array['errors'][] = get_string('failed:disableuserimages', 'block_mfavatar');

} elseif (!has_capability('moodle/user:editownprofile', $systemcontext)) {

    $array['errors'][] = get_string('failed:permission_editownprofile', 'block_mfavatar');

} elseif (!confirm_sesskey($sessionid)) {

    $array['errors'][] = get_string('failed:sesskey', 'block_mfavatar');
}

if(empty($array['errors'])) {

    if(stristr($file , 'base64,' )){
        //convert webrtc
        $file =  explode('base64,',$file);
        $file = end($file);
    }

    //decode
    $file = base64_decode($file);

    if(empty($file)){
        $array['errors'][] = get_string('failed', 'block_mfavatar');
        die(json_encode($array));
    }

    $context = context_user::instance($USER->id, MUST_EXIST);

    $tempfile = tempnam(sys_get_temp_dir(), 'mfavatar');
    file_put_contents($tempfile, $file);

    $newpicture = (int)process_new_icon($context, 'user', 'icon', 0, $tempfile);
    if ($newpicture != $USER->picture) {
        $DB->set_field('user', 'picture', $newpicture, array('id' => $USER->id));
        $array['status'] = true;
    } else {
        $array['errors'][] = get_string('failed', 'block_mfavatar');
    }

    @unlink($tempfile);
}

echo json_encode($array);