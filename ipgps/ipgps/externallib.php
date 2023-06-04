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
 * External Web Service Template
 *
 * @package    block_ipgps
 * @author    John Peter Castillo Mendoza
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;
require_once("$CFG->libdir/externallib.php");

class block_ipgps_ws extends external_api
{

    public static function setuserubicacion_parameters()
    {
        return new external_function_parameters(
            array(
                'userid' => new external_value(PARAM_INT, 'USER ID'),
                'action' => new external_value(PARAM_TEXT, 'ACTION ID'),
                'latitude' => new external_value(PARAM_TEXT, 'LATITUDE'),
                'longitude' => new external_value(PARAM_TEXT, 'LONGITUDE')
            )
        );
    }
    public static function setuserubicacion($userid, $action, $latitude, $longitude)
    {
        global $COURSE, $DB, $USER;
        $context = context_course::instance($COURSE->id);

        $v=($action == "hide" || $latitude=="" )?0:1;
         
        $datauser = new stdClass();
        $datauser->blockid = $context->id;
        $datauser->cursoid = $COURSE->id;
        $datauser->userid = $userid;
        $datauser->latitud = $latitude;
        $datauser->longitud = $longitude;
        $datauser->ip = $USER->lastip;
        $datauser->visible = $v;

        if (!$DB->record_exists('block_ipgps', ['userid' => $userid])) {
            $result = $DB->insert_record('block_ipgps', $datauser);
        } else {
            $registro = $DB->get_record('block_ipgps', ['userid' => $userid]);

            $datauser->id = $registro->id;

            $result = $DB->update_record('block_ipgps', $datauser);
        }

        $mensaje = ($v) ? get_string('nolocation', 'block_ipgps') : get_string('location', 'block_ipgps');

        return $mensaje;
    }
    public static function setuserubicacion_returns()
    {
        return new external_value(PARAM_RAW, 'The whole banner as HTML Element');
    }
}
