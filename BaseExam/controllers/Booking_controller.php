<?php require_once 'Base_Controller.php';
// kế thừa từ BaseController
class Booking_controller extends Base_Controller{

// ===========================      quản lý đặt tour     ===================================

    function booking_tour(){
        $notification="";
        $sql = "SELECT t.*, i.img AS image                                     
                    FROM `tour` t
                    LEFT JOIN img_tour i ON t.id = i.id_tour
                    WHERE t.status = 1
                    ORDER BY t.id, i.id";
        $list_tour = $this->tourModel->tour_status($sql);

        include 'views/admin/booking_manager/book_individual_tours/content.php';
    }


    function search_booking_tour(){
    $result = [];
    $notification = "";
    $list_tour = $this->tourModel->all();

    if(isset($_GET['search_booking_tour'])){
        
        $key_word = trim($_GET['key_word']);

        if($key_word === ""){
            $notification = "Bạn chưa nhập dữ liệu";
        } else {

            foreach($list_tour as $tt){
                if(stripos($tt->name, $key_word) !== false){
                    $result[] = $tt;
                }
            }

            if(empty($result)){
                $notification = "Không tìm thấy kết quả";
            } else {
                $list_tour = $result;
            }
        }
    }

    include 'views/admin/booking_manager/book_individual_tours/content.php';
}

