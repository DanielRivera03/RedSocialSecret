/*
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
--------------------------------------------------------           
    AUTOR: DANIEL RIVERA (danielrivera03)
    Github: https://github.com/DanielRivera03
    VERSIONES TESTEADAS: 7.2 a 8.0
    -> VERSIONES INFERIORES PROBABLEMENTE TENGAN
    ALGUN CONFLICTO. TOMAR EN CUENTA.
    COPYRIGHT © 2020 - 2021
--------------------------------------------------------
*/
function ContadorCaracteresMaximo(){	
    var total=150; // TOTAL DE CARACTERES MÁXIMO
    setTimeout(function(){
    // CONTADOR DE CARACTERES PERMITIDOS
    var valor=document.getElementById('detalle_cancelacion');
    var respuesta=document.getElementById('respuesta_contador');
    var cantidad=valor.value.length;
    document.getElementById('respuesta_contador').innerHTML = cantidad + ' / ' + (total - cantidad);
    if(cantidad-total==0){ // SI CONTADOR LLEGA A "CERO / 0" ENTONCES
        respuesta.style.color = "red"; // CAMBIA A ESTADO ROJO
    }else{ // CASO CONTRARIO
        respuesta.style.color = "green"; // ESTADO VERDE
    }
    },10);
}

function ContadorCaracteresMaximoPublicaciones(){	
    var total=150; // TOTAL DE CARACTERES MÁXIMO
    setTimeout(function(){
    // CONTADOR DE CARACTERES PERMITIDOS
    var valor=document.getElementById('publicaciones_usuarios');
    var respuesta=document.getElementById('respuesta_contador');
    var cantidad=valor.value.length;
    document.getElementById('respuesta_contador').innerHTML = cantidad + ' / ' + (total - cantidad);
    if(cantidad-total==0){ // SI CONTADOR LLEGA A "CERO / 0" ENTONCES
        respuesta.style.color = "red"; // CAMBIA A ESTADO ROJO
    }else{ // CASO CONTRARIO
        respuesta.style.color = "green"; // ESTADO VERDE
    }
    },10);
}