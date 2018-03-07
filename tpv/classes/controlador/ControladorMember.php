<?php

class ControladorMember extends Controlador{
    
    function index(){
        if($this->isLogged()){
            
            //$archivo = Util::includeTemplates('templates/home_loged.html');
            //if($this->getUser()->getId() == '1'){
                $archivo = Util::includeTemplates('templates/home_loged_admin.html');
            //}
            $this->getModel()->setDato('archivo' , $archivo);
        }else{
            $this->getModel()->setDato('archivo' , Util::includeTemplates('templates/first_page.html'));
        }
    }
    
    /*function generarPassAdmin(){
        echo Util::codificar('admin' , 10);
        exit;
    }*/
    
    private function renderUserTable($member){
        $plantilla = '<tr>
                        <th class="medium">
                            {{id}}
                        </th>
                        <th class="medium">
                            {{login}}
                        </th>
                        <th class="medium">
                            <div class="actions">
                                <a class="bt-action edit" href="member/edituser&id={{id}}">Edit</a>
                                <a class="bt-action remove borrar" href="member/removeUser&id={{id}}">Remove</a>
                            </div>    
                        </th>
                    </tr>';
        return Util::renderText($plantilla, $member->getAttributesValues());            
    }
    
    function listmember(){
        if($this->isLogged()){
            if($this->getUser()->getId() == '1'){
                if(Request::read('page') === null){
                    $page = 1;
                }else{
                    $page = Request::read('page');
                }
                $html = Util::includeTemplates('templates/member/_member_list.html');
                $this->getModel()->setDato('archivo' , $html);
                $cadena = '';
                $paginate = new Pagination($this->getModel()->getCount() , $page , 5);
                $members = $this->getModel()->getPaginateUser($paginate->getOffset(),  $paginate->getRpp());
                //echo Util::varDump($members);
                foreach($members as $member){
                    $cadena .= self::renderUserTable($member);
                }
                $rango = '<nav role="navigation"><div class="pagination"><a href="member/listmember&page=' . $paginate->getFirst() . '">First</a> ';
                foreach($paginate->getRange() as $number){
                    if($number == $page){
                       $rango .= '<a class="active bold" href="member/listmember&page=' . $number . '">' . $number . '</a> '; 
                    }else{
                        $rango .= '<a href="member/listmember&page=' . $number . '">' . $number . '</a> ';
                    }
                }
                $rango .= '<a href="member/listmember&page=' . $paginate->getLast() . '">Last</a></div></nav>';
                $this->getModel()->setDato('listado' , $cadena);
                $this->getModel()->setDato('rango' , $rango);
            }else{
                $this->index();
            }   
        }else{
            $this->index();
        }
    }
    
    function dologin(){
        $member = new Member();
        $member->read();
        $memberDB = $this->getModel()->getUserWhitLogin($member->getLogin());
        if(!$this->isLogged()){
            if(Util::validarCodificacion($member->getClave() , $memberDB->getClave())){
                $this->getSession()->login($memberDB);
            }
            $this->index();
        }else{
            $this->index();
        }
    }
    
    function dologout(){
        if($this->isLogged()){
            $this->getSession()->logout();
            header('Location: index.php?op=logout');
            exit;
        }else{
            $this->index();
        }
    }
    
    function insertUser(){
        if($this->isLogged() && $this->getUser()->getId() === '1'){
            $this->getModel()->setDato('archivo' , Util::includeTemplates('templates/member/_registro.html'));
        }else{
            echo Util::varDump($this->getUser());
            $this->index();
        }
    }
    
    function doInsertUser(){
        $member = new Member();
        $member->read();
        $passR = Request::read('claveRep'); 
        if($this->isLogged() && $this->getUser()->getId() === '1'){
            if($member->getClave() === $passR){
                $res = $this->getModel()->insertUser($member);
            }else{
                $res = -1;
            }
            header('Location: listmember&op=registro&res=' . $res);
            exit;
        }else{
            $this->index();
        }
    }
    
    function removeUser(){
        $id = Request::read('id');
        if($this->isLogged() && $this->getUser()->getId() === '1'){
            $res = $this->getModel()->removeUser($id);
            header('Location: listmember&op=registro&res=' . $res);
            exit;
        }else{
            $this->index();
        }
    }
    
    function edituser(){
        $id = Request::read('id');
        if($this->isLogged() && $this->getUser()->getId() === '1'){
            $this->getModel()->setDato('archivo' , Util::includeTemplates('templates/member/_edit_member.html'));
            $this->getModel()->setDatos($this->getModel()->getUser($id)->getAttributesValues());
        }else{
            $this->index();
        }
    }
    
    function doEditUser(){
        $member = new Member();
        $member->read();
        $memberDB = $this->getModel()->getUser($member->getId());
        $claveRep = Request::read('claveRep');
        echo Util::varDump($member);
        echo Util::varDump($memberDB);
        //exit;
        //exit;
        /*Acabar*/
        if($this->isLogged() && $this->getUser()->getId() === '1'){
            if($member->getClave() === $claveRep){
                $r = $this->getModel()->editUser('All' , $member);
            }else{
                $r = $this->getModel()->editUser('NoPass' , $member);
            }
            header('Location: listmember&op=editmember&res=' . $r);
        }else{
            $this->index();
        }
    }
}