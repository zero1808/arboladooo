<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <title>Sistema Georreferenciacion de Arboles Metepec (SGAM)</title>
      
       <!-- Bootstrap Core CSS -->
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
        th {
    background-color: #4CAF50;
    color: white;
}
        
tr:nth-child(even){background-color: #f2f2f2}

        @charset "UTF-8";
/* CSS Document */
.tabla{
	width:100%;
	}
td, th, .tabla{
	border-width:2px;
	border-color:#000000;
	border-style:solid;
	}
@media screen and (max-width:720px){
	table, thead, tr, th, tbody, td{
		display:block;
	}
	
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	td { 
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}
	td:before { 
		position: absolute;
	
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	td:nth-of-type(1):before { content: "Nombre"; }
	td:nth-of-type(2):before { content: "Edad"; }
	td:nth-of-type(3):before { content: "Sexo"; }
	td:nth-of-type(4):before { content: "Ciudad"; }
	}

      #map1 {
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

 
    /* #content-window {
        float: left;
        font-family: 'Roboto','sans-serif';
        height: 100%;
        line-height: 30px;
        padding-left: 10px;
        width: 20%;
        }/*
    </style>
      
      
     <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery-ui-1.9.1.custom.css" /> 
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui-1.8.21.custom.min.js"></script> 		
        <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
       
          <script>

    
 
        

              
              $(document).ready(function(){
                  
                          function loadall(datos) {
   /*var locations = [
    [peticionario, latitud, longitud, 4],
      
    ];*/
            var datos=datos;
           

    var map = new google.maps.Map(document.getElementById('map1'), {
      zoom: 15,
      center: new google.maps.LatLng(datos.latitud[1],datos.longitud[1]),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;
                        

    for (i = 0; i < datos.peticionario.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(datos.latitud[i],datos.longitud[i]),
        map: map
          
      });
     marker.setIcon('http://arbolado.buscarv.com.mx/assets/images/icon4.png'); 
      google.maps.event.addListener(marker, 'click', (function(marker,i) {
        return function() {
          
          infowindow.setContent(datos.peticionario[i]);
          infowindow.open(map, marker);
        }
      })(marker,i));
    
    }
     google.maps.event.addListener(map, "idle", function(){
        google.maps.event.trigger(map, 'resize'); 
    });
}
                  
                    $("#municipio").change(function(){
$.ajax({
            url: "<?php echo base_url();?>index.php/arboles/getArboles",
            type: "POST",
                    data:{
						        id_municipio: $("#municipio").val()
					},
            success: function(data){
                var datos = $.parseJSON(data);
                   loadall(datos);
                  
                                }

                    });
        
                  
                  
              });
              
     $("#municipio").trigger("change"); 
              });
    </script>
  </head>
  <body>

    <div id="map1"></div>
       
       <div id="formContent" style="color:white;">
           <label>Busqueda por delegación:</label>
                        <select class="form-control" id="municipio" name="municipio">
                            <option value="0">Seleccione delegaciòn:</option>
                            <option value="san_bartolome">San Bartolome Tlaltelulco</option>
                            <option value="san_miguel_toto">San Miguel Totocuitlapilco</option>
                            <option value="san_sebastian">San Sebastian</option>
                            <option value="san_lucas_tunco">San Lucas Tunco</option>
                            <option value="la_union">La Union</option>
                             <option value="santa_cruz_ocotitlan">Santa Cruz Ocotitlan</option>
                             <option value="santa_maria_magdalena_ocotitlan">Santa Maria Magdalena Ocotitlan</option>
                             <option value="agripin_garcia_estrada">Agripin Garcia Estrada</option>
                             <option value="san_jorge_pueblo_nuevo">San Jorge Pueblo Nuevo</option>
                             <option value="las_margaritas">Las Margaritas</option>
                            <option value="san_lorenzo_coacalco">San Lorenzo Coacalco</option>
                             <option value="barrio_san_miguel">Barrio de San Miguel</option>
                             <option value="dr_jorge_jimenez_cantu">Dr. Jorge Jimenez Cantu</option>
                             <option value="san_gaspar_tlalhuelilpan">San Gaspar Tlalhuelilpan</option>
                             <option value="15">Barrio del Espiritu Santo</option>
                             <option value="16">Barrio de Santiaguito</option>
                            <option value="17">Luisa Isabel Campos de Jimenez Cantu</option>
                             <option value="18">La Michoacana</option>
                             <option value="19">Barrio de Santa Cruz</option>
                             <option value="20">La Virgen</option>
                             <option value="21">Barrio de San Mateo</option>
                             <option value="22">Electricistas</option>
                            <option value="23">Jesus Jimenez Gallardo</option>
                             <option value="24">Municipal</option>
                             <option value="25">Las Jaras</option>
                             <option value="26">Andres Molina Enriquez</option>
                             <option value="27">San Jose La Pilita</option>
                             <option value="28">Xinantecatl</option>
                            <option value="29">Juan Fernandez Albarran</option>
                             <option value="30">Real de San Javier</option>
                             <option value="31">Lazaro Cardenas</option>
                             <option value="32">La Purisima</option>
                             <option value="33">Rancho San Francisco</option>
                             <option value="34">Barrio de Coaxustenco</option>
                            <option value="35">Bellavista</option>
                             <option value="36">Izcalli Cuauhtemoc IV</option>
                             <option value="37">Lazaro Cardenas</option>
                             <option value="38">Las Haciendas</option>
                             <option value="39">Izcalli Cuauhtemoc V</option>
                             <option value="40">Izcalli Cuauhtemoc VI</option>
                            <option value="41">El Hipico</option>
                             <option value="42">Izcalli Cuauhtemoc II</option>
                             <option value="43">Izcalli Cuauhtemoc III</option>
                             <option value="44">San Francisco Coaxusco</option>
                             <option value="45">Fuentes de San Gabriel</option>
                             <option value="46">Club de Golf San Carlos</option>
                            <option value="47">Rancho San Lucas</option>
                             <option value="48">La Providencia</option>
                             <option value="49">Las Marinas</option>
                             <option value="50">Izcalli Cuauhtemoc I</option>
                             <option value="51">San Salvador Tizatlalli</option>
                             <option value="52">La Asuncion</option>
                            <option value="53">Francisco I. Madero</option>
                             <option value="54">Tollocan II</option>
                             <option value="55">San Jeronimo Chicahualco</option>
                             <option value="56">Los Pilares</option>
                             <option value="57">Casa Blanca</option>
                             <option value="58">Limite municipal</option>
                            <option value="59">Alvaro Obregon</option>
                            
                            
                        
                            
                   
                        </select>
           
                       <footer>
            <div class="row">
                <center>
                <div class="col-lg-12" style="color:white;">
                    <strong>
                    <p> &copy; 2016 BuscarV. Todos los derechos reservados. </p>
                    </strong>
                </div>
                    </center>
            </div>
            <!-- /.row -->
        </footer>
                    </div>
                   
       
       
            <!-- /.row -->
  

       
  </body>
</html>