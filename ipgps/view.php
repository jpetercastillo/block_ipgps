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
 * @package   block_ipgps/view map
 * @copyright 2022 John Peter Castillo Mendoza  <jcastillo@une.edu.pe>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
global $DB, $OUTPUT, $PAGE, $CFG, $USER;
$clustering = required_param('clustering', PARAM_INT);
$fileform = ($clustering) ? 'ipgps_form_c.php' : 'ipgps_form.php';
require_once($fileform);

$courseid = required_param('courseid', PARAM_INT);
$blockid = required_param('blockid', PARAM_INT);
$id = optional_param('id', 0, PARAM_INT);

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_ipgps', $courseid);
}

require_login($course);
$PAGE->set_url('/blocks/ipgps/view.php', array('id' => $courseid));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('ipgpssettings', 'block_ipgps'));

$settingsnode = $PAGE->settingsnav->add(get_string('ipgpssettings', 'block_ipgps'));
$editurl = new moodle_url('/blocks/ipgps/view.php', array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid, 'clustering' => $clustering));
$editnode = $settingsnode->add(get_string('viewmap', 'block_ipgps'), $editurl);
$editnode->make_active();

$ipgps = new ipgps_form();
echo $OUTPUT->header();

$ipgps->display();

$js = ($clustering) ? 'map_c.js' : 'map.js';
$PAGE->requires->js('/blocks/ipgps/js/' . $js);

// List users.
$context = context_course::instance($courseid);
$users = get_enrolled_users($context);
$timenow = time();
$i = 0;
$index=0;
foreach ($users as $user) {
    $latitud = '';
    $longitude = '';
    $tipo = '0';
    $i++;
    if ($DB->record_exists('block_ipgps', ['userid' => $user->id])) {
        $registro = $DB->get_record('block_ipgps', ['userid' => $user->id]);
        if ($registro->visible) {
            $latitud = $registro->latitud;
            $longitude = $registro->longitud;
            $tipo = '1';
        }
    }
    if ($latitud == '') {
        $info = get_ip($user->lastip);
        $latitud = $info['latitude'];
        $longitude = $info['longitude'];
    }
    $timeago = format_time($timenow - $user->lastaccess);
    if ($timenow - $user->lastaccess > 500) {
        $tipo = '2';
    } //Si es mayor que diez minutos
    
    if($USER->id==$user->id){ $index = $i;}
    
    $PAGE->requires->js_init_call('mapa', array($latitud, $longitude, $user->lastip . '<br> ' . $user->firstname . ' ' . $user->lastname . '<br> ' . $timeago, $tipo, $i));
}
    
    $PAGE->requires->js_init_call('locatex', array($index));
echo $OUTPUT->footer();
