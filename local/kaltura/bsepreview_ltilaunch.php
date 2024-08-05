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
 * Browse, Search and embed preview.
 *
 * @package    local_kaltura
 * @copyright  2023 Roi Levi <roi.levi@kaltura.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__).'/../../config.php');
require_once($CFG->dirroot.'/local/kaltura/locallib.php');

require_login();

global $PAGE;

$playurl = required_param('playurl', PARAM_URL);

$launch = [];
$launch['id'] = 1;
$launch['cmid'] = 0;
$launch['title'] = 'Browse and Embed - Preview Entry';
$launch['module'] = KAF_BROWSE_EMBED_MODULE;
$launch['course'] = $PAGE->course;
$launch['width'] = '300';
$launch['height'] = '300';
$launch['custom_publishdata'] = '';
$launch['source'] = $playurl;
echo local_kaltura_request_lti_launch($launch, false);