    function booking_individual_tours_detail($id){    //đặt tour
        $tour              = $this->tourModel->find_tour($id);                         //lấy tour tương ứng với id
        $tour_img          = $this->imgtourModel->get_img_tour($id);                   //lấy ảnh tour ở dạng một chiều

        $address           = $this->addressModel->get_address($id);                    // lấy địa điểm của tour ở dạng mảng một chiều
        $tour_supplier     = $this->toursupplierModel->find_tour_supplier($id);        // lấy danh sach loại dịch vụ

        $id_tourtype       = $tour->id_tourtype;
        $tour_type         = $this->tourtypeModel->find_tour_type($id_tourtype);       // loại tour

        $type_guide        = $tour->type_tour;
        $list_guide        = $this->tourguideModel->get_type_guide($type_guide);        // Danh sách hướng dẫn viên lọc theo id khu vực

        $schedule_details  = $this->scheduledetailsModel->find_by_tour($id);            // lấy lịch trình theo id tour

        $contract           = new Contract();
        $book_tour          = new Book_tour();
        $customer_list      = new Customer_list();
        $departure_schedule = new Departure_schedule();
        $pay                = new Pay();
        $special_request    = new Special_request();
        $departure_schedule_details = new Departure_schedule_details();   // tạo lịch trinh mới


        if(isset($_POST['order_tour'])){
            //---- Tạo lịch khởi hành ----//
            $departure_schedule->start_date       = $_POST['start_date'];
            $departure_schedule->end_date         = $_POST['end_date'];
            $departure_schedule->start_location   = $_POST['start_location'];
            $departure_schedule->end_location     = $_POST['end_location'];
            $departure_schedule->note             = $_POST['departure_schedule_note'] ?? '';
            $departure_schedule->id_tour_guide    = $_POST['tour_guide_id']?? null;
            $departure_schedule->status           = 1;

            $departureschedule_id = $this->departurescheduleModel->create($departure_schedule);

            //---tạo lịch trình chi tiết cho chuyến đi
            foreach($_POST['departure_schedule_details_content'] as $key=>$content){

                $this->departurescheduledetailsModel->insert([
                    'id_departure_schedule'  =>  $departureschedule_id,
                    'content'                =>  $content
                ]);
            }

            //---- Tạo booking ----//
            $book_tour->date                    = date("Y-m-d");
            $book_tour->total_amount            = $_POST['total_amount'];
            $book_tour->note                    = $_POST['departure_schedule_note'] ?? '';
            $book_tour->status                  = 1;
            $book_tour->quantity                = $_POST['quantity'];
            $book_tour->id_departure_schedule   = $departureschedule_id;
            $book_tour->id_tour_guide           = $_POST['tour_guide_id']?? null;
            $book_tour->id_tour                 = $id;
            $book_tour->number_of_days          = $_POST['number_of_days'];
            $book_tour->number_of_nights        = $_POST['number_of_nights'];
            $book_tour->phone                   = $_POST['phone'];
            $book_tour->customername            = $_POST['customername'];

            $book_tour_id = $this->booktourModel->create($book_tour);

            //---- Lưu danh sách khách ----//
            $names  = $_POST['name_customer'] ?? [];
            $phones = $_POST['phone_customer'] ?? [];
            $sexes  = $_POST['sex'] ?? [];

            foreach ($names as $index => $name) {
                $name  = trim($name);
                $phone = trim($phones[$index] ?? '');
                $sex   = intval($sexes[$index] ?? 0);

                // tạo đối tượng và lưu
                if ($name !== '' && $phone !== '' && $sex > 0) {
                    $customer_list = new Customer_list();
                    $customer_list->name   = $name;
                    $customer_list->phone  = $phone;
                    $customer_list->sex    = $sex;
                    $customer_list->status    = 1;
                    $customer_list->id_book_tour = $book_tour_id;

                    $this->customerlistModel->create($customer_list);
                }
            }



            //---- Lưu hợp đồng ----//
            if(isset($_FILES['content_contract']) && $_FILES['content_contract']['size'] > 0){
                $fileContract = $_FILES['content_contract'];
                $uniqueContract = time() . "_" . $fileContract['name'];
                $uploadDirContract = __DIR__ . '/../uploads/contract/';
                $pathContract = $uploadDirContract . $uniqueContract;
                move_uploaded_file($fileContract['tmp_name'], $pathContract);

                $contract->name          = $_POST['name_contract'];
                $contract->date          = date("Y-m-d");
                $contract->status        = 1;
                $contract->value         = $_POST['value_contract'];
                $contract->content       = "uploads/contract/" . $uniqueContract;
                $contract->id_book_tour  = $book_tour_id;

                $this->contractModel->create($contract);
            }

            // ------ Tạo thanh toán ------- //
            $pay ->date                  = date("Y-m-d");
            $pay ->payment_method        = $_POST['payment_method'];
            $pay ->amount_money          = $_POST['amount_money'];
            $pay ->note                  = $_POST['pay_note'];
            if($pay->amount_money == $book_tour->total_amount){      // kiểm tra thanh toán 
                $pay ->status  = 2;
            }else{
                $pay ->status = 1;
            }
            $pay ->id_book_tour          = $book_tour_id;

            $this->payModel->create($pay);   
            
            // ------ Tạo yêu cầu đặc biệt
            $special_request->date             = date("Y-m-d");
            $special_request->content          = $_POST['content_spceail'];
            $special_request->status           = 1;
            $special_request->id_book_tour     = $book_tour_id;  
            
            $this->specialrequestModel->create($special_request);

           $success = "Đặt tour thành công!";

        }

        include 'views/admin/booking_manager/book_individual_tours/detail.php';
    }


// ==================================================================================

    function tour_is_active(){                                                     // tour đang hoạt động               
        $notification="";
        $list_book_tour = $this->booktourModel->get_book_tour_all_125();        // lấy tour đang hoạt động

        include 'views/admin/booking_manager/tour_is_active/content.php';
    }

