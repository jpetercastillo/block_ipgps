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
 * @module     block_ipgps/change_config_map
 * @copyright  2022 John Peter Castillo Mendoza <jcastillo@une.edu.pe>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define("block_ipgps/main",['jquery', 'core/ajax', 'core/str'],
function($, Ajax, Str) {
        
        function activar()
        {
                if($("#config_map").val()==='val1') {
                    $("#config_api").attr('disabled','disabled');
                    $("#config_api").val('');
                    $("#config_api").removeAttr('required');
                }
                else
                {
                    $("#config_api").removeAttr('disabled');
                    $("#config_api").attr('required', true);
                    
                }
        }
        activar();
    return {
        
        init: function() {
            $("#config_map").on('change', function(e) {
                activar();    
            });
        }
    };
});