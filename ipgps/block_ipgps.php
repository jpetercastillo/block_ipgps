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

/*
 * @package   block_ipgps
 * @copyright 2022 John Peter Castillo Mendoza <jcastillo@une.edu.pe>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

class block_ipgps extends block_base
{
    public function init()
    {
        $this->title = get_string('pluginname', 'block_ipgps');
    }

    public function get_content()
    {
        global $COURSE, $OUTPUT, $DB, $USER;

        $this->content = new stdClass;

        //Recibe: $this->config->header, $this->config->title, $this->config->clustering,$this->config->disabled

        if ($DB->record_exists('block_ipgps', ['userid' => $USER->id])) {
            $user = $DB->get_record("block_ipgps", ["userid" => $USER->id]);
            $action = ($user->visible != null && $user->visible == 0) ? 'show' : 'hide';
        } else {
            $action = 'show';
        }

        $icon = $OUTPUT->pix_icon('i/' . $action, '');

        $mensaje = $icon . "<span id='msg'>";
        $mensaje .= ($action != null && $action == 'show') ? get_string('location', 'block_ipgps') : get_string('nolocation', 'block_ipgps');
        $mensaje .= "</span>";
        
        $this->content->text = '<div>';
        $this->content->text .= html_writer::link('', $mensaje, array('data-action' => $action, 'data-userid' => $USER->id, 'id' => 'aLink'));
        $this->content->text .= '</div>';

        $this->page->requires->js_call_amd('block_ipgps/ipgps', 'init');

        $visible = 1;
        if ($this->config->disabled && $this->verificar_si_estudiante($USER->id, $COURSE->id)) {
            $visible = 0;
        }

        if ($visible) {
            //$vista=($this->config->clustering)?'view_c.php':'view.php';
            $url = new moodle_url('/blocks/ipgps/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id, 'clustering' => $this->config->clustering));

            $icon2 = $OUTPUT->pix_icon('i/location', '');
            $this->content->footer = '<div class="user">';

            $this->content->footer .= html_writer::link($url, $icon2 . get_string('viewmap', 'block_ipgps'));
            $this->content->footer .= '</div>';
        }

        return $this->content;
    }


    public function specialization()
    {
        if (isset($this->config)) {
            if (empty($this->config->title)) {
                $this->title = get_string('defaulttitle', 'block_ipgps');
            } else {
                $this->title = $this->config->title;
            }
        }
    }

    public function verificar_si_estudiante($iduser, $courseid)
    {
        $context = context_course::instance($courseid);
        $roles = get_user_roles($context, $iduser, true);
        $role = key($roles);
        $rolename = $roles[$role]->shortname;
        $i = ($rolename == 'student') ? '1' : '0';
        return $i;
    }
}