    function tour_is_active_detail($id){
        $book_tour         = $this->booktourModel->get_book_tour($id);
        $id_tour           = $book_tour->id_tour;
        $tour              = $this->tourModel->find_tour($id_tour);                         //lấy tour tương ứng với id

        $id_tourtype       = $tour->id_tourtype;
        $tour_type         = $this->tourtypeModel->find_tour_type($id_tourtype);        //Lấy loại tour 

        $address           = $this->addressModel->get_address($id_tour);                // lấy địa điểm của tour ở dạng mảng một chiều
        $tour_supplier     = $this->toursupplierModel->find_tour_supplier($id_tour);    // lấy danh sach loại dịch vụ của tour

        $type_guide        = $tour->type_tour;
        $list_guide        = $this->tourguideModel->get_type_guide($type_guide);        // Danh sách hướng dẫn viên lọc theo id khu vực

        $id_tour_guide     = $book_tour->id_tour_guide;  
        $tour_guide        = null;

        if(!empty($id_tour_guide)){   // Nếu id HDV tồn tại
            $tour_guide = $this->tourguideModel->find_tour_guide($id_tour_guide);
        }                     

        $pay               = $this->payModel->get_latest_pay($book_tour->id);              //bảng thanh toán

        $id_departure_schedule = $book_tour->id_departure_schedule;                      
        $departure_schedule    = $this->departurescheduleModel->get_departure_schedule($id_departure_schedule);  // lấy lịch khởi hành

        $list_departure_schedule_details = $this->departurescheduledetailsModel->get_all_departure_schedule_details($id_departure_schedule);  //danh sách lịch khởi hành           // lấy lịch khởi hành chi tiết

        $list_special_request  = $this->specialrequestModel->get_special_request_list($book_tour->id);             // lấy danh sách yêu cầu đặc biệt
        
        $step      = $departure_schedule->status; 
        $arr1      = ["Chuẩn bị khởi hành","Khỏi hành"];//điểm khởi hành
        $arr2      = $address;
        $arr3      = ["Kết thúc"];// điểm kết thúc

        $arr_merged = array_merge($arr1, $arr2, $arr3);

        if(isset($_POST['cancel'])){                                                                                 //hủy tour
            $amount_money = isset($_POST['amount_money_pay']) ? floatval($_POST['amount_money_pay']) : 0;
        if ($amount_money < 0 || $amount_money > 99999999.99) {
            echo "Giá trị thanh toán không hợp lệ!";
            return;
        }
        $pay1 = new Pay();   // pay mới
        $pay1->date = date('Y-m-d');
        $pay1->id_book_tour = $id;
        $pay1->status = 1;
        $pay1->amount_money = $_POST['amount_money_pay'];
        $pay1->note = null;
        $pay1->payment_method = 1;

        $update_pay                        =  $this->payModel->create($pay1);                                          //thanh toán khi hủy mặc định là online
        $delete_contract                   =  $this->contractModel->delete_contract($book_tour->id);                   //xóa bảng hợp đồng
        $customer_list                     =  $this->customerlistModel->delete_customer_list($book_tour->id);          //xóa bảng danh sách khách
        $delete_special_request            =  $this->specialrequestModel->delete_special_request($book_tour->id);                                           //xóa yêu cầu đặc biệt
        $delete_departure_schedule_details =  $this->departurescheduledetailsModel->delete_departure_schedule_details($book_tour->id_departure_schedule);  //xóa chi tiết lịch khởi hành

        $book_tour_status      = 4;
        $update_book_tour      =$this->booktourModel->update_book_tour_status($id, $book_tour_status);                   //update lại bảng book tour
 
        if($delete_contract>0 && $customer_list>0 && $delete_special_request>0 && $delete_departure_schedule_details>0 && $update_book_tour>0){
            header("Location:?action=tour_is_active&msg=success");
        }else{
            header("Location:?action=tour_is_active&msg=error");
        }

        }

        if(isset($_POST['update_tour_guide'])){      //cập nhật hướng dẫn viên cho book tour
            $this->booktourModel->update_tour_guide($_POST['id_tour_guide'], $book_tour->id);
            $this->booktourModel->update_book_tour_status($id,1);
            $this->departurescheduleModel->update__tour_guide($id_departure_schedule,$_POST['id_tour_guide']);
            header("Location:?action=tour_is_active_detail&id={$id}&msg=success");
        }

        include 'views/admin/booking_manager/tour_is_active/detail.php';
    }


