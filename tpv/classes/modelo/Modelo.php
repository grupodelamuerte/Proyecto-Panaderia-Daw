<?php

class Modelo {
    
    private $dataBase;
    private $datos;
    
    function __construct() {
        $this->dataBase = new DataBase();
        $this->datos = array();
    }
    
    function __destruct() { //Cierra la conexion la con la base de datos
        $this->dataBase->closeConnection();
    }
    
    /**
     * devuelve un valor del array datos a traves de su identificador    
     */
    function getDato($nombre) {
        if(isset($this->datos[$nombre])){
             return $this->datos[$nombre];
        }
        return null;
    }
    
    /**
     * Devuelve todos los datos del modelo en forma de array
     */ 
    function getDatos() {
        return $this->datos;
    }
    
    /**
     * Setea en un modelo un valor con un identificador
     */ 
    function setDato($nombre, $dato) {
        $this->datos[$nombre] = $dato;
    }
    
    /**
     * Devuelve un objeto DataBase
     */ 
    function getDataBase(){
        return $this->dataBase;
    }
    
    /**
     * Setea en el modelo un array asociativo
     */ 
    function setDatos($datos) {
        foreach($datos as $atributo => $dato){
            $this->setDato($atributo , $dato);
        }
    }
}