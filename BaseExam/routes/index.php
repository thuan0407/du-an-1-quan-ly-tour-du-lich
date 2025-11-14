<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'                        => (new Login_Register_Controller)->navigation(),            //phía đăng nhập đăng ký và đăng xuất
    'login_admin'              => (new Login_Register_Controller)->login_user_admin(),
    'login_guide'              => (new Login_Register_Controller)->login_guide(),
    'home_user'                => (new Login_Register_Controller)->home_user(),
    'guide_registration'       => (new Login_Register_Controller)->guide_registration(),


    'home_admin'               => (new Admin_Controller)->home_admin(),                    //phía admin
    'layout_static'            => (new Admin_Controller)->layout_static(),
};