    //update danh sách khách hàng
    function comtomer_list($id_book_tour){   
        $err ="";
        $success ="";  
        $book_tour = $this->booktourModel->get_book_tour($id_book_tour);      
        $customer_list = $this->customerlistModel->get_customer_list($id_book_tour);
        $tour = $this->tourModel->find_tour($book_tour->id_tour);
        $pay = $this->payModel->get_latest_pay($id_book_tour);

        if(isset($_POST['update'])){
            $old_id = array_column($customer_list,'id');            
            $new_id = $_POST['customer_id'] ?? [];                  
            $delete_id = array_diff($old_id, $new_id);               

            foreach($delete_id as $d_id){                           
                $this->customerlistModel->delete($d_id);
            }

            $names  = $_POST['name'] ?? [];
            $phones = $_POST['phone'] ?? [];
            $sexes  = $_POST['sex'] ?? [];
            $ids    = $_POST['customer_id'] ?? [];

            foreach($ids as $index => $id){                                 
                if($id){ 
                    $this->customerlistModel->update($id, [
                        'name' => $names[$index],
                        'phone'=> $phones[$index],
                        'sex'  => $sexes[$index],
                        'status'=>1
                    ]);
                } else {                                                     
                    $this->customerlistModel->insert([
                        'id_book_tour' => $id_book_tour,
                        'name' => $names[$index],
                        'phone'=> $phones[$index],
                        'sex'  => $sexes[$index],
                        'status'=>1
                    ]);
                }
            }

            //update lại giá số chỗ ở bảng book tour
            $book_tour->quantity = isset($_POST['quantity']) ? $_POST['quantity'] : $book_tour->quantity;
            $book_tour->total_amount = isset($_POST['total_money']) ? $_POST['total_money'] : $book_tour->total_amount;

            $this->booktourModel->update_price_total($book_tour);

            //tạo thanh toán mới bảng thanh toán (pay)
            $pay1 = new Pay();
            $pay1 ->date           = date('Y-m-d');
            $pay1 ->payment_method = $_POST['payment_method'];
            $pay1 ->amount_money   = $_POST['amount_money'];
            $pay1 ->note           = $_POST['note'];
            $pay1 ->id_book_tour   = $id_book_tour;

            if($book_tour->total_amount <= $pay1->amount_money){
                $pay1->status = 2; // đã thanh toán đủ
            }else{
                $pay1->status = 1; // chưa đủ
            }

            $this->payModel->create($pay1);  //tạo

            
            // Redirect và thêm thông báo
            header("Location:?action=comtomer_list&id={$id_book_tour}&msg=success");
            exit;
        }
        include 'views/admin/booking_manager/tour_is_active/customer_list.php';
    }



    
    //=====================tour đã kết thúc=======================//
    function tour_has_ended(){
        $status = 3; 
        $list_book_tour = $this->booktourModel->get_book_tour_all($status); //tour đã hoàn thành
    
        
        include 'views/admin/booking_manager/tour_has_ended/content.php';
    }

    function detail_tour_has_endes($id){
         $book_tour = $this->booktourModel->get_book_tour($id);
         $pay = $this->payModel->get_all_pay($id);                                       // thanh toán theo id
         $customer_list = $this->customerlistModel->get_customer_list($id);              // lấy danh sách khách
         $special_request = $this->specialrequestModel->get_special_request_list($id);   // lấy danh sách khách
         $diary_list = $this->tourdiaryModel->getByDepartureSchedule($book_tour->id_departure_schedule);             // lấy nhật ký tour
         $departurescheduledetails_list = $this->departurescheduledetailsModel->get_all_departure_schedule_details($book_tour->id_departure_schedule);             // lấy lịch khởi hành chi tiết
         $departure_schedule=$this->departurescheduleModel->get_departure_schedule($book_tour->id_departure_schedule);
         $tour_guide = $this->tourguideModel->find_tour_guide($id);  //HDV
        
        include 'views/admin/booking_manager/tour_has_ended/detail.php';
    }
    
    //====================== tour đã hủy =========================//

    function tour_canceled(){
        $status = 4; 
        $list_book_tour = $this->booktourModel->get_book_tour_all($status); //tour đã hủy

         include 'views/admin/booking_manager/tour_canceled/content.php';
    }

    function hidden($id){      //ẩn tour đã hủy
        $status = 6;
        $this->booktourModel->update_book_tour_status($id,$status);
        header("Location:?action=tour_canceled&msg=success");
        include 'views/admin/booking_manager/tour_canceled/content.php';
    }
}
