$.extend({
	send:function(options){
		
		options.debug = options.debug || false;
		options.url = options.url || false;
		options.type = options.type || "POST";
		options.data = options.data || "";
		if(options.async==false){
			options.async = false;	
		}else{
			options.async = true;
		}
		
		
		options.waitMsg =  options.waitMsg || "Espere un momento, por favor.";
		if(options.idDiv=="dialog_send_154897"){
			console.log("Id utilizado internamente, favor de usar algun otro id.");
			return false;	
		}
		options.idDiv = options.idDiv || "dialog_send_154897";
		if($("#"+options.idDiv).length==0){
			$("body").append("<div id='"+options.idDiv+"' style='display:none'></div>");	
		}
		
		
		$("#"+options.idDiv+"").dialog({
		autoOpen:false,
		modal:true,
		buttons:{
			'Cerrar':function(){
				$(this).dialog('close');
				}
			}
		});
		
		options.code404 = (typeof(options.code404)=="function")? options.code404  :  function(msg){
			
			$("#"+options.idDiv).html("Error 404: env&iacute;o notificación a sistemas");
			$("#"+options.idDiv).dialog('open');
			
			
		};
		options.code500 =  (typeof(options.code500)=="function")? options.code500 : function(msg){
			
			$("#"+options.idDiv).html("Error 500: env&iacute;o de notificación a sistemas.");
			$("#"+options.idDiv).dialog('open');
			
		};
		$.loader({
		    className:"black",
		    content:'<div>'+options.waitMsg+'</div>'
		 });
		if(options.url==false)return false;
		//console.log(options.async);
		request=$.ajax({
			url:options.url,
			data:options.data,
			type:options.type,
			async:options.async,
			statusCode: {
			    404: options.code404,
			    500: options.code500
			 },
			 success: options.success,
			 complete:function(){
			 	
			 		$.loader('close');	
			 	
			 	
			 }
			 
		});
		
	}
});