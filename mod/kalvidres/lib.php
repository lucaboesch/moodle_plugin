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
 * Kaltura video resource library script.
 *
 * @package    mod_kalvidres
 * @author     Remote-Learner.net Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2014 Remote Learner.net Inc http://www.remote-learner.net
 */

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param object $kalvidres An object from the form in mod_form.php
 * @return int The id of the newly inserted kalvidassign record
 */
function kalvidres_add_instance($kalvidres) {
    global $DB, $CFG;
    require_once($CFG->dirroot.'/local/kaltura/locallib.php');

    $kalvidres->timecreated = time();
    $kalvidres->source = local_kaltura_build_kaf_uri($kalvidres->source);
    $kalvidres->id = $DB->insert_record('kalvidres', $kalvidres);

    return $kalvidres->id;
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @param object $kalvidres An object from the form in mod_form.php
 * @return boolean Success/Fail
 */
function kalvidres_update_instance($kalvidres) {
    global $DB, $CFG;
    require_once($CFG->dirroot.'/local/kaltura/locallib.php');

    $kalvidres->timemodified = time();
    $kalvidres->id = $kalvidres->instance;
    $kalvidres->source = local_kaltura_build_kaf_uri($kalvidres->source);
    $updated = $DB->update_record('kalvidres', $kalvidres);

    return $updated;
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 */
function kalvidres_delete_instance($id) {
    global $DB;

    if (! $kalvidres = $DB->get_record('kalvidres', ['id' => $id])) {
        return false;
    }

    $DB->delete_records('kalvidres', ['id' => $kalvidres->id]);

    return true;
}

/**
 * Return a small object with summary information about what a
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @param stdClass $course The course record.
 * @param stdClass $user The user record.
 * @param cm_info|stdClass $mod The course module info object or record.
 * @param stdClass $kalvidres The kalvidres instance record.
 * @return null
 * // phpcs:ignore moodle.Commenting.ValidTags.Invalid
 * @TODO Finish documenting this function
 */
function kalvidres_user_outline($course, $user, $mod, $kalvidres) {
    $return = new stdClass;
    $return->time = 0;
    $return->info = '';
    return $return;
}

/**
 * Print a detailed representation of what a user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * @param stdClass $course The course record.
 * @param stdClass $user The user record.
 * @param cm_info|stdClass $mod The course module info object or record.
 * @param stdClass $kalvidres The kalvidres instance record.
 * @return bool always return true.
 * // phpcs:ignore moodle.Commenting.ValidTags.Invalid
 * @TODO Finish documenting this function
 */
function kalvidres_user_complete($course, $user, $mod, $kalvidres) {
    return true;
}

/**
 * Given a course and a time, this module should find recent activity
 * that has occurred in kalvidres activities and print it out.
 * Return true if there was output, or false is there was none.
 *
 * @param mixed $course the course to print activity for
 * @param bool $viewfullnames boolean to determine whether to show full names or not
 * @param int $timestart the time the rendering started
 * @return bool Always returns false.
 * // phpcs:ignore moodle.Commenting.ValidTags.Invalid
 * @TODO Finish documenting this function
 * // phpcs:ignore moodle.Commenting.ValidTags.Invalid
 * @TODO Finish this function.
 */
function kalvidres_print_recent_activity($course, $viewfullnames, $timestart) {
    return false; // True if anything was printed, otherwise false.
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such
 * as sending out mail, toggling flags etc ...
 *
 * @return boolean
 */
function kalvidres_cron () {
    return false;
}

/**
 * Must return an array of users who are participants for a given instance
 * of kalvidres. Must include every user involved in the instance, independient
 * of his role (student, teacher, admin...). The returned objects must contain
 * at least id property. See other modules as example.
 *
 * @param int $kalvidresid ID of an instance of this module
 * @return boolean|array false if no participants, array of objects otherwise
 * // phpcs:ignore moodle.Commenting.ValidTags.Invalid
 * @TODO Finish this function.
 */
function kalvidres_get_participants($kalvidresid) {
    return false;
}

/**
 * List of features supported in mod_kalvidres module
 *
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, null if doesn't know
 */
function kalvidres_supports($feature) {
    switch($feature) {
        case FEATURE_MOD_ARCHETYPE:
            return MOD_ARCHETYPE_RESOURCE;
        case FEATURE_GROUPS:
            return true;
        case FEATURE_GROUPINGS:
            return true;
        case FEATURE_GROUPMEMBERSONLY:
            return true;
        case FEATURE_MOD_INTRO:
            return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS:
            return false;
        case FEATURE_GRADE_HAS_GRADE:
            return false;
        case FEATURE_GRADE_OUTCOMES:
            return false;
        case FEATURE_BACKUP_MOODLE2:
            return true;
        case FEATURE_SHOW_DESCRIPTION:
            return true;
        case FEATURE_MOD_PURPOSE:
            return MOD_PURPOSE_CONTENT;
        default:
            return null;
    }
}
