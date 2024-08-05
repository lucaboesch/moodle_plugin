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
 * Kaltura media gallery lib script.
 *
 * @package    local_kalturamediagallery
 * @author     Remote-Learner.net Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2014 Remote Learner.net Inc http://www.remote-learner.net
 */

define('LOCAL_KALTURAMEDIAGALLERY_LINK_LOCATION_NAVIGATION_BLOCK', 0);
define('LOCAL_KALTURAMEDIAGALLERY_LINK_LOCATION_COURSE_SETTINGS', 1);

use local_kalturamediagallery\output\navigation as nav;

/**
 * This function adds Kaltura media gallery link to the navigation block.  The code ensures that the Kaltura media gallery link is
 * only displayed in the 'Current courses' menu tree. In addition it check if the current context is one that is below the course
 * context.
 *
 * @param global_navigation $navigation a global_navigation object
 * @return void
 */
function local_kalturamediagallery_extend_navigation($navigation) {
    global $USER, $PAGE, $DB;

    // Either a set value of 0 or an unset value means hook into navigation block.
    if (!empty(get_config('local_kalturamediagallery', 'link_location'))) {
        return;
    }

    if (empty($USER->id)) {
        return;
    }

    // When on the admin-index page, first check if the capability exists.
    // This is to cover the edge case on the Plugins check page, where a check for the capability is performed before the capability
    // has been added to the Moodle mdl_capabilities table.
    if ('admin-index' === $PAGE->pagetype) {
        $exists = $DB->record_exists('capabilities', ['name' => 'local/kalturamediagallery:view']);

        if (!$exists) {
            return;
        }
    }

    // Check the current page context.  If the context is not of a course or module then we are in another area of Moodle and
    // return void.
    $context = context::instance_by_id($PAGE->context->id);
    $isvalidcontext = ($context instanceof context_course || $context instanceof context_module) ? true : false;
    if (!$isvalidcontext) {
        return;
    }

    // If the context if a module then get the parent context.
    $coursecontext = null;
    if ($context instanceof context_module) {
        $coursecontext = $context->get_course_context();
    } else {
        $coursecontext = $context;
    }

    if (!has_capability('local/kalturamediagallery:view', $coursecontext, $USER)) {
        return;
    }

    $icon = getmediagalleryicon();
    $mediagallerylinkname = get_string('nav_mediagallery', 'local_kalturamediagallery');
    $linkurl = new moodle_url('/local/kalturamediagallery/index.php', ['courseid' => $coursecontext->instanceid]);

    $currentcoursenode = $navigation->find('currentcourse', $navigation::TYPE_ROOTNODE);
    if (ismodenotempty($currentcoursenode)) {
        // We have a 'current course' node, add the link to it.
        $currentcoursenode->add($mediagallerylinkname, $linkurl, navigationnode::NODETYPE_LEAF, $mediagallerylinkname,
            'kalturacoursegallerylink-currentcourse', $icon);
    }

    $mycoursesnode = $navigation->find('mycourses', $navigation::TYPE_ROOTNODE);
    if (ismodenotempty($mycoursesnode)) {
        $currentcourseinmycourses = $mycoursesnode->find($coursecontext->instanceid, navigationnode::TYPE_COURSE);
        if ($currentcourseinmycourses) {
            // We found the current course in 'my courses' node, add the link to it.
            $currentcourseinmycourses->add($mediagallerylinkname, $linkurl, navigationnode::NODETYPE_LEAF,
                $mediagallerylinkname, 'kalturacoursegallerylink-mycourses', $icon);
        }
    }

    $coursesnode = $navigation->find('courses', $navigation::TYPE_ROOTNODE);
    if (ismodenotempty($coursesnode)) {
        $currentcourseincourses = $coursesnode->find($coursecontext->instanceid, navigationnode::TYPE_COURSE);
        if ($currentcourseincourses) {
            // We found the current course in the 'courses' node, add the link to it.
            $currentcourseincourses->add($mediagallerylinkname, $linkurl, navigationnode::NODETYPE_LEAF,
                $mediagallerylinkname, 'kalturacoursegallerylink-allcourses', $icon);
        }
    }
}

/**
 * Fumble with Moodle's global navigation by leveraging Moodle's *_extend_navigation_course() hook.
 *
 * @param navigationnode  $navigation The navigation node to extend
 * @param stdClass        $course     The course to object for the tool
 * @param context         $context    The context of the course
 */
function local_kalturamediagallery_extend_navigation_course($navigation, $course, $context) {
    if ($newnode = \local_kalturamediagallery\output\navigation::create_navigation_node($course, $context)) {
        $navigation->add_node($newnode);
    }
}

/**
 * Check if the node is not empty.
 *
 * @param navigationnode $node
 * @return bool
 */
function ismodenotempty(navigationnode $node) {
    return $node !== false && $node->has_children();
}

/**
 * Return the Media Gallery icon.
 *
 * @return pix_icon
 */
function getmediagalleryicon() {
    return new pix_icon('media-gallery', '', 'local_kalturamediagallery');
}
