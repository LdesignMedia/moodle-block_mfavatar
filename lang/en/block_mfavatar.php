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
 * EN lang
 *
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mfavatar
 * @copyright 2015 MFreak.nl
 * @author    Luuk Verhoeven
 **/
defined('MOODLE_INTERNAL') || die;

$string['mfavatar:addinstance'] = 'Add a avatar snapshot tool';
$string['mfavatar:myaddinstance'] = 'Add a new avatar snapshot block to My home';
$string['mfavatar:view'] = 'View Mfavatar';

$string['pluginname'] = 'Mfreak Avatar';
$string['makesnapshot'] = 'Make Snapshot';
$string['snapshotpage'] = 'Snapshot';
$string['installflash'] = 'Please install flash';

$string['flash:textselectdevice'] = 'Please select your camera device:';
$string['flash:text_make_snapshot'] = 'Save snapshot';
$string['flash:text_feed_field'] = 'Your camera feed';
$string['flash:text_result_field'] = 'Your result';
$string['flash:failed_saving'] = 'Error saving your snapshot!!';
$string['flash:success_saving'] = 'Snapshot saved!!!';

$string['failed:disableuserimages'] = 'Error: Site has disabeld user images';
$string['failed'] = 'Error: Failed Uploading';
$string['failed:sesskey'] = 'Error: failed saving you are still logged? Refresh the page and retry';
$string['failed:permission_editownprofile'] = 'Error: User can\'t change their images';

$string['pluginname_desc'] = 'Customize Mfreak avatar below.';

$string['privacy:null_reason'] = 'No data collected by this plugin.';

$string['avatar_initials'] = 'Initials avatars';
$string['avatar_initials_desc'] = 'Display unique avatar for any user based on their (initials) name.
Uses the cron to and user update event to set user profile picture.';
$string['avatar_initials_forced'] = 'Override user picture';
$string['avatar_initials_forced_desc'] = 'If this is turned on the user pictures will overridden.';
$string['task:update_avatars'] = 'Update user avatars';
$string['returntoprofile'] = 'Return to your profile';
