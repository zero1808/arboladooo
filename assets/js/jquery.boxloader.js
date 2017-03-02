/*/////////////////////////////BOXLOADER 1.13.3///////////////////////////////////
 Libreria de carga automatica de combos*/

jQuery.fn.boxLoader = function(obj){
    var select_box = $(this).attr('id');
    var url = obj.url;
    var field = obj.equal;
    var all = obj.all;
    var onLoad = obj.onLoad;
	var onSuccess = obj.onSuccess;
	var selected = obj.selected;
    var id=0;
    var value=0;
    var select = {id:'id',val:'val'};//DEFAULT
    if(onLoad==undefined)
        onLoad = true;  
    else{
        if(!(onLoad==false || onLoad==true)){
            onLoad=true;
        }
    }
	if(selected==undefined)
        selected = false;      
    
    if(obj.select!=undefined){
        if(obj.select.id!=undefined && obj.select.val!=undefined)
            select = obj.select;
    }
    if(field!=undefined){//SI EXISTE  
	if(field.id!=undefined && field.value!=undefined){
            id = field.id;
            value = $(field.value).val();
        }
    }
	if(onSuccess==undefined)
		onSuccess = false;	
			
    if(url!=undefined){	
        if(field!=undefined){
            $(field.value).change(function(){     
                value=$(field.value).val();
                loadBox(select_box,url,id,value,all,select,selected,onSuccess);
                $('#idunidad').trigger('update');
            }).bind('update',function(){ 
                    if(field!=undefined)
                        value=$(field.value).val();
                    else 
                        value=0;
                    loadBox(select_box,url,id,value,all,select,selected,onSuccess);
           });   
        }
        $(this).bind('update',function(){
        	value=$(field.value).val();
            loadBox(select_box,url,id,value,all,select,selected,onSuccess);
        });                                                         
    }	
    if(onLoad==true)
        loadBox(select_box,url,id,value,all,select,selected,onSuccess);  		    
};
function loadBox(box,url,id,value,all, select,selected,onSuccess){
    var sid = select['id'];
    var sval = select['val'];    
    $.ajax({//SE CARGA CON AJAX       
        type: "POST",
        url: url,
        data: id+"="+value,
        success: function(msg){
            var obj = eval(msg);
            var options="";                                       
            //OBTENEMOS LA CANTIDAD DE ROWS                                    
            $('#'+box).html(options)   
			if(all!=undefined)
				options+='<option value="0">'+all+'</option>'; 			
            if(obj.length>0){               
                for(i = 0; i < obj.length;i++){                                
                    options+='<option value="'+obj[i][sid]+'" '+((selected==obj[i][sid])?'selected="selected"':"")+'>'+obj[i][sval]+'</option>';                                                                                     
                }
            }
            $('#'+box).append(options);
			if(onSuccess!=false){					
				if(typeof onSuccess == "function"){
					onSuccess();										
				}else
					console.debug('Lo ingresado no es una funcion, el evento se descartara');
            }			
        }
    });  
}	