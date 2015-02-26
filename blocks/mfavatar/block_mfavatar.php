<?php
/**
 * File: block_mfavatar.php
 * Encoding: UTF8
 * @package: MFavatar
 *
 * @Version: 1.0.0
 * @Since 23-2-2015
 * @Author: MoodleFreak.com | Ldesign.nl - Luuk Verhoeven
 *
 **/
defined('MOODLE_INTERNAL') || die();

class block_mfavatar extends block_base
{

    function init()
    {
        $this->title = get_string('pluginname', 'block_mfavatar');
    }

    function instance_allow_multiple()
    {
        return false;
    }

    function has_config()
    {
        return true;
    }

    function applicable_formats()
    {
        return array('my' => true,);
    }

    function instance_allow_config()
    {
        return true;
    }

    function specialization()
    {

        // load userdefined title and make sure it's never empty
        if (empty($this->config->title))
        {
            $this->title = get_string('pluginname', 'block_mfavatar');
        }
        else
        {
            $this->title = $this->config->title;
        }
    }

    function get_content()
    {
        global $CFG , $COURSE;

        require_once $CFG->libdir . '/formslib.php';

        if ($this->content !== NULL)
        {
            return $this->content;
        }

        if ((!isloggedin() || isguestuser() || !has_capability('block/mfavatar:view', context_system::instance())))
        {
            $this->content = new stdClass();
            $this->content->text = '';
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '<div class="singlebutton">
                                    <form action="' . $CFG->wwwroot . '/blocks/mfavatar/view.php" method="get">
                                      <div>
                                        <input type="hidden" name="blockid" value="'.$this->instance->id.'"/>
                                        <input type="hidden" name="courseid" value="'.$COURSE->id.'"/>
                                        <input class="singlebutton" type="submit" value="' . get_string('makesnapshot', 'block_mfavatar') . '"/>
                                      </div>
                                    </form>
                                  </div>';
        $this->content->footer = '';
        return $this->content;
    }
}