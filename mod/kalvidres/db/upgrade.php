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
 * Kaltura video assignment upgrade script.
 *
 * @package    mod_kalvidres
 * @author     Remote-Learner.net Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2014 Remote Learner.net Inc http://www.remote-learner.net
 */

/**
 * Upgrade the plugin.
 *
 * @param int $oldversion
 * @return bool always true
 */
function xmldb_kalvidres_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2018112735) {
        // Changing precision of field video_title on table kalvidres to (256).
        $table = new xmldb_table('kalvidres');
        $field = new xmldb_field('video_title', XMLDB_TYPE_CHAR, '256', null, XMLDB_NOTNULL, null, null, 'entry_id');

        // Launch change of precision for field video_title.
        $dbman->change_field_precision($table, $field);

        // Kalvidres savepoint reached.
        upgrade_mod_savepoint(true, 2018112735, 'kalvidres');
    }

    if ($oldversion < 2011110702) {

        // Changing type of field intro on table kalvidres to text.
        $table = new xmldb_table('kalvidres');
        $field = new xmldb_field('intro', XMLDB_TYPE_TEXT, 'small', null, null, null, null, 'name');

        // Launch change of type for field intro.
        $dbman->change_field_type($table, $field);

        // Kalvidres savepoint reached.
        upgrade_mod_savepoint(true, 2011110702, 'kalvidres');
    }

    if ($oldversion < 2014013000) {

        // Define field source to be added to kalvidres.
        $table = new xmldb_table('kalvidres');
        $field = new xmldb_field('source', XMLDB_TYPE_TEXT, null, null, null, null, null, 'width');

        // Conditionally launch add field source.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Kalvidres savepoint reached.
        upgrade_mod_savepoint(true, 2014013000, 'kalvidres');
    }

    if ($oldversion < 2014023000.01) {

        // Define field metadata to be added to kalvidres.
        $table = new xmldb_table('kalvidres');
        $field = new xmldb_field('metadata', XMLDB_TYPE_TEXT, null, null, null, null, null, 'source');

        // Conditionally launch add field metadata.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Kalvidassign savepoint reached.
        upgrade_mod_savepoint(true, 2014023000.01, 'kalvidres');
    }

    return true;
}
