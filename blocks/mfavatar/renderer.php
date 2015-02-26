<?php

/**
 * File: renderer.php
 * Encoding: UTF8
 * @package: MFavatar
 *
 * @Version: 1.0.0
 * @Since  25-2-2015
 * @Author : MoodleFreak.com | Ldesign.nl - Luuk Verhoeven
 *
 **/
class block_mfavatar_renderer extends plugin_renderer_base
{
    /**
     * add the snapshot tool
     * @return string
     * @throws coding_exception
     */
    public function snapshot_tool()
    {
        $html = '<div id="snapshotholder">
                    <div id="snapshot">
                        <h1>' . get_string('installflash', 'block_mfavatar') . '</h1>
                        <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
                    </div>
                </div>
                ';

        return $html;
    }

}