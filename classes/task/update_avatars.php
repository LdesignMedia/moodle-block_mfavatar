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
 * Task to generate avatars.
 *
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mfavatar
 * @copyright 2018 MFreak.nl
 * @author    Luuk Verhoeven
 **/

namespace block_mfavatar\task;

use block_mfavatar\avatargenerator;
use core\task\scheduled_task;

defined('MOODLE_INTERNAL') || die;

/**
 * Class update_avatars
 *
 * @package   block_mfavatar
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Luuk Verhoeven
 *
 */
class update_avatars extends scheduled_task {

    /**
     * @return string
     * @throws \coding_exception
     */
    public function get_name() {
        return get_string('task:update_avatars', 'block_mfavatar');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     *
     * @throws \dml_exception
     */
    public function execute() {

        $enabled = get_config('block_mfavatar', 'avatar_initials');
        if (empty($enabled)) {
            return true;
        }

        $avatargenerator = new avatargenerator();
        $avatargenerator->set_avatar_for_all_users();

        return true;
    }
}