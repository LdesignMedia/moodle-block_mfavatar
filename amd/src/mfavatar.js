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
 * AMD module for webcam snapshot and profile picture upload.
 *
 * Replaces the legacy YUI module.js. Uses navigator.mediaDevices.getUserMedia
 * (modern WebRTC) and the Fetch API to upload a base64 PNG snapshot to ajax.php.
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package
 * @copyright 21/03/2026 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 */

define(['core/notification'], function(Notification) {
    'use strict';

    return {
        /**
         * Initialise the webcam snapshot tool.
         *
         * @param {Object} options
         * @param {string} options.sessionid  Current user sesskey.
         * @param {string} options.uploadPath Full URL to ajax.php.
         */
        init: function(options) {
            var video = document.getElementById('video_webrtc');
            var canvas = document.getElementById('canvas_webrtc');
            var snapButton = document.getElementById('snapshot_btn');
            var holder = document.getElementById('snapshotholder_webrtc');

            // Guard: browser must support mediaDevices API.
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                Notification.addNotification({
                    message: 'WebRTC is not supported in your browser. Please use HTTPS and a modern browser.',
                    type: 'error'
                });
                return;
            }

            // Camera access requires a secure context (HTTPS or localhost).
            if (location.protocol !== 'https:' && location.hostname !== 'localhost') {
                Notification.addNotification({
                    message: 'Camera access requires HTTPS.',
                    type: 'error'
                });
                return;
            }

            // Show the snapshot holder now that we know WebRTC is available.
            if (holder) {
                holder.style.display = 'block';
            }

            // Start the webcam stream.
            navigator.mediaDevices.getUserMedia({
                video: {
                    width: {ideal: 480},
                    height: {ideal: 480}
                },
                audio: false
            }).then(function(mediaStream) {
                video.srcObject = mediaStream;
                video.play();
            }).catch(function(err) {
                Notification.addNotification({
                    message: 'Could not access camera: ' + err.message,
                    type: 'error'
                });
            });

            // Snapshot button handler.
            if (snapButton) {
                snapButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    if (!video.srcObject) {
                        return;
                    }

                    // Draw current video frame onto the canvas.
                    var context = canvas.getContext('2d');
                    canvas.width = 480;
                    canvas.height = 480;
                    context.drawImage(video, 0, 0, 480, 480);

                    // Encode the frame as a base64 PNG data URL.
                    var dataUrl = canvas.toDataURL('image/png');

                    // Post to ajax.php using the same parameter names expected by the server
                    // (see ajax.php: required_param('file', PARAM_RAW) and confirm_sesskey()).
                    var formData = new FormData();
                    formData.append('sesskey', options.sessionid);
                    formData.append('file', dataUrl);

                    fetch(options.uploadPath, {
                        method: 'POST',
                        body: formData
                    }).then(function(response) {
                        return response.json();
                    }).then(function(data) {
                        // Server response shape: {status: bool, img: string, errors: []}
                        if (data.status) {
                            // Bust the cache on all profile picture images so the new
                            // avatar is visible immediately without a full page reload.
                            var profilePics = document.querySelectorAll('img.userpicture');
                            profilePics.forEach(function(img) {
                                img.src = data.img || (img.src.split('?')[0] + '?t=' + Date.now());
                            });
                            Notification.addNotification({
                                message: 'Profile picture updated successfully.',
                                type: 'success'
                            });
                        } else {
                            var errorMsg = (data.errors && data.errors.length > 0)
                                ? data.errors.join(' ')
                                : 'Failed to upload image.';
                            Notification.addNotification({
                                message: errorMsg,
                                type: 'error'
                            });
                        }
                    }).catch(function(err) {
                        Notification.addNotification({
                            message: 'Upload failed: ' + err.message,
                            type: 'error'
                        });
                    });
                });
            }
        }
    };
});
