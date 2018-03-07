<?php

class Controlador {

    private $modelo;
    private $sesion;

    function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
        $this->sesion = new Session(Constant::SESSION);
        $this->getModel()->setDato('base', Constant::BASE);
        if($this->isLogged()) {
            $usuario = $this->getUser();
            $this->getModel()->setDato('usuario', $usuario->getLogin());
            if(isset($_SESSION['idTicket'])){ //Guarda el ticket actual en la sesión del usuario
                $this->getModel()->setDato('idTicket', $this->sesion->get('idTicket'));
            }
        }
    }
    
    /**
     * Accede al modelo
     */
    function getModel() {
        return $this->modelo;
    }
    
    /**
     * Accede a la sesión
     */
    function getSession() {
        return $this->sesion;
    }
    
    /**
     * Retorna el usuario activo
     */ 
    function getUser() {
        return $this->getSession()->getUser();
    }
    /**
     * Comprueba si hay sesion activa
     */ 
    function isLogged() {
        return $this->getSession()->isLogged();
    }
    
    /**
     * Comprueba si esta el tpv bloqueado
     */
    function isBlocked($block = null){
        return $this->getSession()->isBlocked($block);
    }
    /**
     * Accion por defecto
     */    
    function index(){
        if($this->isLogged()){
            //$archivo = Util::includeTemplates('templates/home_loged.html');
            //if($this->getUser()->getId() == '1'){
                $archivo = Util::includeTemplates('templates/home_loged_admin.html');
            //}
            $this->getModel()->setDato('archivo' , $archivo);
        }else{
            $archivo = Util::includeTemplates('templates/first_page.html');
            $this->getModel()->setDato('archivo' , $archivo);
        }
    }
     /**
      *  Añade productos al carro
      */ 
    function addCarro(){ 
        if($this->isLogged()){
            $id_product = Request::read('id');
            $cantidad = Request::read('cantidad');
            if($cantidad == null){
                $cantidad = 1;
            }
            //$this->getSession()->set('idTicket', Request::read('idTicket'));
            
            $product = $this->getModel()->getProduct($id_product);
            
            //echo Util::varDump($product);
            //exit;
            $carro = $this->getSession()->getCarro(); //Establece un carro en la sesión
            $carro->add($product->getId() , $product->getAttributesValues(), $cantidad);
            $this->getModel()->setDato('data' , $carro->getCarrito());
        }else{
            $this->getModel()->setDato('data' , '');
        }
    }
    
    /**
     * Borra cantidad de los productos del carro
     */
    function subCarro(){
        if($this->isLogged()){
            $id_product = Request::read('id');
            $this->getSession()->set('idTicket', Request::read('idTicket'));
            
            $product = $this->getModel()->getProduct($id_product);
            
            //echo Util::varDump($product);
            //exit;
            $carro = $this->getSession()->getCarro();
            $carro->sub($product->getId() , $product->getAttributesValues(), $cantidad = 1);
            $this->getModel()->setDato('data' , $carro->getCarrito());
        }else{
            $this->getModel()->setDato('data' , '');
        }
    }
    
    /**
     *  Elimina productos del Carro
     */ 
    function removeCarro(){
        if($this->isLogged()){
            $id_product = Request::read('id');
            $this->getSession()->set('idTicket', Request::read('idTicket'));
            
            $product = $this->getModel()->getProduct($id_product);
            
            //echo Util::varDump($product);
            //exit;
            $carro = $this->getSession()->getCarro();
            /*$carro->del($product->getId());*/
            
            $carro->del($id_product);
            $this->getModel()->setDato('data' , $carro->getCarrito());
        }else{
            $this->getModel()->setDato('data' , '');
        }
    }
    
    /**
     * Devuelve en el carro completo
     */
    function verCarro(){ 
        $carro = $this->getSession()->getCarro();
        $this->getModel()->setDato('data' , $carro->getCarrito());
    }
    
    /**
     * Resetea el carro 
     */ 
    function reiniciarCarro(){
        $this->getSession()->setCarro();
        $carro = $this->getSession()->getCarro();
        //$this->getSession()->set('idTicket', Request::read('id'));
        $this->getModel()->setDato('data' , $carro->getCarrito());
    }
        
}