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
define('NO_DEBUG_DISPLAY', true);

require('../../config.php');
require_once("$CFG->libdir/gdlib.php");

try {
    require_login(get_site(), true, null, true, true);
} catch (Exception $exc) {
    die('failed:login');
}

$file = required_param('file', PARAM_RAW);
$sessionid = required_param('sesskey', PARAM_RAW);

if (!confirm_sesskey($sessionid)) {
    die('failed:sesskey');
}

$file = base64_decode($file);
$context = context_user::instance($USER->id, MUST_EXIST);

$tempfile = tempnam(sys_get_temp_dir(), 'mfavatar');
file_put_contents($tempfile, $file);

$newpicture = (int)process_new_icon($context, 'user', 'icon', 0, $tempfile);
if ($newpicture != $USER->picture) {
    $DB->set_field('user', 'picture', $newpicture, array('id' => $USER->id));
    echo 'success';
} else {
    echo 'failed';
}

@unlink($tempfile);