jQuery.fn.help = function(obj){	
	var title = true;
	if(obj!=undefined)
		title = obj.title;
	var selector = '#'+$(this).attr('id');	
	if(title==undefined)
        title = true;  
    else{
        if(!(title==false || title==true)){
            title=true;
        }
    }
	$('.help').hover(function(event){
		if($(selector).hasClass('toggle')){			
			$(this).next().show().position({
				my: "left+10 bottom-5",
				of: event,
				collision: "fit"
			});						
			
		}
					
	},function(){
		$(this).next().hide();
	});	
	$(selector).click(function(){
		if($(this).hasClass('toggle')){
			$(this).removeClass('toggle');				
			$(this).children('span').text('Activar ayuda');
			$('.help-active').css('display','none');	
		}else{
			$(this).addClass('toggle');				
			$(this).children('span').text('Desactivar ayuda');		
			$('.help-active').css('display','block');	
		}
	});
	//INICIALIZA LOS ELEMENTOS CON EL ATRIBUTO MAP
	$('.help').map(function(){		
		if(title){
			if($(this).attr('title')!=undefined)
				$(this).after('<p class="helping"><em>&nbsp;</em><span>'+$(this).attr('title')+'</span></p>');
		}else{		
			if($(this).data('help')!=undefined)
				$(this).after('<p class="helping"><em>&nbsp;</em><span>'+$(this).data('help')+'</span></p>');
		}
		$(selector).after('<p class="helping help-active"><em>&nbsp;</em><span>La ayuda está activa, posicione el cursor sobre el elemento deseado para mostrar la ayuda referente a ese elemento.</span></p>');
	});
};