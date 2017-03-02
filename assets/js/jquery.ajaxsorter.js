/*/////////////////////////////AJAXSORTER 1.13.7////////////////////////////////// 
Esta libreria permite la creacion de listados dinamicos con:
    -   Ajustada para FRAMEWORK CODEIGNITER (SOLO EN LOS ENVIOS GET)
    -   Opcion de ordenar los datos 
    -   Mostrar una cantidad seleccionada desde un select, input
    -   Paginacion ordenada y desordenada 
    -   Actualizar la paginacion
    -   Filtrar informacion por campo(POST)  
    -	Agregar filtros
    -	Resaltar filas en base a diversos valores
    
    Ultima modificaciÃ³n: 18 jul 2013
	Autor: Ing. Roberto Antonio Ramos Jaloma
*/
jQuery.fn.ajaxSorter = function(obj){    
	if(!$(this).hasClass('ajaxSorterDiv'))
		$(this).addClass('ajaxSorterDiv');
	$(this).data('num_rows',0);
    var div_ajax_sorter = $(this).attr('id');        
    var url_action = obj.url;
    var extra_filters = obj.filters;
    var url = url_action;        
    var div_table  = "#"+div_ajax_sorter + " .ajaxSorter";
    var id_filter = "#"+div_ajax_sorter + " .filter";
    var id_pager = "#"+div_ajax_sorter + " .ajaxpager"
    var multiple_filter  = "#"+div_ajax_sorter + " .multiple_filter";    
    var exporter = $(id_pager+" img.exporter");  
    var printer = $(id_pager+" img.printer");  
    var onLoad = obj.onLoad;
    var active = obj.active;
    var multipleFilter = obj.multipleFilter;
    var sort = obj.sort;
    var asyncv = obj.asyncv;
    var onChange = obj.onChange;
    var onRowClick = obj.onRowClick;
    var onRowDblClick = obj.onRowDblClick;
    var onSuccess = obj.onSuccess;
    var filterTypeChange = obj.filterTypeChange;
	var size = obj.size;
	var i_fields = obj.show;
	var paginator = obj.paginator;
	var paginatorOptions = obj.paginatorOptions;
	
	i_fields = clean_var(i_fields,'array',false);	
	paginator = clean_var(paginator,'boolean',false);
	paginatorOptions = clean_var(paginatorOptions,'object',{first:true,prev:true,next:true,last:true,exportXls:false,print:false,show:[10,20,30]});
	filterTypeChange = clean_var(filterTypeChange,'boolean',true);
	multipleFilter = clean_var(multipleFilter,'boolean',false);
	asyncv = clean_var(asyncv,'boolean',true);
	sort = clean_var(sort,'boolean',true);
	onSuccess = clean_var(onSuccess,'function',false);
	size = clean_var(size,'number',false);
	onLoad = clean_var(onLoad,'boolean',true);
	onChange = clean_var(onChange,'boolean',true);
	
	if(i_fields)//CAMPOS A MOSTRAR
		$('#'+div_ajax_sorter).html(create_table(i_fields,size)); 		
	if(paginator)//PAGINADO
		$('#'+div_ajax_sorter).append(create_paginator(paginator,paginatorOptions)); 
			
    if($.type(onRowClick)!=="undefined"){
        if($.type(onRowClick) === "function")
            $(div_table).delegate(' tbody tr','click',onRowClick);        
        else
            console.log('Lo ingresado no es una funcion, el evento se descartara');
    }
	
     if($.type(onRowDblClick)!=="undefined"){
        if($.type(onRowDblClick) === "function")
            $(div_table).delegate(' tbody tr','dblclick',onRowDblClick);
        else
            console.log('Lo ingresado no es una funcion, el evento se descartara');
    }
	
	if($.type(active)==='undefined')
		active=false;
	   
	if(exporter!=undefined){//Exporta el contenido actual de la tabla
        $(id_pager+" img.exporter").click(function(){
            if(confirm("Desea exportar los datos visibles en la tabla?")){
               $(id_pager + " input.htmlTable").attr('value',$(div_table).html());  
			   $(id_pager+" form ").submit();
			   $(id_pager + " input.htmlTable").attr('value',''); 
			}			   
        });  
    }
    if(printer!=undefined){//Exporta el contenido actual de la tabla
        $(id_pager+" img.printer").click(function(){
            if(confirm("oDesea imprimir los datos visibles en la tabla?")){                
                tabla=$(div_table).html();
                style='<link rel="stylesheet" type="text/css" href="'+$(id_pager+" img.printer").data('url')+'assets/css/ajaxSorterStyle/style.css">';
                java = '<script type="text/javascript" src="'+$(id_pager+" img.printer").data('url')+'assets/js/jquery-1.8.0.min.js"></script>';
                w=window.open(' ','popimpr');                				                
                all = style + java+'<div class="divAjaxSorter"><table class="ajaxSorter">'+tabla+'</table><div><script>$("th").removeClass("none");</script>';                
                console.log(all);
                w.document.write(all);                                
                w.document.close();w.print();		                         
            }
        });  
    }
    if(extra_filters!=undefined){    //SI EXISTEN FILTROS EXTRAS (SELECT, INPUT), se recive .val() y que este sea un numero entero
        $.each(extra_filters, function(){ url+="/"+$('#'+this).val();});
        $.each(extra_filters, function(){                                    
            $('#'+this).change(function (){//SE POSICIONAN LOS VALORES DENTRO DEL TR PARA SU TRABAJO			
                url = url_action;                 
                $.each(extra_filters, function(){url+="/"+$('#'+this).val();});
				if(onChange)
					paginate(0,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);
            }).bind('update',function(){
                url = url_action;                    
                $.each(extra_filters, function(){url+="/"+$('#'+this).val();});				
                paginate(0,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);
            });
        });
    }	   
    $(this).bind("update", function(){
        url = url_action;
        if(extra_filters!=undefined)//SI EXISTEN FILTROS EXTRAS (SELECT, INPUT), se recive .val() y que este sea un numero entero
            $.each(extra_filters, function(){url+="/"+$('#'+this).val();});        
        paginate(0,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);
    });
    //CARGA AUTOMATICA DE LA PRIMERA PAGINA 
    if(onLoad==true)
        paginate(0,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);        
    
	//PAGINADO UTILIZANDO PRIMER,ANTERIOR,SIGUIENTE, ULTIMO
    $(id_pager + ' form .first').click(function(){//Se pagina la primera                           
        paginate(0,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);
    });     
    $(id_pager + ' form .prev').click(function(){//Se pagina la anterior
        paginate(1,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);
    }); 
    $(id_pager + ' form .next').click(function(){//Se pagina la siguiente                      
        paginate(2,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);
    }); 
     $(id_pager + ' form .last').click(function(){//Se pagina la ultima                     
        paginate(3,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);
    });        
    //CANTIDAD DE REGISTROS POR PAGINA (CHANGE)
    $(id_pager + ' form select.pagesize').change(function(){        
         paginate(0,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);
    });             
	
    $(div_table + ' thead ').delegate(' th','click',function (){//ORDENAMIENTO POR COLUMNA (CLICK)
		if(sort){
			var is = $(this).data('type');        
			if($(this).hasClass('asc') && $(this).has('input').length==0){//Ordenacion DESC
				setAllNone(div_table); 
				$(this).removeClass('none').addClass('desc');				
			}else{//Ordenacion ASC
				setAllNone(div_table);              
				$(this).removeClass('none');
				if($(this).has('input').length==0)
					$(this).addClass('asc');                        
			}       
			if(is==undefined || is =='daterange' || is =='date')
				paginate(0,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);
		}
    });	
    //FILTROS MULTIPLES
    if(multipleFilter){
        $(div_table).parent().before('<span class="multiple_filter"><table></table></span>');
        $(id_filter).remove();
    }
        
    
    var content ="";//COMBO DE CAMPOS (AUTO)
    var content_f ="<tr>";//COMBO DE CAMPOS (AUTO)
    $(id_filter+' select.filter_type').html('');  
    
    $(div_table + ' thead th').each(function (){  
        if($(this).data('type')==undefined || $(this).data('type')=="daterange" || $(this).data('type')=="date"){
            content+="<option find = '' value="+$(this).data('order')+">"+$(this).text()+"</option>";
            if(multipleFilter){
            	if($(this).data('type')=="daterange")           	
            		content_f+="<td><input class='ajax_sorter_date ajax_sorter_range' data-typeinput = 'datestart' placeholder='desde' data-id='"+$(this).data('order')+"'><input class='ajax_sorter_date ajax_sorter_range' data-typeinput = 'dateend' placeholder='hasta' data-id='"+$(this).data('order')+"'></td>";	            
				if($(this).data('type')=="date")				
					content_f+="<td><input class='ajax_sorter_date' placeholder="+$(this).text()+" data-id='"+$(this).data('order')+"'></td>";				
				if($(this).data('type')==undefined)
	                content_f+="<td><input placeholder=" +$(this).text()+" data-id='"+$(this).data('order')+"'></td>";	                	          	            
            }
        }                    
    });   
    content_f+="</tr>";
    $(multiple_filter+ ' table').append(content_f);
    $(multiple_filter+ " input.ajax_sorter_date").datepicker({ 
		dateFormat: "yy-mm-dd",changeMonth: true,
		changeYear: true,onClose:function(){ $(this).trigger('enter');}
    });
  	$(multiple_filter+ " input.ajax_sorter_date").click(function(){$(this).datepicker('show');}); 
    $(id_filter+' select.filter_type').append(content);        
    //CARGA LO QUE SE HABIA BUSCADO ANTERIORMENTE DEL CAMPO SELECCIONADO
    $(id_filter+' select.filter_type').change(function(){
        var value_option = $(id_filter+" select.filter_type option:selected").attr('find');
        if(filterTypeChange)
        	$(id_filter+" input.filter_text").val(value_option);
    });        
    $(multiple_filter).delegate('input','keydown',function(event){       
        if(event.keyCode < 8 || event.keyCode > 105)
            return false;        
    });
    $(multiple_filter).delegate('input','keyup',function(e){
         if (e.keyCode == 13) {	
              url = url_action;
            if(extra_filters!=undefined)//SI EXISTEN FILTROS EXTRAS (SELECT, INPUT), se recive .val() y que este sea un numero entero
                $.each(extra_filters, function(){ url+="/"+$('#'+this).val();});            
            paginate(0,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);            		
        }
    }).bind("enter", function(){
    	  url = url_action;
            if(extra_filters!=undefined)//SI EXISTEN FILTROS EXTRAS (SELECT, INPUT), se recive .val() y que este sea un numero entero
                $.each(extra_filters, function() { url+="/"+$('#'+this).val();});            
            paginate(0,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);            		
    });
    $(id_filter+" input.filter_text").keyup(function (e) {//BUSQUEDA (ENTER=BUSCAR)
        if (e.keyCode == 13)		
           $(this).trigger("enter");        
    }).bind("enter", function(){ 
        //SI EL HISTORIAL ES DESACTIVADO
        if($(id_filter+" input.keep_filter").is(':checked')==false){            
            $(id_filter + ' select.filter_type option').each(function (){        
                $(this).attr('find', '').removeAttr('equ');                        
            });
        }
        var tipoComp = $(id_filter+ " select.filter_equ").val();
        if(tipoComp!=undefined)                        
            $(id_filter+ " select.filter_type option:selected").attr('find',$(id_filter+" input.filter_text").val()).attr('equ',tipoComp);                           
        else
            $(id_filter+ " select.filter_type option:selected").attr('find',$(id_filter+" input.filter_text").val());                        
                    
        //AGREGA A LA TABLA DE FILTROS LOS FILTROS PREVIOS ACTIVOS 
        var fil_pre='';
        var head='';
        $(id_pager+' ul.order_list').html('');
        head+="<li class='list_header' relation ='all-items' title='DOBLE CLICK PARA ELIMINAR LOS FILTROS'>Filtros</li>";            
        $(id_filter + ' select.filter_type option').each(function (){                 
            if($(this).attr('find')!='')
                fil_pre+="<li class='show_li' relation='"+$(this).val()+"' title='DOBLE CLICK PARA ELIMINAR FILTRO'>"+$(this).text()+":"+$(this).attr('find')+"</li>";            
        }); 
        if(fil_pre!='')
            fil_pre = head + fil_pre;
        if($(id_filter+" input.keep_filter").is(':checked')==true)
            $(id_pager+' ul.order_list').append(fil_pre);                
        //OPCIONES PARA QUE SE PUEDAN BORRAR CON DOBLE CLICK
        $(id_pager+' ul.order_list li').dblclick(function(){                       
            //ENCUENTRA EL SELECCIONADO Y LO CAMBIA A NULO
            var relation = this;
            $(id_filter+ ' select.filter_type option').each(function(){                
                if($(relation).attr('relation')=='all-items')//ELIMINA TODOS LOS FILTROS
                    $(this).attr('find','').removeAttr('equ');                   
                else if($(this).val()==$(relation).attr('relation'))//ELIMINA UNO
                    $(this).attr('find','').removeAttr('equ');                               
            });                                   
            if($(relation).attr('relation')=='all-items'){////REMUEVE TODOS LOS FILTROS
                $(id_pager+' ul.order_list').html('');
            }else{//REMUEVE EL FILTRO EN LA TABLA DE FILTROS
                $(relation).remove();                 
                if($(id_filter+' ul.order_list li').length==1)
                    $(id_pager+' ul.order_list').html('');
            }
            $(id_filter+" input.filter_text").val('');                       
            //PAGINA NUEVAMENTE
            paginate(0,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);
        });		
			paginate(0,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);        
    });        
    $(id_filter+" input.keep_filter").change(function(){
        if($(this).is(':checked')==false)                        
            $(id_filter + ' select.filter_type option').each(function (){ $(this).attr('find', ''); });                                                 
        
        $(id_pager+' ul.order_list').html(''); 
        paginate(0,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter); 
    });               
    //ELIMINA FILTROS
    $(id_filter+" input.keep_filter").change(function(){
        if($(this).is(':checked')==false)
            $(id_filter + ' select.filter_type option').each(function(){ $(this).attr('find', ''); });                
    });        
    //CAMBIO DE HOJA MANUAL (ENTER=FIN)
    $(id_pager+" input.pagedisplay").keyup(function (e) {
        if (e.keyCode == 13)
          $(this).trigger("enter");        
    }).bind("enter", function(){        
        paginate(4,url,id_pager,div_table,id_filter,verifyOrdered(div_table),active,onSuccess,multipleFilter);
    });      
	if(sort)
		setAllNone(div_table); 			
	//Si hay variedad de colores 
	if(active!=false){                    	
    	if(typeof (active[1]) == "object"){
    		estilo = "<style>";
    		$.each(active[1],function(id,val){
    			estilo+= div_table + " tbody tr.color_"+id+" td {color:"+val+"}";
    		});
    		estilo+= "</style>";    		
    		$('body').append(estilo);          		   
    	}    
   }
     
	function verifyOrdered(div_table){//OBTIENE EL ORDENAMIENTO ACTUAL    
		var isIsOrdered ="";
		$(div_table + ' thead th').each(function(){
			if($(this).hasClass('asc'))
				isIsOrdered =$(this).data('order');			
			if($(this).hasClass('desc'))
				isIsOrdered =$(this).data('order')+' desc';			
		});
		return isIsOrdered;
	}
	function paginate(side,url,id_pager,ajxdiv,id_filter,order,active,onSuccess,multipleFilter){  
		var radio_name=ajxdiv.toString().replace(/.ajaxSorter/,'');
		radio_name=radio_name.replace('#','');
		radio_name=$.trim(radio_name);
		var max_pp =$(id_pager+' form select').val(); 
		if(max_pp==undefined)
			max_pp = 0;
		var id_display = id_pager+' form input.pagedisplay';
		var id_displayMax =id_pager+' form input.pagedisplayMax';
		var pagina = parseInt($(id_display).val(), 10);  
		var radio_count=0;
		var main_selector = ajxdiv;
		main_selector = main_selector.replace('.ajaxSorter','');
		$(ajxdiv + " tbody").html('');
		$(ajxdiv).parent().addClass('loading');	
		//SE PAGINA EN BASE AL LINK SELECCIONADO
		var n_rows = parseInt($(id_displayMax).val(), 10);
		
		if(!isNaN(pagina)){//Si es una cantidad valida lo pagina        
			pagina--;//Ajuste                   
			if(side == 0)//Pagina 0
				pagina = 0;
			else if(side == 1){//Anterior
				if(pagina >=1)
				pagina = pagina - 1;
			}else if(side == 2){//Siguiente
				if(pagina < (n_rows-1))
				pagina = pagina + 1;                                   
			}else if(side==3)//Ultima
				pagina = n_rows - 1;
			else{
				if(pagina>=n_rows || pagina<0)
					pagina = 0;				
			}            
		}else
			pagina = 0;       		   
		//CARGA DE CAMPOS VISIBLES
		var fields = [];
		var tot_fields=[];
		$(ajxdiv + " thead th").each(function(){ 
			if($.inArray($(this).data('order'),tot_fields)==-1 || ($(this).data('type')!=undefined && $(this).data('type')!='daterange'))  
				tot_fields.push($(this).data('order'));     
			fields.push($(this).data('order'));  
			if($(this).data('type')!=undefined && $(this).data('type')=='daterange')    
				fields.push($(this).data('order')); 				
			if($(this).data('type')!=undefined && $(this).data('type')=='radio')    
				radio_count++;
		}); 
		var type = [];
		$(ajxdiv + " thead th").each(function(){        
			var is = $(this).data('type');        
			if(is!=undefined)
				type.push(is);  
			else
				type.push("");        
		}); 
		
		var condition_equ =[];            
		$(id_filter + " select.filter_type option").each(function(){   
			var equ = $(this).attr('equ');       
			condition_equ.push((equ!=undefined)?equ:'like');
		});     
		var condition_values =[];            
		$(id_filter + " select.filter_type option").each(function(){        
			condition_values.push((($(this).attr('find'))?($(this).attr('find')):''));
		}); 
		if(multipleFilter){			
			condition_equ =[];
			condition_values=[];
			$(main_selector+' span.multiple_filter input').each(function(){
				is = $(this).data('typeinput');   
				equ = (is!=undefined || is=='datestart' || is=='dateend')?((is=='datestart')?'>>':'<<'):'like';				
				val = $(this).val();
				val.replace(',', '');
				condition_equ.push(equ);
				condition_values.push(val);
			});
		}       
		if(condition_values.length==0){
			for(i_t=0;i_t<fields.length;i_t++)
				condition_values.push("");
		}    
		//REVISA LOS FILTROS QUE ESTAS MANDANDO!    
		//console.log(fields);         
		//console.log(condition_values);
		//console.log(condition_equ);    
		//console.log(type);       
		
		$.ajax({//SE CARGA CON AJAX       
			type: "POST",
			url: url,
			data: "pa="+ pagina+"&max_pp="+max_pp+"&order="+order+"&field="+fields+"&value="+condition_values+"&equ="+condition_equ,
			success: function(msg){
				var obj = eval(msg);
				var tr="";                   
				var rows = obj['rows'];
				//OBTENEMOS LA CANTIDAD DE ROWS      
				var nr = obj['num_rows'];
				$(ajxdiv).parent().parent().data('num_rows',nr);
				var ro = nr;                     
				if((nr%max_pp)==0)        
					nr = (nr-(nr%max_pp))/max_pp;        
				else
					nr = ((nr-(nr%max_pp))/max_pp)+1;
				            
				if(isNaN(nr) && ro >0)
					nr = 1;
				else if(isNaN(nr) && ro ==0)
					nr = 0;
				
				$(id_displayMax).val(nr);  				
				$(ajxdiv + " tbody").html(tr);                                                           
				if(rows.length>0){                     
					for(i = 0; i < rows.length;i++){  
						var row_tipo = ((i%2)==0)?'odd':'even';
						tr+="<tr";
						if(active!=false){                    	
							if(typeof (active[1]) == "object"){                    		
								tr+=" class='color_"+rows[i][active[0]]+' '+row_tipo+"' ";                           		         		   
							}else {
								if(rows[i][active[0]]==active[1]){
									tr+=" class='active "+row_tipo+"' ";                                 	
								}else
									tr+=" class='"+row_tipo+"' ";                      
							}                            
						}else{
							tr+=" class='"+row_tipo+"' ";  
						}
						$.each(rows[i], function(id,val) {//SE POSICIONAN LOS VALORES DENTRO DEL TR PARA SU TRABAJO                        							
							tr+= ' data-'+id+'="'+val+'"';entra = 0;                        
						});
						tr+=">";						
						for(iti = 0;iti<tot_fields.length;iti++){    										  
						   $.each(rows[i], function(id,val) {                           																					 
								if(id==tot_fields[iti]){//SE VALIDA PARA MOSTRAR LAS COLUMNAS SOLICITADAS                                                
									if(type[iti]=="checkbox" || type[iti]=="radio" ){
										tr+="<td align='center'><input type="+type[iti]+" value='"+val+"' name='"+((radio_count>1)?(radio_name+'_radio_'+i):(radio_name+'_radio'))+"'></td>"; 
										//tr+="<td align='center'><input type="+type[iti]+" value='"+val+"' "+((,'string',false))?" class='"+i_fields[iti].class+"' ":"")+" name='"+((radio_count>1)?(radio_name+'_radio_'+i):(radio_name+'_radio'))+"'></td>"; 
									}else
									   tr+="<td>"+val+"</td>"; 
								}                            
							});                           
						}
						tr+="</tr>";    						
					}
				}else
					tr='<tr><td colspan="'+tot_fields.length+'" align="center" class="ajaxSorterNULL">No existen registros</td></tr>';				
				$(ajxdiv + " tbody").append(tr);				
				//SE OBTIENE LAS MEDIDAS DE LOS CAMPOS
				$.each($(ajxdiv + " thead th"),function(id){					
					percentaje = $(this).css('width');
					percentaje = ((parseFloat(percentaje)+10)/(parseFloat($(ajxdiv).css('width'))))*98;
					$(main_selector+' span.multiple_filter table tr td:nth-child('+(id+1)+')').css('width',percentaje+'%');                								   
				});				
				//SE crea estilos de colores				
				$(ajxdiv).parent().removeClass('loading');			
				if(onSuccess!=false){					
					if($.type(onSuccess) === "function")
						onSuccess();										                    					
				}  
			}
		});             
		pagina++;//AJUSTE       
		$(id_display).val(pagina);  
	}    
	function setAllNone(div_table){//CANCELA ORDENAMIENTOS
	   $(div_table + ' thead th').each(function(){
		   if($(this).has('input').length==0)
				$(this).removeClass('asc').removeClass('desc').addClass('none');				
		   
	   });  
	}   
	function clean_var(v,type,v_default){
		if($.type(v)==="undefined")
			v = v_default;
		else
			if($.type(v)!==type) 
				v = v_default;	
		return v;
	}
	function create_table(show,size){		
		var html = '',t_size='ajaxTable';
		if(size==5)
			t_size='ajaxTableH';
		if($.type(show)==="array"){			
			html = '<div class="'+t_size+'"><table class="ajaxSorter"><thead>';
				$.each(show,function(id,val){
					if($.type(val)==='string')
						html+='<th data-order="'+val+'">'+val+'</th>';					
					else{							
						var h_order = ($.type(val.field)!=='undefined' && $.type(val.field)==='string')?' data-order="'+val.field+'" ':false;
						var h_style = ($.type(val.style)!=='undefined' && $.type(val.style)==='string')?' style="'+val.style+'" ':'';
						var h_type = ($.type(val.type)!=='undefined' && $.type(val.type)==='string')?' data-type="'+val.type+'" ':'';
						var h_text = ($.type(val.text)!=='undefined' && $.type(val.text)==='string')?val.text:((h_order)?val.field:'');
						if(h_order){
							html+='<th '+h_order+h_style+h_type+' >'+h_text+'</th>';							
						}else
							console.log('El nombre del campo no esta definido, se ignorarÃ¡.');													
					}
				});
			html+= '</thead><tbody></tbody></table></div>';						
		}
		return html;
	}
	function create_paginator(paginator,options){
		var url_exp_action = 'http://virtual.upsin.edu.mx/sistemas/index.php/reporter';
		var url_images = 'http://virtual.upsin.edu.mx/sistemas/assets/images/pager/';
		var html='';
		options.first = clean_var(paginatorOptions.first,'boolean',true);
		options.prev = clean_var(paginatorOptions.prev,'boolean',true);
		options.next = clean_var(paginatorOptions.next,'boolean',true);
		options.last = clean_var(paginatorOptions.last,'boolean',true);
		options.exportXls = clean_var(paginatorOptions.exportXls,'boolean',false);
		options.print = clean_var(paginatorOptions.print,'boolean',false);		
		options.show = clean_var(paginatorOptions.show,'array',[10,20,30]);		
		if(paginator){			
			html+='<div class="ajaxpager">';				
			html+='<form '+((options.exportXls)?'action="'+url_exp_action+'"':'')+'" method="POST" >';
			if(options.first)
				html+='<img src="'+url_images+'first.png" class="first">&nbsp;';
			if(options.prev)
				html+='<img src="'+url_images+'prev.png" class="prev">&nbsp;';			
				html+='<input type="text" class="pagedisplay" size="5">&nbsp;-&nbsp;<input type="text" class="pagedisplayMax" size="5" readonly="readonly" disabled="disabled">&nbsp;';
			if(options.next)
				html+='<img src="'+url_images+'next.png" class="next">&nbsp;';
			if(options.last)
				html+='<img src="'+url_images+'last.png" class="last">&nbsp;';				
				html+='<select class="pagesize">';
				for(i = 0; i < options.show.length;i++){
					if($.type(options.show[i])==="string"){
						if(options.show[i]=='all')
							html+='<option value="0">Todos</option>';						
						else
							html+='<option value="'+options.show[i]+'" selected="selected">'+options.show[i]+'</option>';						
					}else if($.type(options.show[i])==="number")	
						html+='<option value="'+options.show[i]+'">'+options.show[i]+'</option>';						
				}
				html+='</select>&nbsp;';
			if(options.exportXls)
				html+='<img class="exporter" src="'+url_images+'export.png" style="float: right; margin-right:5px;">&nbsp;';
			if(options.print)
				html+='<img class="printer" src="'+url_images+'print.png" data-url="<?= base_url()?>" style="float: right">&nbsp;';				
			if(options.print || options.exportXls)
				html+='<input type="hidden" name="tabla" value ="" class="htmlTable"/>';
			html+='</form></div>';
		}	
		return html;					
	}
}; 