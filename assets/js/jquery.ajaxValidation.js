jQuery.fn.ajaxValidation=function(obj){

function crearDiv($this_input){
	mensaje=$this_input.data('message');
	if(mensaje==undefined || $.trim(mensaje)==''){
		msg=mensaje_defecto;
	}else{
		msg=$this_input.data('message');
	}
	pos=$this_input.position();
	
	var w=$this_input.outerWidth();
	var h=$this_input.outerHeight();
	var idAjax=$this_input.attr('id')+"_ajaxValidationStr";
	//mensaje="Este dato es incorrecto";
	x=$this_input.after('<div id="'+idAjax+'" class="tooltipAjaxValidation" style="display:none;">'+msg+'</div>');
	$("#"+idAjax).css({
		border: "solid black",
		color: "black",
		//textShadow: "-1px 0 white, 0 1px white, 1px 0 white, 0 -1px white",
		backgroundColor: "rgba(115, 173, 236, 0.611765)",
		borderColor: "rgba(0, 0, 0, 0.55)",
		borderWidth: "1px 1px 1px 1px",
		borderRadius: "2px ",
		padding: "2px"
	});
}
function showDiv($this_input){
	idAjax=$this_input.attr('id')+"_ajaxValidationStr";
	pos=$this_input.position();
	
	w=$this_input.outerWidth();
	h=$this_input.outerHeight();
	i_h=$this_input.innerHeight();
	
	v_top=(pos.top);
	v_left=(pos.left+w+2);
	$("#"+idAjax).css({
		position: "absolute",
		top: v_top+"px",
		left: v_left+"px"
	});
	$("#"+idAjax).show();
}
function hideDiv($this_input){
	idAjax=$this_input.attr('id')+"_ajaxValidationStr";
	$("#"+idAjax).hide();
}
function check($this_t,extra){
	
	if(extra==undefined || extra!=true){extra=false;}
			$this_input=$this_t;
			
			min=$this_input.data('min_length');
			max=$this_input.data('max_length');
			min_range=$this_input.data('min_range');
			max_range=$this_input.data('max_range');
			if($this_input.hasClass('alfabetico')){
				//search(/[^a-zA-Z]+/)
				val=($this_input.val());
				if(val.match(/^([a-zA-Z]+[\s]*)+$/)!=null){
					//todos los caracteres estan bien
				}else{
					//Error hay algun caracter no permitido
					if(extra==true){
						$this_input.focus();
						showDiv($this_input);
					
					}
					$this_input.addClass('valid_error');
					return false;
				}
			}
			if(min!=undefined){
				if($this_input.val().length<min){
					//el length actual es menor al minimo permitido
					//crear div para visualizar el error
					if(extra==true){
						$this_input.focus();
						showDiv($this_input);
					}
					$this_input.addClass('valid_error');
					return false;
				}
			}
			if(max!=undefined){
				//el length actual es mayor al maximo permitido
			if($this_input.val().length>max){
					//crear div para visualizar el error
					if(extra==true){
						$this_input.focus();
						showDiv($this_input);
					}
					$this_input.addClass('valid_error');
					return false;
				}
			}
			/*validacion para numeros y decimales*/
			if($this_input.hasClass('numero') || $this_input.hasClass('decimal')){
				val=($this_input.val());
				if($this_input.hasClass('numero')){
					if($this_input.hasClass('required')){
						expr=/^[0-9]+$/;
					}else{
						expr=/^[0-9]*$/;
					}
					if(val.match(expr)!=null){
						//todos los caracteres estan bien
					}else{
						//Error hay algun caracter no permitido
						if(extra==true){
							$this_input.focus();
							showDiv($this_input);
						}
						$this_input.addClass('valid_error');
						return false;
					}
				}
				if($this_input.hasClass('decimal')){
					if(val.match(/^\d*[0-9](\.\d*[0-9])?$/)!=null){
						//todos los caracteres estan bien
					}else{
						//Error hay algun caracter no permitido
						if(extra==true){
							$this_input.focus();
							showDiv($this_input);
						}
						$this_input.addClass('valid_error');
						return false;
					}
				}
			if(min_range!=undefined){
				//el length actual es mayor al maximo permitido
			if($this_input.val()<min_range){
					//crear div para visualizar el error
					
					if(extra==true){
						
						$this_input.focus();
						showDiv($this_input);
					}
					
					$this_input.addClass('valid_error');
					return false;
				}
			}
			if(max_range!=undefined){
				//el length actual es mayor al maximo permitido
			if($this_input.val()>max_range){
					//crear div para visualizar el error
					if(extra==true){
						$this_input.focus();
						showDiv($this_input);
					}
					$this_input.addClass('valid_error');
					return false;
				}
			}
			}/*Acaba validacion de numeros*/
			/*Validacion de requeridos*/
			
			if($this_input.hasClass('required')){
				
				if($.trim($this_input.val())==''){
					//crear div para visualizar error de vacio y requerido
					
					if(extra==true){
						
					
						
						$this_input.focus();
						showDiv($this_input);
						
					}
					$this_input.addClass('valid_error');
					
					return false;
				}
			}
			/*acaba validacion normal*/
			$this_input.removeClass('valid_error');
			hideDiv($this_input);
			return true;
			
}

function check_select($this_t,extra){
	if(extra==undefined || extra!=true){extra=false;}
	$this_input=$this_t;
	invalido=$this_input.data('invalido');		
	val=$this_input.attr('value');
	
	if(invalido!=undefined ){
		if(invalido==val){
			if(extra==true){
				
				$this_input.focus();
				
				showDiv($this_input);
			}
			$this_input.addClass('valid_error');
			return false;
		}else{
			
			$this_input.removeClass('valid_error');
			hideDiv($this_input);
		}
	}else{
		
		if((val==0 || val==-1) && $this_input.hasClass('required')){
			
			if(extra==true){
				$this_input.focus();
				
				showDiv($this_input);
			}
			$this_input.addClass('valid_error');
			return false;
		}else{
			$this_input.removeClass('valid_error');
			hideDiv($this_input);
		}
	}
	return true;
}
	
	$this_form=$(this);
	var tipo=$.type(obj);
	var mensaje_defecto="Campo requerido";
	
	if(tipo=="undefined" || (tipo=="string" && obj=='mensajes')){
		
			$("#"+$this_form.attr('id')+" input[type='text'] ,#"+$this_form.attr('id')+" input[type='password']").map(
				function(){
					crearDiv($(this));
				}
			);
		$("#"+$this_form.attr('id')+" select").map(
				function(){
					crearDiv($(this));
				}
			);
		
		crearDiv
		$this_form.delegate('input[type="text"] , input[type="password"]','keyup',function(){
			
			check($(this));
		});
		
		$this_form.delegate('select','blur',function(){
			
			check_select($(this));
		});
	}
	if(tipo=="string" && obj=='valid'){
		bool=true;
		$this_form.find('input[type="text"] , input[type="password"]').map(function(){
			
			if(bool==true ){
			
			bool=check($(this),true);
			}
		})
		$this_form.find('select').map(function(){
			
			if(bool==true ){
			
			bool=check_select($(this),true);
			}
		});
		if(bool){
		
			return true;
		}else{
		
			return false;
		}
		
	}
	if(tipo=="string" && obj=='reset'){
		$this_form.find('input[type="text"] , input[type="password"]').map(function(){
			$(this).attr('value','');
		});
		$this_form.find('select').map(function(){
			$(this).attr('value',0);
		});
	}
};