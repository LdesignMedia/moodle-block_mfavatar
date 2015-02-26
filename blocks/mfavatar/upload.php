<?php
/**
 * File: upload.php
 * Encoding: UTF8
 * @package: MFavatar
 *
 * @Version: 1.0.0
 * @Since  25-2-2015
 * @Author : MoodleFreak.com | Ldesign.nl - Luuk Verhoeven
 *
 **/
define('NO_DEBUG_DISPLAY', true);

require('../../config.php');
require_once("$CFG->libdir/gdlib.php");

try{
    require_login(get_site() ,  true,  null,  true,  true);
}
catch (Exception $exc)
{
    die('failed:login');
}

$file = required_param('file', PARAM_RAW);
$sessionid = required_param('sesskey', PARAM_RAW);

if (!confirm_sesskey($sessionid))
{
    die('failed:sesskey');
}

$file = base64_decode($file);
$context = context_user::instance($USER->id, MUST_EXIST);

$tempfile = tempnam(sys_get_temp_dir(), 'mfavatar');
file_put_contents($tempfile , $file);

$newpicture = (int)process_new_icon($context, 'user', 'icon', 0, $tempfile);
if ($newpicture != $USER->picture)
{
    $DB->set_field('user', 'picture', $newpicture, array('id' => $USER->id));
    echo 'success';
}
else
{
    echo 'failed';
}

@unlink($tempfile);