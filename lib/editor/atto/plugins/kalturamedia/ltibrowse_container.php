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
 * Kaltura media LTI browse container.
 *
 * @package    atto_kalturamedia
 * @author     Remote-Learner.net Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2014 Remote Learner.net Inc http://www.remote-learner.net
 */

/**
 * Kaltura media LTI browse container.
 *
 * @package    atto_kalturamedia
 * @author     Remote-Learner.net Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2014 Remote Learner.net Inc http://www.remote-learner.net
 */

// phpcs:disable moodle.Files.LineLength
// phpcs:disable moodle.Commenting.MissingDocblock

require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/config.php');
require_login();
global $PAGE;
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('embedded');
echo $OUTPUT->header();
$requestquerystring = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : "";
parse_str($requestquerystring, $params);
$ltibrowseurl = new moodle_url('ltibrowse.php', $params);
?>

<iframe allow="autoplay *; fullscreen *; encrypted-media *; camera *; microphone *; display-capture *;" id="kafIframe" src="<?php echo $ltibrowseurl->out(); ?>" width="100%" height="600" style="border: 0;" allowfullscreen>
</iframe>
<script>
    var buttonJs = window.opener.buttonJs;

    function kaltura_atto_embed(data) {
        buttonJs.embedItem(buttonJs, data);
    }
</script>
