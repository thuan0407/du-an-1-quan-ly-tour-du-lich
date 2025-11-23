<?php

$action = $_GET['action'] ?? '/';
$id     = $_GET['id'] ?? '';

match ($action) {
    '/'                        => (new Login_Register_Controller)->navigation(),            //phía đăng nhập đăng ký và đăng xuất
    'login_admin'              => (new Login_Register_Controller)->login_user_admin(),
    'login_guide'              => (new Login_Register_Controller)->login_guide(),
    'home_user'                => (new Login_Register_Controller)->home_user(),
    'guide_registration'       => (new Login_Register_Controller)->guide_registration(),

    'home_guide'               => (new Tour_guide_Controller)->home_guide(),          //phía hướng dẫn viên


    'home_admin'                         => (new Admin_Controller)->home_admin(),                    //phía admin
    'tour_catalog_management'            => (new Admin_Controller)->tour_catalog_management(),
    'delete_tour_tour'                   => (new Admin_Controller)->delete_tour_tour($id),  
    'update_tour_type'                   => (new Admin_Controller)->update_tour_type($id),  
    'human_resource_management'          => (new Admin_Controller)->human_resource_management(),
    'logout_admin'                       => (new Admin_Controller)->logout_admin(), 
    'update_tour_guide'                  => (new Admin_Controller)->update_tour_guide($id),

    'change_status_tour_guide'           => (new Admin_Controller)->change_status_tour_guide($id),      // quản lý hướng dẫn viên
    'add_tour_guide'                     => (new Admin_Controller)->add_tour_guide(),
    'search_tour_guide'                  => (new Admin_Controller)->search_tour_guide(),

    'tour_manager_content'               => (new Admin_Controller)->tour_manager_content(),            // quản lý tour
    'add_tour'                           => (new Admin_Controller)->add_tour(),                      
    'delete_tour'                        => (new Admin_Controller)->delete_tour($id),
    'tour_detail'                        => (new Admin_Controller)->tour_detail($id),
    'search_tour'                        => (new Admin_Controller)->search_tour(),

    'booking_content'                    => (new Admin_Controller)->booking_content(),                //quản lý đặt tour
    'search_booking_tour'                => (new Admin_Controller)->search_booking_tour(),

    'supplier_management'                => (new Admin_Controller)->supplier_management(),             //quản lý nhà cung cấp
    'edit_supplier'                      => (new Admin_Controller)->edit_supplier($id),
    default => require 'views/admin/tour_manager/.php',
    
};