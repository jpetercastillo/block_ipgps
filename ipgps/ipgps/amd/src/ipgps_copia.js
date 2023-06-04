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
 * @module     block_ipgps/change_perm
 * @copyright  2022 John Peter Castillo Mendoza <jcastillo@une.edu.pe>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define("block_ipgps/ipgps",['jquery', 'core/ajax', 'core/notification', 'core/str'],
function($, Ajax, Notification, Str) {
    var latitude = '', longitude = '';
    var changeVisibility = function(action, userid) {
        getGeo();
        var newAction = oppositeAction(action);
        if (latitude === ''){newAction = 'show';}
        Ajax.call([{
                    methodname: 'block_ipgps_setUserUbicacion',
                    args: { userid: userid, action: action,latitude:latitude,longitude:longitude },
                    done: function(result){
                        changeVisibilityIconAttr(newAction,result);
                        $("#aLink").attr('data-action',newAction);
                    },
                    fail: Notification.exception,
        }]);
       
    };
    
    function getGeo() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(onSuccess, onError);
        } else {
            latitude = '';
            longitude = '';
            alert('Geolocation is not supported by this browser.');
        }
    }
    
    function onSuccess(position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;
    }
    
    function onError(error) {
        latitude = '';
        longitude = '';
        alert('Error: ' + error.message);
    }
    
    var changeVisibilityIconAttr = function(action,mensaje) {
            var msg = $("#msg");
            var icon = $("#aLink .icon");
            $(icon).addClass(getIconClass(action));
            $(icon).removeClass(getIconClass(oppositeAction(action)));
            $(msg).text(mensaje);
            return;
    };
    
    var getIconClass = function(action) {
        return action == 'show' ? 'fa-eye-slash' : 'fa-eye';
    };
    
    var oppositeAction = function(action) {
        return action == 'show' ? 'hide' : 'show';
    };
    
    return {
        init: function() {
            $("#aLink").on('click', function(e) {
                e.preventDefault();    
                var action = ($(this).attr('data-action'));
                var userid = ($(this).attr('data-userid'));
                changeVisibility(action, userid);
            });
        }
    };
});