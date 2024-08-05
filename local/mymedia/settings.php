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
 * Kaltura my Media settings.
 *
 * @package    local_mymedia
 * @author     Remote-Learner.net Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2014 Remote Learner.net Inc http://www.remote-learner.net
 */

defined('MOODLE_INTERNAL') || die('Invalid access');

global $CFG;
require_once($CFG->dirroot. '/local/mymedia/lib.php');

if ($hassiteconfig) {
    $settings = new admin_settingpage(
        'local_mymedia',
        get_string('pluginname', 'local_mymedia')
    );

    // Heading.
    $setting = new admin_setting_heading(
        'heading',
        '', get_string('setting_heading_desc', 'local_mymedia')
    );
    $setting->plugin = 'local_mymedia';
    $settings->add($setting);

    // Link location.
    $setting = new admin_setting_configselect(
        'link_location',
        get_string('link_location', 'local_mymedia'),
        get_string('link_location_desc', 'local_mymedia'),
        LOCAL_KALTURAMYMEDIA_LINK_LOCATION_TOP_NAVIGATION_MENU,
        [
            LOCAL_KALTURAMYMEDIA_LINK_LOCATION_TOP_NAVIGATION_MENU => get_string('link_location_top_menu', 'local_mymedia'),
            LOCAL_KALTURAMYMEDIA_LINK_LOCATION_SIDE_NAVIGATION_MENU => get_string('link_location_side_menu', 'local_mymedia'),
        ]
    );
    $setting->plugin = 'local_mymedia';
    $settings->add($setting);

    $ADMIN->add('localplugins', $settings);
}
