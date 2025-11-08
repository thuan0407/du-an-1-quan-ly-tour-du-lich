<?php require_once 'Base_Controller.php'; 

// kế thừa từ BaseController
class User_Controller extends Base_Controller{

    public function index(){
        $danhsach = $this->addressModel->all();
        include "views/user/main.php";
    }
}
?> 