<?php 

class ModeloWp extends Modelo{
    
    private $dataBase;
    private $datos;
    private $gestor;
    
    function __construct(){
        $this->dataBase = new DataBase();
        $this->datos = array();
        $this->gestor = new ManagerMix($this->dataBase);
    }
    
    function __destruct() {
        $this->dataBase->closeConnection();
    }
    
    /**
     * devuelve la cantidad de productos, miembros y clientes de la base de datos
     */
    function getCountFromWp(){
        return $this->gestor->getAll();
    }
}