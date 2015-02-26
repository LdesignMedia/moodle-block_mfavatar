<?php
/**
 * File: view.php
 * Encoding: UTF8
 * @package: MFavatar
 *
 * @Version: 1.0.0
 * @Since 25-2-2015
 * @Author: MoodleFreak.com | Ldesign.nl - Luuk Verhoeven
 * 
 **/
require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_login();

$courseid = required_param('courseid', PARAM_INT); //if no courseid is given
$parentcourse = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

$context = context_course::instance($courseid);
$PAGE->set_course($parentcourse);
$PAGE->set_url('/blocks/mfavatar/view.php');
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('incourse');
$PAGE->set_title(get_string('snapshotpage', 'block_mfavatar'));
$PAGE->navbar->add(get_string('snapshotpage', 'block_mfavatar'));
$PAGE->requires->css('/blocks/mfavatar/styles.css');
//add need javascripts
block_mfavatar_add_javascript_module();


$renderer = $PAGE->get_renderer('block_mfavatar');

echo $OUTPUT->header();
echo $renderer->snapshot_tool();
echo $OUTPUT->footer();