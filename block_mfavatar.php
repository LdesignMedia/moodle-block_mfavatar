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
 * Snapshot block contains the button to go to snapshot view page
 *
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mfavatar
 * @copyright 2015 MFreak.nl
 * @author    Luuk Verhoeven
 **/
defined('MOODLE_INTERNAL') || die;

/**
 * Class block_mfavatar
 */
class block_mfavatar extends block_base {

    /**
     * init
     *
     * @throws coding_exception
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_mfavatar');
    }

    /**
     * instance_allow_multiple
     *
     * @return bool
     */
    public function instance_allow_multiple() {
        return false;
    }

    /**
     * has_config
     *
     * @return bool
     */
    public function has_config() {
        return true;
    }

    /**
     * applicable_formats
     *
     * @return array
     */
    public function applicable_formats() {
        return [
            'my' => true,
            'all' => true,
        ];
    }

    /**
     * instance_allow_config
     *
     * @return bool
     */
    public function instance_allow_config() {
        return true;
    }

    /**
     * specialization
     *
     * @throws coding_exception
     */
    public function specialization() {

        // Load userdefined title and make sure it's never empty.
        if (empty($this->config->title)) {
            $this->title = get_string('pluginname', 'block_mfavatar');
        } else {
            $this->title = $this->config->title;
        }
    }

    /**
     * get_content
     *
     * @return stdClass|stdObject
     * @throws coding_exception
     * @throws dml_exception
     */
    public function get_content() {
        global $CFG, $COURSE;

        require_once($CFG->libdir . '/formslib.php');

        if ($this->content !== null) {
            return $this->content;
        }

        $systemcontext = context_system::instance();
        if ((!isloggedin() || isguestuser() || !has_capability('block/mfavatar:view', $systemcontext)) ||
            !has_capability('moodle/user:editownprofile', $systemcontext) || $CFG->disableuserimages) {
            $this->content = new stdClass();
            $this->content->text = '';

            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '<div class="singlebutton">
                                    <form action="' . $CFG->wwwroot . '/blocks/mfavatar/view/view.php" method="get">
                                      <div>
                                        <input type="hidden" name="blockid" value="' . $this->instance->id . '"/>
                                        <input type="hidden" name="courseid" value="' . $COURSE->id . '"/>
                                        <input class="singlebutton btn btn-primary" type="submit" value="' .
            get_string('makesnapshot', 'block_mfavatar') . '"/>
                                      </div>
                                    </form>
                                  </div>';
        $this->content->footer = '';

        return $this->content;
    }
}
