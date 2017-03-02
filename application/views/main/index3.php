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
                        <select class="form-control" id="distrito" name="distrito">
                            <option value="0">Seleccione delegaciòn:</option>
                            <?php if(isset($distritos)){
                                    foreach($distritos as $distrito){?>
                                    <option value="<?php echo $distrito->id;?>"><?php echo $distrito->name;?></option>
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
                 var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: {lat:parseFloat(longituds[0]), lng:parseFloat(latituds[0])},
    mapTypeId: google.maps.MapTypeId.TERRAIN
  });

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

                                
        });




    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDe1EXskkLEuvjNT20NBVcpH9BFTxEdpj4&callback=initMap"></script>
    <?php }else{echo "Tu no deberias estar aqui!.";}?>

    </body>
</html>