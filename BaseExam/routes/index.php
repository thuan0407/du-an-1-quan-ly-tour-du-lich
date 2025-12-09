<?php

$action = $_GET['action'] ?? '/';
$id     = $_GET['id'] ?? '';

match ($action) {
    '/'                        => (new Login_Register_Controller)->navigation(),            //phía đăng nhập đăng ký và đăng xuất
    'login_admin'              => (new Login_Register_Controller)->login_user_admin(),
    'login_guide'              => (new Login_Register_Controller)->login_guide(),
    'home_user'                => (new Login_Register_Controller)->home_user(),
    'guide_registration'       => (new Login_Register_Controller)->guide_registration(),

    'home_guide'               => (new Tour_guide_Controller)->profile(),          //phía hướng dẫn viên
    'guide_login'              => (new Tour_guide_Controller)->guide_login(),        
    'logout_guide'             => (new Tour_guide_Controller)->guide_logout(),
    'schedule_guide'           => (new Tour_guide_Controller)->schedule(),
    'edit_profile'             => (new Tour_guide_Controller)->edit_profile(),
    'schedule_detail'          => (new Tour_guide_Controller)->schedule_detail(),
    'update_schedule_status'   => (new Tour_guide_Controller)->update_schedule_status(),
    'tour_diary'               => (new Tour_guide_Controller)->tour_diary(),
    'delete_diary'             => (new Tour_guide_Controller)->delete_diary(),


    'special_request_index'    => (new Tour_guide_Controller)->special_request_index(),
    'special_request_add'      => (new Tour_guide_Controller)->special_request_add(),
    'special_request_edit'     => (new Tour_guide_Controller)->special_request_edit(),
    'update_special_request_status' => (new Tour_guide_Controller)->update_special_request_status(),

    'guide_Alltour' => (new Tour_guide_Controller)->guide_Alltour(),
    'guide_booktour_detail' => (new Tour_guide_Controller)->guide_booktour_detail(),
    'guide_booktour'        => (new Tour_guide_Controller)->guide_booktour(),
    'guide_pending_tour'  => (new Tour_guide_Controller)->pending_tour(),
    'updateStatusTour'  => (new Tour_guide_Controller)->updateStatusTour(),

    'pending_detail'  => (new Tour_guide_Controller)->pending_detail(),

    'rollcall'  => (new Tour_guide_Controller)->rollcall(),
    'roll_call_form'  => (new Tour_guide_Controller)->roll_call_form(),
    'roll_call_update'  => (new Tour_guide_Controller)->roll_call_update(),


    //test set lich
    // 'bookhdv'  => (new Test_Controller)->bookhdv(),
    // 'add_schedule' => (new Test_Controller)->add_schedule(),
    // 'save_schedule' => (new Test_Controller)->save_schedule(),



    'home_admin'                         => (new Admin_Controller)->home_admin(),                    //phía admin
    'tour_catalog_management'            => (new Admin_Controller)->tour_catalog_management(),
    'delete_tour_tour'                   => (new Admin_Controller)->delete_tour_tour($id),  
    'update_tour_type'                   => (new Admin_Controller)->update_tour_type($id),  
    'human_resource_management'          => (new Admin_Controller)->human_resource_management(),
    'logout_admin'                       => (new Admin_Controller)->logout_admin(), 
    'update_tour_guide'                  => (new Admin_Controller)->update_tour_guide($id),


    'change_status_tour_guide'           => (new Admin_Controller)->change_status_tour_guide($id),          // quản lý hướng dẫn viên
    'add_tour_guide'                     => (new Admin_Controller)->add_tour_guide(),
    'search_tour_guide'                  => (new Admin_Controller)->search_tour_guide(),


    'tour_manager_content'               => (new Tour_Controller)->tour_manager_content(),                 // quản lý tour
    'add_tour'                           => (new Tour_Controller)->add_tour(),                      
    'delete_tour'                        => (new Tour_Controller)->delete_tour($id),
    'tour_detail'                        => (new Tour_Controller)->tour_detail($id),
    'search_tour'                        => (new Tour_Controller)->search_tour(),


    'booking_tour'                       => (new Booking_controller)->booking_tour(),                          //quản lý đặt tour lẻ
    'search_booking_tour'                => (new Booking_controller)->search_booking_tour(),
    'booking_individual_tours_detail'    => (new Booking_controller)->booking_individual_tours_detail($id),

    'tour_is_active'                     => (new Booking_controller)->tour_is_active(),                        //quản lý tour đang hoạt động
    'tour_is_active_detail'              => (new Booking_controller)->tour_is_active_detail($id),
    'comtomer_list'                      => (new Booking_controller)->comtomer_list($id),                      // danh sách hàng
   
    'tour_has_ended'                     => (new Booking_controller)->tour_has_ended(),                        //quản lý tour đã kết thú
    'hidden'                             => (new Booking_controller)->hidden($id),                             // ẩn tour đã hủy
    'tour_canceled'                      => (new Booking_controller)->tour_canceled(), 
    'detail_tour_has_endes'              => (new Booking_controller)->detail_tour_has_endes($id), 
    

    'supplier_management'                => (new Admin_Controller)->supplier_management(),                    //quản lý nhà cung cấp
    'edit_supplier'                      => (new Admin_Controller)->edit_supplier($id),
    default => require 'views/admin/tour_manager/.php',
    
};