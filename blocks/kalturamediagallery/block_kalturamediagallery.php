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
 * Kaltura Media Gallery block.
 *
 * @package    block_kalturamediagallery
 * @author     Remote-Learner.net Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2014 Remote Learner.net Inc http://www.remote-learner.net
 */
class block_kalturamediagallery extends block_base {

    /**
     * Init.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('pluginname', 'local_kalturamediagallery');
    }

    /**
     * Get content.
     *
     * @return stdClass
     */
    public function get_content() {
        if (!is_null($this->content)) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        if ($context = $this->getcoursecontext()) {
            $this->content->text = $this->getkalturamediagallerylink($context->instanceid);
        }

        return $this->content;
    }

    /**
     * Applicable formats.
     *
     * @return array
     */
    public function applicable_formats() {
        return [
            'course-view' => true,
        ];
    }

    /**
     * Get the Kaltura Media Gallery link.
     *
     * @param int $courseid The course ID.
     * @return string
     * @throws coding_exception
     * @throws moodle_exception
     */
    private function getkalturamediagallerylink($courseid) {
        $mediagalleryurl = new moodle_url('/local/kalturamediagallery/index.php', [
            'courseid' => $courseid,
        ]);

        $link = html_writer::tag('a', get_string('nav_mediagallery', 'local_kalturamediagallery'), [
            'href' => $mediagalleryurl->out(false),
        ]);

        return $link;
    }

    /**
     * Get the course context.
     *
     * @return bool|\core\context|\core\context\course
     * @throws coding_exception
     */
    private function getcoursecontext() {
        // Check the current page context.  If the context is not of a course or module then return false.
        $context = context::instance_by_id($this->page->context->id);
        $iscoursecontext = $context instanceof context_course;
        if (!$iscoursecontext) {
            return false;
        }

        // If the context if a module then get the parent context.
        $coursecontext = ($context instanceof context_module) ? $context->get_course_context() : $context;

        return $coursecontext;
    }
}
