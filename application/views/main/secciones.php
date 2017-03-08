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
  <body>
    <?php if ($this->session->userdata("admin_login") and $this->session->userdata("admin_login")->level == 1) { ?>
    <div id="map"></div>
           <div id="formContent" style="color:white;">
           <label>Busqueda por distrito:</label>
                        <select class="form-control" id="seccion" name="seccion">
                            <option value="0">Seleccione secci&oacute;n:</option>
                            <?php if(isset($secciones)){
                                    foreach($secciones as $seccion){?>
                                    <option value="<?php echo $seccion->id;?>"><?php echo $seccion->seccion;?></option>
                            <?php }}?>
                        </select>
           
                       <footer>
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
                    </div>
      
   <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery-ui-1.9.1.custom.css" /> 
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui-1.8.21.custom.min.js"></script>   
    <script>
        
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
                for(var i=0;i<datos.length;i++){
                    var array = datos[i].split(" ");
                    triangleCoords.push({ 
        "lat" : parseFloat(array[2]),
        "lng"  : parseFloat(array[1])
    });
                }
                var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: {lat: triangleCoords[0].lat, lng:triangleCoords[0].lng},
    mapTypeId: google.maps.MapTypeId.TERRAIN
  });

  // Define the LatLng coordinates for the polygon's path.
                
  // Construct the polygon.
  var bermudaTriangle = new google.maps.Polygon({
    paths: triangleCoords,
    strokeColor: '#0000FF',
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

                                
        });




    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDe1EXskkLEuvjNT20NBVcpH9BFTxEdpj4&callback=initMap"></script>
    <?php }else{echo "Tu no deberias estar aqui!.";}?>

    </body>
</html>