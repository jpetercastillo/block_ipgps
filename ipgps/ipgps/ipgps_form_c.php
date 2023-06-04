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
 * @package   block_ipgps
 * @copyright 2022 John Peter Castillo Mendoza <jcastillo@une.edu.pe>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

require_once("{$CFG->libdir}/formslib.php");
require_once("{$CFG->dirroot}/blocks/ipgps/lib/lib.php");

class ipgps_form extends moodleform
{
    function definition()
    {
        $mform = &$this->_form;
        $mform->addElement('html', '<div id="ipgps_contenedor">');
        $mform->addElement('html', get_html_map_clustering());
        $mform->addElement('html', '</div>');
    }
}
