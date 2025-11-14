<?php require_once 'Base_Controller.php'; 

// kế thừa từ BaseController
class Admin_Controller extends Base_Controller{
    function __construct(){
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role'])) {
            header("Location: ?action=login_admin");
            exit;
        }

        if ((int)$_SESSION['user']['role'] !== 1) {
            header("Location: ?action=home_user");
            exit;
        }
    } 
    function home_admin(){
        include 'views/admin/home_admin.php';
    }


    function layout_static(){
        include 'views/admin/layout_static.php';
    }
}
?> 