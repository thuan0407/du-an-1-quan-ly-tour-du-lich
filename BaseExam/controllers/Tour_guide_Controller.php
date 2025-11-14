<?php require_once 'Base_Controller.php'; 

// kế thừa từ BaseController
class Tour_guide_Controller extends Base_Controller{
    function home_guide(){
    include 'views/tour_guide/home_guide.php';
}
}
?> 