<?php

defined('MOODLE_INTERNAL') || die;
 
 function get_html_map(){
    //$retStr = "<link rel='stylesheet' href='https://unpkg.com/leaflet@1.8.0/dist/leaflet.css'
   //integrity='sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=='crossorigin=''>";
   $retStr = "<link rel='stylesheet' href='css/leaflet/leaflet@1.8.0/leaflet.css'>";
   $retStr .="<div id='mymap' Style='height:600px'></div>";
    //$retStr .= "<script src='https://unpkg.com/leaflet@1.8.0/dist/leaflet.js'
   //integrity='sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=='
   //crossorigin=''></script>";
   $retStr .= "<script src='js/leaflet/leaflet@1.8.0/leaflet.js'></script>";
    return $retStr;
 }
 
 function get_html_map_clustering(){
    //$retStr = "<link rel='stylesheet' href='https://unpkg.com/leaflet@1.0.3/dist/leaflet.css'
    //integrity='sha512-07I2e+7D8p6he1SIM+1twR5TIrhUQn9+I6yjqD53JQjFiMf8EtC93ty0/5vJTZGF8aAocvHYNEDJajGdNx1IsQ==' crossorigin=''/>";
    $retStr = "<link rel='stylesheet' href='css/leaflet/leaflet@1.0.3/leaflet.css'/>";
    //$retStr .= "<script src='https://unpkg.com/leaflet@1.0.3/dist/leaflet-src.js' integrity='sha512-WXoSHqw/t26DszhdMhOXOkI7qCiv5QWXhH9R7CgvgZMHz1ImlkVQ3uNsiQKu5wwbbxtPzFXd1hK4tzno2VqhpA==' crossorigin=''></script>";
    $retStr .= "<script src='js/leaflet/leaflet@1.0.3/leaflet-src.js'></script>";
    $retStr .= "<link rel='stylesheet' href='css/screen.css' />";
    $retStr .="<link rel='stylesheet' href='css/MarkerCluster.css' />";
    $retStr .="<link rel='stylesheet' href='css/MarkerCluster.Default.css' />";
	$retStr .="<script src='js/leaflet.markercluster-src.js'></script>";
    $retStr .="<div id='mymap' Style='height:600px'></div>";
   return $retStr;
 }
 
 function get_ip($ip){
 $ipdata = download_file_content('http://www.geoplugin.net/json.gp?ip='.$ip);
        if ($ipdata) {
            $ipdata = preg_replace('/^geoPlugin\((.*)\)\s*$/s', '$1', $ipdata);
            $ipdata = json_decode($ipdata, true);
        }
        if (!is_array($ipdata)) {
            $info['error'] = get_string('cannotgeoplugin', 'error');
            return $info;
        }
        $info['latitude']  = (float)$ipdata['geoplugin_latitude'];
        $info['longitude'] = (float)$ipdata['geoplugin_longitude'];
        $info['city']      = s($ipdata['geoplugin_city']);
    return $info;
 }
