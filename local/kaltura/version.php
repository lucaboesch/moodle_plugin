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
 * Kaltura version file.
 *
 * @package    local_kaltura
 * @author     Remote-Learner.net Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2014 Remote Learner.net Inc http://www.remote-learner.net
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version = 2024042201;
$plugin->component = 'local_kaltura';
$plugin->release = 'Kaltura release 4.4.9';
$plugin->requires = 2024042200;
$plugin->maturity = MATURITY_STABLE;

try {
    global $DB;

    $localkalturapluginversionrecord = $DB->get_records_select('config_plugins', "plugin = 'local_kaltura' AND name = 'version'");

    $kalturapluginversion = "";
    if ($localkalturapluginversionrecord) {
        $localkalturapluginversionrecordvalue = array_pop($localkalturapluginversionrecord);
        $kalturapluginversion = $localkalturapluginversionrecordvalue->value;
    }

    $updatedversion = null;
    if ($kalturapluginversion == 20210620311) {
        $updatedversion = 2021051700;
    } else if ($kalturapluginversion == 20201215310 || $kalturapluginversion == 20210620310) {
        $updatedversion = 2020110900;
    } else if ($kalturapluginversion == 2020070539 || $kalturapluginversion == 2020121539 || $kalturapluginversion == 2021062039) {
        $updatedversion = 2020061500;
    }

    if (!empty($updatedversion)) {
        $pluginsrecords = $DB->get_records_select('config_plugins', "plugin in ('local_kaltura',
        'local_kalturamediagallery', 'local_mymedia', 'atto_kalturamedia','block_kalturamediagallery','filter_kaltura',
        'tinymce_kalturamedia','mod_kalvidassign','mod_kalvidres', 'tiny_kalturamedia')
        AND name = 'version' AND value = '$kalturapluginversion'");

        foreach ($pluginsrecords as $record) {
            $record->value = $updatedversion;
            $DB->update_record('config_plugins', $record);
        }
    }
} catch (Exception $e) {
    return;
}
