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
 * html render class
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mfavatar
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
class block_mfavatar_renderer extends plugin_renderer_base {

    /**
     * add the snapshot tool
     *
     * @return string
     * @throws coding_exception
     */
    public function snapshot_tool() {
        $html = '<div id="snapshotholder" style="display: none;">
                    <div id="snapshot">
                        <h1>' . get_string('installflash', 'block_mfavatar') . '</h1>
                        <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
                    </div>
                </div>';

        //add webrtc container
        $html .= '<div id="snapshotholder_webrtc" style="display: none;">
                    <video autoplay></video>
                    <div id="previewholder">
                        <canvas id="render"></canvas>
                        <canvas id="preview"></canvas>
                    </div>
                    <hr/>
                    <button id="snapshot">' . get_string('flash:text_make_snapshot', 'block_mfavatar') . '</button>
                    <hr/>
                  </div>';

        return $html;
    }

}