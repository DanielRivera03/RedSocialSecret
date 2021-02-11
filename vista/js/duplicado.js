/*
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
--------------------------------------------------------           
    AUTOR: DANIEL RIVERA (danielrivera03)
    Github: https://github.com/DanielRivera03
    VERSIONES TESTEADAS: 7.3 a 8.0
    -> VERSIONES INFERIORES PROBABLEMENTE TENGAN
    ALGUN CONFLICTO. TOMAR EN CUENTA.
    COPYRIGHT © 2020 - 2021
--------------------------------------------------------
*/  

function comprobarUsuario() {
	$("#loaderIcon").show();
	jQuery.ajax({
	url: "../modelo/duplicado.php",
	data:'nombre_usuariounico='+$("#usuariounico").val(),
	type: "POST",
	success:function(data){
		$("#estadousuario").html(data); // MOSTRAR ESTADO USUARIO
        $("#loaderIcon").hide(); // EFECTO DE CARGA PROCESANDO INFORMACION
	},
	});
}