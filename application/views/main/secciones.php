<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple Polygon</title>
      <link href="<?php echo base_url();?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css"      rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets/dist/css/sb-admin.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url();?>assets/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
        #map {
        float: left;
        height: 87%;
        width:100%;
      }
         #formContent{
        position: bottom;
        width: 30%;
        height: 4%;
             
        margin: 0 auto;
    }
    </style>
  </head>
    

<!-- jQuery -->
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<!-- BS JavaScript -->
  <body>
    <?php if ($this->session->userdata("admin_login") and $this->session->userdata("admin_login")->level == 1) { ?>
    <div id="map"></div>
      <br>
                 <footer>
                  
                           <div class="row">
                           <div class="col-sm-12">
                           <div class="form-group">
                               <center>
                               
                               <button type="button" data-toggle="modal" class="btn btn-success" data-target="#panel">Panel de control</button>

                               </center>
                               
                            </div>    
                           </div>
                           </div>
            <div class="row">
                <center>
                <div class="col-lg-12" style="color:white;">
                    <strong>
                        
                    <p> &copy; 2016 BuscarV. Todos los derechos reservados. </p>
                     <p><a href='<?php echo base_url();?>index.php/login/logout'>Cerrar sesi&oacute;n</a></p>   
                    </strong>
                </div>
                    </center>
            </div>
                           
            

            <!-- /.row -->
        </footer>
                                 
<div class="modal fade" id="datos" tabindex="-1" role="dialog"  aria-hidden="true" style="color:black;">
  <div class="modal-dialog"  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  id="exampleModalLabel">Jovenes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <center><h4 id="no_encontrados"></h4></center>
          <div class="row">
              <div class="col-sm-12">
            <div class="table-responsive">

            <table class="table table-bordered table-hover" id="tabla">
				
				<tbody>
					
				</tbody>
            </table>
            </div> 
                  </div>
          </div>
        </div>
      <div class="modal-footer">
        <!--button type="button" class="btn btn-primary">Save changes</button-->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
      
      <div class="modal fade" id="panel" tabindex="-1" role="dialog"  aria-hidden="true" style="color:black;">
  <div class="modal-dialog"  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <center>
        <h2 class="modal-title"  id="exampleModalLabel">Panel de control</h2>
          </center>  
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <center><h3>Agregue una nueva capa al mapa</h3></center>
          <div class="row">
              <div class="col-sm-12">
                  <div class="form-group">
                      <label>Busqueda por seccion:</label>
                        <select class="form-control" id="seccion" name="seccion">
                            <option value="0">Seleccione secci&oacute;n:</option>
                            <?php if(isset($secciones)){
                                    foreach($secciones as $seccion){?>
                                    <option value="<?php echo $seccion->id;?>"><?php echo $seccion->seccion;?></option>
                            <?php }}?>
                        </select>
                  </div>  
              </div>
          </div>
          <div class="row">
              <div class="col-sm-12">
                  <div class="form-group">
                      <label>Busqueda por distrito:</label>
                        <select class="form-control" id="distrito" name="distrito">
                            <option value="0">Seleccione secci&oacute;n:</option>
                            <?php if(isset($distritos)){
                                    foreach($distritos as $distrito){?>
                                    <option value="<?php echo $distrito->id;?>"><?php echo $distrito->name;?></option>
                            <?php }}?>
                        </select>
                  </div>  
              </div>
          </div>
        </div>
      <div class="modal-footer">
        <!--button type="button" class="btn btn-primary">Save changes</button-->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

   <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery-ui-1.9.1.custom.css" /> 
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui-1.8.21.custom.min.js"></script>  
      <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

      
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDe1EXskkLEuvjNT20NBVcpH9BFTxEdpj4"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/maplabel.js"></script>   
      
      <script>
      var map; 
        
        initComponents();
        function initComponents(){
  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: {lat:18, lng:-90.8903},
    mapTypeId: google.maps.MapTypeId.TERRAIN
  });  
        }
 
        
