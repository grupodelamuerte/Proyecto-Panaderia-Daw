<?php
// Inicio de sesión 
// session_start(); 
 
// // si hay un parámetro "lang" en la URL...  
// if( isset( $_GET[ 'lang' ] ) ) { 
 
//     // ... define una variable de sesión llamada WPLANG basada en el parámetro de la URL...     
//     $_SESSION[ 'WPLANG' ] = $_GET[ 'lang' ]; 
 
//     // ...y define la constante WPLANG con la variable de sesión WPLANG 
//     define( 'WPLANG', $_SESSION[ 'WPLANG' ] ); 
 
// // si no hay un parámetro "lang" en la URL...  
// } else {
 
//     // si la variable de sesión WPLANG ya está establecida...
//     if( isset( $_SESSION[ 'WPLANG' ] ) ) {
 
//         // ...define la constante WPLANG con la variable de sesión WPLANG 
//         define( 'WPLANG', $_SESSION[ 'WPLANG' ] );  
 
//     // si la variable de sesión WPLANG no se ha establecido...
//     } else { 
         
//         // establece la constante WPLANG a tu código de idioma por defecto (o lo dejas vacío si no lo necesitas)        
//         define( 'WPLANG', 'es_ES' ); 
             
//     } 
// } 