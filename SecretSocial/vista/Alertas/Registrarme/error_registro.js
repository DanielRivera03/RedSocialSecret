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

// ALERTA CONFIRMACION DE ERROR REGISTRO NUEVOS USUARIOS
function MensajeErrorConfirmacion(){
    Swal.fire(
        'Opss ocurrio un error',
        'Lo sentimos, ha ocurrido un error a la hora de registrar su usuario',
        'error'
    )
}