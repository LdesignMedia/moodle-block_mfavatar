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
 * Settings
 *
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mfavatar
 * @copyright 2015 MFreak.nl
 * @author    Luuk Verhoeven
 **/
defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_heading('block_mfavatar_settings', '',
        get_string('pluginname_desc', 'block_mfavatar')));

    $settings->add(new admin_setting_configcheckbox('block_mfavatar/avatar_initials',
        get_string('avatar_initials', 'block_mfavatar'),
        get_string('avatar_initials_desc', 'block_mfavatar'), 0));

    $settings->add(new admin_setting_configcheckbox('block_mfavatar/avatar_initials_forced',
        get_string('avatar_initials_forced', 'block_mfavatar'),
        get_string('avatar_initials_forced_desc', 'block_mfavatar'), 0));
}