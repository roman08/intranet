/**
 * Efecto Botones
 */

;(function($){

	//DATOS FACTURACIÓN
		//btn actualizar datos
	    $(".submitGral").on( "click", function() {	 
	        $('.form_Datos').show("slow");
	        $('.Txt_Datos').hide("slow");
	    });

	    $(".btnRestablecer").on( "click", function() {	 
	        $('.Txt_Datos').show("slow");
	        $('.form_Datos').hide("slow");
	    });    

	//BOTON SUBMIT ENVIAR A PROVEEDORES
	    $("#btnIngresar").on( "click", function() {	 
	        location.href="admin_home.php"
	    });


	    $("#registro").on("click", function(){
	    	location.href="admin_home.php?ver=nuevo_usuario"
	    });

})(jQuery);
