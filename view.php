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
 * snapshot view page
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mfavatar
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_login();

$courseid = required_param('courseid', PARAM_INT); // if no courseid is given
$parentcourse = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

$context = context_course::instance($courseid);
$PAGE->set_course($parentcourse);
$PAGE->set_url('/blocks/mfavatar/view.php');
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('incourse');
$PAGE->set_title(get_string('snapshotpage', 'block_mfavatar'));
$PAGE->navbar->add(get_string('snapshotpage', 'block_mfavatar'));
$PAGE->requires->css('/blocks/mfavatar/styles.css');

block_mfavatar_add_javascript_module();

$renderer = $PAGE->get_renderer('block_mfavatar');

echo $OUTPUT->header();

if ($CFG->disableuserimages) {
    print_error("disableuserimages", 'block_mfavatar');
}

echo $renderer->snapshot_tool();
echo $OUTPUT->footer();