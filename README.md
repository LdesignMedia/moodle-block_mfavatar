## Moodle MFavatar Snapshot/Webcam tool for user profile picture

Briefly, the Mfreak Plugin Avatar gives the user the possibility to take a snapshot with a live webcam. The user can then upload the picture and modify his profile picture at any time. Besides this, there is also the facility to auto generate Avatars. 

## Author
![MFreak.nl](https://MFreak.nl/logo_small.png)

* Author: Luuk Verhoeven, [MFreak.nl](https://www.MFreak.nl/)
* Min. required: Moodle 3.5.x
* Supports PHP: 7.2 

[![Build Status](https://travis-ci.org/MFreakNL/moodle-block_mfavatar.svg?branch=moodle35)](https://travis-ci.org/MFreakNL/moodle-block_mfavatar)
![Moodle35](https://img.shields.io/badge/moodle-3.5-brightgreen.svg)
![Moodle36](https://img.shields.io/badge/moodle-3.6-brightgreen.svg)
![Moodle37](https://img.shields.io/badge/moodle-3.7-brightgreen.svg)
![Moodle38](https://img.shields.io/badge/moodle-3.8-brightgreen.svg)
![Moodle39](https://img.shields.io/badge/moodle-3.9-brightgreen.svg)
![Moodle310](https://img.shields.io/badge/moodle-3.10-brightgreen.svg)
![PHP7.2](https://img.shields.io/badge/PHP-7.2-brightgreen.svg)


## List of features
- WebRTC, make snapshot with webcam. 
- Flash, make snapshot with webcam. 
- Feature for making automatically user avatars. Thanks to `laravolt/avatar`
<!-- copy and paste. Modify height and width if desired. --> <a href="https://content.screencast.com/users/LuukVerhoeven/folders/Default/media/3cab1cd8-f5f0-448e-955d-ab8f3bc4cbb2/06.07.2018-18.36.png"><img class="embeddedObject" src="https://content.screencast.com/users/LuukVerhoeven/folders/Default/media/3cab1cd8-f5f0-448e-955d-ab8f3bc4cbb2/06.07.2018-18.36.png" width="500" border="0" /></a>

## TODO 
- Convert `ajax.php` to native ajax webservices
- Gravatar support
- Convert `module.js` to an AMD module

## Installation
1.  Copy this plugin to the `block\mfavatar` folder on the server
2.  Login as administrator
3.  Go to Site Administrator > Notification
4.  Install the plugin
5.  You will need to fill out the settings.

## Security

If you discover any security related issues, please email [luuk@MFreak.nl](mailto:luuk@MFreak.nl) instead of using the issue tracker.

## License

The GNU GENERAL PUBLIC LICENSE. Please see [License File](LICENSE) for more information.

## Contributing

Contributions are welcome and will be fully credited. We accept contributions via Pull Requests on Github.


## Changelog

- 2020111800 Tested in Moodle310 fix issues, update composer to use the latest dependencies.
- 2020050900 Default capability set to user, fix configuration difficulties.  
- 2020050900 Using WEBRTC as default, remove flash from this project.
- 2018092600 Thanks for updating WEBRTC  @[eglescout](https://github.com/eglescout)
- 2019051400 Thanks for solving issue in image override @[matasarei](https://github.com/matasarei)