function mapearSeccional(triangleCoords,cantidadJovenes,datos){
   

  // Define the LatLng coordinates for the polygon's path.
map.setCenter(new google.maps.LatLng(triangleCoords[0].lat,triangleCoords[0].lng));
  // Construct the polygon.
  var bermudaTriangle = new google.maps.Polygon({
    paths: triangleCoords,
    strokeColor: '#0000FF',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.35
   
  });
  var geocoder = new google.maps.Geocoder();
  codeAddress(geocoder,map,datos);
  bermudaTriangle.setMap(map);
  bermudaTriangle.addListener('click', mostrarTabla);

  infoWindow = new google.maps.InfoWindow;     
        
  label: new MapLabel({
    text: "Este seccional tiene: "+cantidadJovenes+" Jovenes",
    position: new google.maps.LatLng(triangleCoords[0].lat, triangleCoords[0].lng), // the lat/lng of location of the label.
    fontSize: 15,
    fontColor: '#F2F000',
    labelInBackground: true,
    strokeColor: '#000',
    map: map   // The map object to place the label on
})  
    }
    function codeAddress(geocoder,map,datos) {
    var notfound= 0;
    for(var i=0; i<datos.jovenes.length;i++){   
    var address ="calle:"+datos.jovenes[i].calle+" "+ datos.jovenes[i].colonia+" CODIGO POSTAL"+datos.jovenes[i].cp+" ESTADO DE MEXICO";
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
          notfound = notfound+1;
      }
    });
    }
    $("#no_encontrados").text("Jovenes no encontrados: "+notfound);    
  }    
        
        function mostrarTabla(){
                 
                 $("#datos").modal('show');
             }
               
        $(document).ready(function(){
            
                              $("#seccion").change(function(){
                                    if($("#seccion").val()===0){
                                        
                                    }else{
                                   $.ajax({
            url: "<?php echo base_url();?>index.php/main/searchSeccion",
            type: "POST",
            data:{
                seccionales:$("#seccion").val()
                                   },
            success: function(data){
                var triangleCoords =[];
                var datos = $.parseJSON(data);
                for(var i=0;i<datos.coordenadas.length;i++){
                    var array = datos.coordenadas[i].split(" ");
                    triangleCoords.push({ 
                    "lat" : parseFloat(array[2]),
                    "lng"  : parseFloat(array[1]),
                        });
                    var cantidadJovenes = datos.jovenes.length; 
                   
                }   
                    construirTabla(datos);
                    mapearSeccional(triangleCoords,cantidadJovenes,datos);
  
    
            
                                }

                    }); 
                                    }
                                  
                                    
                                });
            $("#distrito").change(function(){
                                    if($("#distrito").val()===0){
                                        
                                    }else{
                                   $.ajax({
            url: "<?php echo base_url();?>index.php/main/searchDistrito",
            type: "POST",
            data:{
                distrito:$("#distrito").val()
                                   },
            success: function(data){
                var datos = $.parseJSON(data);
                var i=0;
                var latituds=[];
                var longituds=[];
                for(var i;i<datos.length;i++){
                    if(i%2==0){
                        latituds.push(datos[i]);
                    }
                    else{
                        longituds.push(datos[i]);
                    }
                }
    
map.setCenter(new google.maps.LatLng(parseFloat(longituds[0]),parseFloat(latituds[0])));
  // Define the LatLng coordinates for the polygon's path.
                
  var triangleCoords = [];
 for(var j=0;j<longituds.length;j++){
                    
                 
       triangleCoords.push({ 
        "lat" : parseFloat(longituds[j]),
        "lng"  : parseFloat(latituds[j])
    });
                }
  // Construct the polygon.
  var bermudaTriangle = new google.maps.Polygon({
    paths: triangleCoords,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.35
  });
  bermudaTriangle.setMap(map);

                                }

                    }); 
                                    }
                                    
                                });

        function construirTabla(datos){
            $("#tabla").html('');
            $("#tabla").append("<thead><tr><th class='text-center'>Apellido paterno</th><th class='text-center'>Apellido materno</th><th class='text-center'>Nombre(s)</th><th class='text-center'>Direccion</th><th class='text-center'>CP</th></tr></thead>");
            for(var i=0;i<datos.jovenes.length;i++){
            $("#tabla").append("<tr><td><font size ='2', color='000000'>"+datos.jovenes[i].ap_paterno+"</font></td><td><font size ='2', color='000000'>"+datos.jovenes[i].ap_materno+"</font></td><td><font size ='2', color='000000'>"+datos.jovenes[i].nombres+"</font></td><td><font size ='2', color='000000'>"+datos.jovenes[i].calle+" #"+datos.jovenes[i].exterior+","+datos.jovenes[i].colonia+", "+"</font></td><td><font size ='2', color='000000'>"+datos.jovenes[i].cp+"</font></td></tr>");
    
            }

        }  
            

        });

 
        
 
    </script>
  

    <?php }else{echo "Tu no deberias estar aqui!.";}?>

    </body>
</html>