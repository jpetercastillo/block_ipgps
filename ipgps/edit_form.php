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
 * @copyright 2022 John Peter Castillo Mendoza  <jcastillo@une.edu.pe>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_ipgps_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {

        // Sección de configuración de parámetros.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'), array('id' => 'config_header'));

        // Crear el parámetro para el título del bloque
        $mform->addElement('text', 'config_title', get_string('blocktitle', 'block_ipgps'), array('id' => 'config_title'));
        $mform->setDefault('config_title', get_string('defaulttitle', 'block_ipgps'));
        $mform->setType('config_title', PARAM_TEXT);

        // Un checkbox para seleccionar si es clustering 
        $mform->addElement(
            'advcheckbox',
            'config_clustering',
            get_string('blockclustering', 'block_ipgps'),
            get_string('blocktextclustering', 'block_ipgps')
        );

        // Un checkbox para ocultar una sección 
        $mform->addElement(
            'advcheckbox',
            'config_disabled',
            get_string('blockdisabled', 'block_ipgps'),
            get_string('blocktextdisabled', 'block_ipgps')
        );
    }
}
