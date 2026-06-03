"/*
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
--------------------------------------------------------           
    AUTOR: DANIEL RIVERA (danielrivera03)
    Github: https://github.com/DanielRivera03
    VERSIONES TESTEADAS: 7.3 a 8.0
    COPYRIGHT © 2020 - 2021
--------------------------------------------------------
*/ 
$(document).ready(function(){  
    // Click en botón principal de reacción (Toggle o Like simple)
    $(document).on('click', '.btn-reaccionar-action', function(e){
        e.preventDefault();
        var idPublicacion = $(this).data('id');
        var reactionType = 1; // Default: Me gusta
        
        // Si ya tiene una reacción activa, al darle clic la quitamos
        var activeIcon = $(this).find('.reaction-active-icon').length;
        if(activeIcon > 0) {
            // El backend maneja el toggle off si enviamos la misma reacción
            var textHtml = $(this).find('span').last().text();
            if(textHtml === "Me gusta") reactionType = 1;
            else if(textHtml === "Me encanta") reactionType = 2;
            else if(textHtml === "Me divierte") reactionType = 3;
            else if(textHtml === "Me asombra") reactionType = 4;
            else if(textHtml === "Me entristece") reactionType = 5;
            else if(textHtml === "Me enoja") reactionType = 6;
        }
        
        EnviarReaccion(idPublicacion, reactionType, $(this));
    });

    // Click en una reacción específica del panel flotante
    $(document).on('click', '.reaction-item', function(e){
        e.preventDefault();
        var idPublicacion = $(this).data('id');
        var reactionType = $(this).data('reaction');
        var btnTrigger = $(this).closest('.like-data-wrapper').find('.btn-reaccionar-action');
        
        EnviarReaccion(idPublicacion, reactionType, btnTrigger);
    });
});

function EnviarReaccion(idPublicacion, reactionType, btnTrigger){ \
<truncated 2917 bytes>