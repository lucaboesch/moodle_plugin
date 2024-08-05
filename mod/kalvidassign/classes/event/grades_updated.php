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
 * The grades_updated event.
 *
 * @package    mod_kalvidassign
 * @copyright  2015 Rex Lorenzo <rexlorenzo@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_kalvidassign\event;

/**
 * The grades_updated event class.
 *
 * @property-read array $other {
 *      'crud'  => string 'c', 'r', 'u', or 'd', depending on context the event is triggered in
 * }
 *
 * @since     Moodle 2.7
 * @copyright 2015 Rex Lorenzo <rexlorenzo@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 **/
class grades_updated extends \core\event\base {

    /**
     * Initialise event parameters.
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventgrades_updated', 'kalvidassign');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '{$this->userid}' updated the grades"
        . " for the Kaltura media assignment with the course module id of '{$this->contextinstanceid}'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/mod/kalvidassign/grade_submissions.php', ['cmid' => $this->contextinstanceid]);
    }
}
