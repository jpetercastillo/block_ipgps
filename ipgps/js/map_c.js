let map=L.map('mymap');

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 13,
    attribution: '© OpenStreetMap'
}).addTo(map);
map.locate({setView: false, maxZoom: 13}); 
var markers = L.markerClusterGroup();

var customControl =  L.Control.extend({        
      options: {
        position: 'topleft'
      },

      onAdd: function (map) {
        var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
        var link = L.DomUtil.create('i', 'leaflet-control fa fa-eye-slash', container);
        container.style.width = '35px';
        container.style.height = '35px';
        container.style.cursor = 'pointer';
        link.style.cursor = 'pointer';
        link.setAttribute('data-activado', '0');
        container.style.backgroundColor = 'white';
        
        container.onclick = function(){
            link.removeAttribute('class');
            var activado = link.getAttribute('data-activado');
        
            if (activado=='1'){
                //cerramos
                link.setAttribute('class', 'leaflet-control fa fa-eye-slash');
                link.setAttribute('data-activado', '0');    
                
                map.eachLayer(function (layer) {
                    layer.closePopup();
                });
                
            }
            else
            {
                //abrimos
                link.setAttribute('class', 'leaflet-control fa fa-eye');
                link.setAttribute('data-activado', '1');   
            
                marker.forEach(function(marker) {
                var popup = marker.getPopup();
                marker.bindPopup(popup.getContent()).openPopup();
            });
            
            }
        }
        
        container.onmouseover = function(){
            container.style.backgroundColor = 'lightgray'; 
        }
        
        container.onmouseout = function(){
            container.style.backgroundColor = 'white'; 
        }

        return container;
      }
});


map.addControl(new customControl());

var greenIcon = new L.Icon({
  iconUrl: 'img/marker-icon-2x-green.png',
  shadowUrl: 'img/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});

var greyIcon = new L.Icon({
  iconUrl: 'img/marker-icon-2x-grey.png',
  shadowUrl: 'img/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});

var marker=[];
function mapa(Y,latitud,longitud,ip,tipo,index){
switch (tipo) {
    case '0':
    marker[index]= L.marker([latitud,longitud]).addTo(map).bindPopup(
    'IP:'+ip,{autoClose: false, closeOnClick: false});
        break;
    case '1':
        marker[index]= L.marker([latitud,longitud],{icon: greenIcon}).addTo(map).bindPopup(
    'IP:'+ip,{autoClose: false, closeOnClick: false});
    break;
    case '2':
    marker[index]= L.marker([latitud,longitud],{icon: greyIcon}).addTo(map).bindPopup(
    'IP:'+ip,{autoClose: false, closeOnClick: false});
    break;
}
    markers.addLayer(marker[index]);
    map.addLayer(markers);
}

function locatex(Y,index){
    var curPos = marker[index].getLatLng();
    map.setView(new L.LatLng(curPos.lat,curPos.lng), 13);
    marker[index].openPopup();
}