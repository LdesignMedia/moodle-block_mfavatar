<?php
/**
 * File: locallib.php
 * Encoding: UTF8
 * @package: MFavatar
 *
 * @Version: 1.0.0
 * @Since  25-2-2015
 * @Author : MoodleFreak.com | Ldesign.nl - Luuk Verhoeven
 *
 **/
defined('MOODLE_INTERNAL') || die();

/**
 * load the module needed to make snapshots
 */
function block_mfavatar_add_javascript_module()
{
    global $PAGE, $CFG , $USER;

    //load swfobject 2.2
    $PAGE->requires->js(new moodle_url($CFG->wwwroot . '/blocks/mfavatar/js/swfobject.js') , true);

    $jsmodule = array(
        'name' => 'block_mfavatar',
        'fullpath' => '/blocks/mfavatar/module.js',
        'requires' => array()
    );

    $PAGE->requires->js_init_call('M.block_mfavatar.init', array(
        $CFG->wwwroot . '/blocks/mfavatar/swf/snapshot.swf?' . time(),
        $CFG->wwwroot . '/blocks/mfavatar/swf/expressInstall.swf',
        array(
            'sessionid' => $USER->sesskey ,
            'uploadPath' => $CFG->wwwroot . '/blocks/mfavatar/upload.php',
            'text_select_device' => get_string('flash:textselectdevice' , 'block_mfavatar'),
            'text_make_snapshot' => get_string('flash:text_make_snapshot' , 'block_mfavatar'),
            'text_result_field' => get_string('flash:text_result_field' , 'block_mfavatar'),
            'text_feed_field' => get_string('flash:text_feed_field' , 'block_mfavatar'),
            'failed_saving' => get_string('flash:failed_saving' , 'block_mfavatar'),
            'success_saving' => get_string('flash:success_saving' , 'block_mfavatar'),
            )
    ), false, $jsmodule);
}