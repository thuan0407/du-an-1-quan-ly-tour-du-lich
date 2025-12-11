<?php require_once 'Base_Controller.php'; 

// kế thừa từ BaseController
class Tour_guide_Controller extends Base_Controller{
        //code thằng e Hùng

            private $model;
            private $tourDiaryModel;
            
        public function __construct() {
        $this->model = new Tour_guide_Model();
        $this->specialrequestModel = new Special_request_Model();
        $this->tourModel = new Tour_Model();
        $this->booktourModel           = new Book_tour_Model();
        $this->addressModel            = new Address_Model();
        $this->rollcallModel           = new Roll_call_Model();
        $this->rollcalldetailModel = new Roll_call_detail_Model();
        }

    // ================== ĐĂNG NHẬP HƯỚNG DẪN VIÊN =======================
    public function guide_login() {
        $err = "";

        if (isset($_POST['login_guide'])) {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $guide = $this->model->login($email, $password);

            if ($guide) {
                $_SESSION['guide_id'] = $guide->id;
                header("Location: ?action=home_guide");
                exit;
            } else {
                $err = "Email hoặc mật khẩu không chính xác!";
            }
        }

        require './views/login_register/login_guide.php';
    }


    // ================== ĐĂNG XUẤT =======================
    public function guide_logout() {
        unset($_SESSION['guide_id']);
        header("Location: ?action=login_guide");
        exit;
    }


    // ================== HỒ SƠ =======================
    public function profile() {
        $guide_id = $_SESSION['guide_id'] ?? null;

        if (!$guide_id) {
            header("Location: ?action=login_guide");
            return;
        }

        $guide = $this->model->find_tour_guide($guide_id);

        // Lấy lịch để hiển thị trong dashboard
        $this->departurescheduleModel = new departure_schedule_Model();
        $schedules = $this->departurescheduleModel->getByGuide($guide_id);

        // View cần hiển thị
        $viewFile = "./views/tour_guide/profile.php";

        // Load layout
        require './views/tour_guide/home_guide.php';
    }


        // ================== CHỈNH SỬA HỒ SƠ =======================
    public function edit_profile() {
    $guide_id = $_SESSION['guide_id'] ?? null;

    if (!$guide_id) {
        header("Location: ?action=login_guide");
        return;
    }

    $guide = $this->model->find_tour_guide($guide_id);

    if (isset($_POST['update_profile'])) {
        $name = trim($_POST['name']);
        $sex = intval($_POST['sex']);
        $phone_number = trim($_POST['phone_number']);
        $password = trim($_POST['password']);
        $year_birth = $_POST['year_birth'] ?? null; // mới

        if ($password === '') $password = null;

        $img_path = null;
        if (!empty($_FILES['img']['name'])) {
            try {
                $img_path = upload_file('imgs', $_FILES['img']);
            } catch (Exception $e) {
                $err = $e->getMessage();
            }
        }

        $this->model->updateProfile($guide_id, $name, $sex, $phone_number, $password, $img_path, $year_birth);
        header("Location: ?action=home_guide");
        exit;
    }

    $viewFile = "./views/tour_guide/edit_profile.php";
    require './views/tour_guide/home_guide.php';
}




    // ================== LỊCH LÀM VIỆC =======================
    public function schedule() {
        $guide_id = $_SESSION['guide_id'] ?? null;
        // Lấy ID HDV từ session
        if (!$guide_id) {
            header("Location: ?action=login_guide");
            return;
        }

        $guide = $this->model->find_tour_guide($guide_id);

        $this->departurescheduleModel = new departure_schedule_Model();
        $schedules = $this->departurescheduleModel->getByGuide($guide_id);
        

        foreach ($schedules as $schedule) {
        // Nếu status = null hoặc 0 thì tự động tính theo thời gian
            if (empty($schedule->status)) {
                $now = new DateTime();
                $start = new DateTime($schedule->start_date);
                $end = new DateTime($schedule->end_date);

                if ($now < $start) $schedule->status = 1;   // Chuẩn bị
                elseif ($now >= $start && $now <= $end) $schedule->status = 2; // Đang diễn ra
                else $schedule->status = 3; // Đã kết thúc
            } 
        }
        // View lịch làm việc
        $viewFile = "./views/tour_guide/schedule.php";

        // Load layout
        require './views/tour_guide/home_guide.php';
    }


    public function schedule_detail() {
        $guide_id = $_SESSION['guide_id'] ?? null;
        if (!$guide_id) {
            header("Location: ?action=login_guide");
            return;
        }

        if (!isset($_GET['id'])) {
            echo "Thiếu ID lịch làm việc!";
            return;
        }

        $id = intval($_GET['id']);
        $guide = $this->model->find_tour_guide($guide_id);
        $tours = $this->booktourModel->getAllTours(); // gọi model
        $this->departurescheduleModel = new departure_schedule_Model();
        $detail = $this->departurescheduleModel->findDetail($id);
        $id_book_tour = $detail->book_id;
        $book_tour = $this->booktourModel->get_book_tour($id_book_tour);    //lấy booking tour theo id

        $id_tour = $book_tour->id_tour;
        $address = $this->addressModel->get_address($id_tour);  // lấy thông tin tour theo id tour

        $id_departure_schedule = $book_tour->id_departure_schedule;                      
        $departure_schedule    = $this->departurescheduleModel->get_departure_schedule($id_departure_schedule);  // lấy lịch khởi hành

        $this->toursupplierModel = new Tour_supplier_Model();
        $services = $this->toursupplierModel->getTourServices($id_tour);

        $this->departurescheduledetailsModel = new Departure_schedule_details_Model();        
        $sts=$this->departurescheduledetailsModel->get_all_departure_schedule_details($id_departure_schedule); // lấy chi tiết lịch khởi hành
        $step      = $departure_schedule->status; 
        

        $arr1      = ["Chuẩn bị khởi hành","Khỏi hành"];//điểm khởi hành
        $arr2      = $address;
        $arr3      = ["Kết thúc"];// điểm kết thúc
        
        $arr_merged = array_merge($arr1, $arr2, $arr3);     


        if(isset($_POST['add'])){
            $status = $departure_schedule->status + 1;
            $this->departurescheduleModel->update_status_departurescheduleModel($departure_schedule->id,$status);
            header("Location: ?action=schedule_detail&id=".$id);
            exit();
        }

        if(isset($_POST['back'])){
            $status = $departure_schedule->status - 1;
            $this->departurescheduleModel->update_status_departurescheduleModel($departure_schedule->id,$status);
            header("Location: ?action=schedule_detail&id=".$id);
            exit();
        }





        if (!$detail) {
            echo "Không tìm thấy lịch làm việc!";
            return;
        }

        // Load view chi tiết
        $viewFile = "./views/tour_guide/schedule_detail.php";
        require './views/tour_guide/home_guide.php';
    }


    public function update_schedule_status() {
        $guide_id = $_SESSION['guide_id'] ?? null;
        if (!$guide_id) {
            header("Location: ?action=login_guide");
            return;
        }

        if (!isset($_GET['id'], $_POST['status'])) {
            header("Location: ?action=schedule_guide");
            return;
        }

        $id = intval($_GET['id']);
        $status = intval($_POST['status']);

        $this->departurescheduleModel = new departure_schedule_Model();
        $this->departurescheduleModel->updateStatus($id, $status);

        header("Location: ?action=schedule_guide");
        exit;
    }

    public function tour_diary() {
    $guide_id = $_SESSION['guide_id'] ?? null;
    if (!$guide_id) {
        header("Location: ?action=login_guide");
        return;
    }

    if (!isset($_GET['schedule_id'])) {
        echo "Thiếu ID lịch làm việc!";
        return;
    }

    $schedule_id = intval($_GET['schedule_id']);
    $this->tourDiaryModel = new Tour_diary_Model();

    // Xử lý tạo nhật ký mới
    if (isset($_POST['submit_diary'])) {
        $content = trim($_POST['content']);
        $evaluation = trim($_POST['service_provider_evaluation']);
        $note = trim($_POST['note']);
        $img = null;

        if (!empty($_FILES['img']['name'])) {
            $img = upload_file('imgs', $_FILES['img']); // hàm upload_file của bạn
        }

        $this->tourDiaryModel->create($guide_id, $schedule_id, $content, $img, $evaluation, $note);
        header("Location: ?action=tour_diary&schedule_id={$schedule_id}");
        exit;
        }

        // Lấy danh sách nhật ký của HDV và lịch tour
        $diaries = $this->tourDiaryModel->getBySchedule($guide_id, $schedule_id);

        // Lấy thông tin HDV để truyền vào view
        $guide = $this->model->find_tour_guide($guide_id);

        $viewFile = "./views/tour_guide/tour_journal.php";
        require './views/tour_guide/home_guide.php';
    }

    
    public function delete_diary() {
        $guide_id = $_SESSION['guide_id'] ?? null;
        if (!$guide_id) {
            header("Location: ?action=login_guide");
            return;
        }

        if (!isset($_GET['id'], $_GET['schedule_id'])) {
            echo "Thiếu thông tin để xóa nhật ký!";
            return;
        }

        $diary_id = intval($_GET['id']);
        $schedule_id = intval($_GET['schedule_id']);

        $this->tourDiaryModel = new Tour_diary_Model();
        $this->tourDiaryModel->delete($diary_id);

        // Quay lại trang nhật ký
        header("Location: ?action=tour_diary&schedule_id={$schedule_id}");
        exit;
        }

// ================== DANH SÁCH YÊU CẦU ĐẶC BIỆT =======================
    public function special_request_index() {
    $guide_id = $_SESSION['guide_id'] ?? null;
    if (!$guide_id) {
        header("Location: ?action=login_guide");
        return;
    }

    if (!isset($_GET['id_book_tour'])) {
        echo "Thiếu ID book tour!";
        return;
    }
    
    $id_book_tour = intval($_GET['id_book_tour']);

    // SỬA Ở ĐÂY
    $special_requests = $this->specialrequestModel
                     ->getAllRequests($guide_id, $id_book_tour);

    $viewFile = "./views/tour_guide/special_request_index.php";
    require './views/tour_guide/home_guide.php';
    }


// ================== THÊM YÊU CẦU ĐẶC BIỆT =======================
public function special_request_add() {
    $guide_id = $_SESSION['guide_id'] ?? null;
    if (!$guide_id) {
        header("Location: ?action=login_guide");
        return;
    }

    if (!isset($_GET['id_book_tour'])) {
        echo "Thiếu ID tour!";
        return;
    }

    $id_book_tour = intval($_GET['id_book_tour']);

    if (isset($_POST['submit_special_request'])) {
        $data = [
            'date' => $_POST['date'] ?? date('Y-m-d'),
            'content' => trim($_POST['content']),
            'status' => $_POST['status'] ?? 0,
            'id_book_tour' => $id_book_tour,
            'id_tour_guide' => $guide_id
        ];

        $this->specialrequestModel->addSpecialRequest($data);
        header("Location: ?action=special_request_index&id_book_tour={$id_book_tour}");
        exit;
    }

    $viewFile = "./views/tour_guide/special_request_add.php";
    require './views/tour_guide/home_guide.php';
}

// ================== SỬA YÊU CẦU ĐẶC BIỆT =======================
    public function special_request_edit() {
        $guide_id = $_SESSION['guide_id'] ?? null;
        if (!$guide_id) {
            header("Location: ?action=login_guide");
            return;
        }

        if (!isset($_GET['id'], $_GET['id_book_tour'])) {
            echo "Thiếu thông tin!";
            return;
        }

        $id = intval($_GET['id']);
        $id_book_tour = intval($_GET['id_book_tour']);

        $request = $this->specialrequestModel->getSpecialRequestById($id, $guide_id, $id_book_tour);

        if (!$request) {
            echo "Không tìm thấy yêu cầu!";
            return;
        }

        if (isset($_POST['submit_special_request'])) {
            $data = [
                'date' => $_POST['date'] ?? date('Y-m-d'),
                'content' => trim($_POST['content']),
                'status' => $_POST['status'] ?? 0
            ];

            $this->specialrequestModel->updateSpecialRequest($id, $guide_id, $id_book_tour, $data);
            header("Location: ?action=special_request_index&id_book_tour={$id_book_tour}");
            exit;
        }

        $viewFile = "./views/tour_guide/special_request_edit.php";
        require './views/tour_guide/home_guide.php';
    }

// ================== CẬP NHẬT TRẠNG THÁI YÊU CẦU ĐẶC BIỆT =======================
public function update_special_request_status() {
    $guide_id = $_SESSION['guide_id'] ?? null;
    if (!$guide_id) {
        header("Location: ?action=login_guide");
        return;
    }

    if (!isset($_GET['id'], $_POST['status'], $_POST['id_book_tour'])) {
        echo "Thiếu dữ liệu!";
        return;
    }

    $id = intval($_GET['id']);
    $status = intval($_POST['status']);
    $id_book_tour = intval($_POST['id_book_tour']);

    // Update database
    $this->specialrequestModel->updateStatus($id, $guide_id, $status);

    // Quay về danh sách yêu cầu đặc biệt
    header("Location: ?action=special_request_index&id_book_tour=$id_book_tour");
    exit;
}


// // ================== Đặt tour  =======================
// public function guide_Alltour() {
//      $guide_id = $_SESSION['guide_id'] ?? null;
//     if (!$guide_id) {
//         header("Location: ?action=login_guide");
//         return;
//     }

//     $tours = $this->booktourModel->getAllTours(); // gọi model
//     $guide_id = $_SESSION['guide_id'] ?? null;
//     $guide = $this->model->find_tour_guide($guide_id);
//     $viewFile = "./views/tour_guide/guide_booktour.php";
//     require './views/tour_guide/home_guide.php';
// }

//  public function guide_booktour_detail() {
//      $guide_id = $_SESSION['guide_id'] ?? null;
//     if (!$guide_id) {
//         header("Location: ?action=login_guide");
//         return;
//     }

//         if (!isset($_GET['id'])) {
//             die("Thiếu ID tour");
//         }

//         $id = $_GET['id'];

//         // Lấy chi tiết tour
//         $tour = $this->booktourModel->getTourDetail($id);

//         if (!$tour) {
//             die("Tour không tồn tại");
//         }

//         $viewFile = "./views/tour_guide/guide_booktour_detail.php";
//         require "./views/tour_guide/home_guide.php";
//     }

//     /**
//      * Xử lý đặt tour
//      */
//     public function guide_booktour() {
//     // 1️⃣ Kiểm tra guide đã đăng nhập
//     $guide_id = $_SESSION['guide_id'] ?? null;
//     if (!$guide_id) {
//         header("Location: ?action=login_guide");
//         exit;  // exit để chắc chắn script dừng
//     }

//     // 2️⃣ Kiểm tra phương thức POST
//     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//     // truy cập trực tiếp bằng GET
//     header("Location: ?action=guide_Alltour");
//     exit;
//     }
//         // Trường hợp truy cập trực tiếp bằng GET, redirect về danh sách tour

    

//     // 3️⃣ Xử lý dữ liệu form
//     $data = [
//         'customername'          => $_POST['customername'],
//         'phone'                 => $_POST['phone'],
//         'date'                  => date("Y-m-d"),
//         'total_amount'          => $_POST['total_amount'],
//         'note'                  => $_POST['note'],
//         'number_of_days'        => $_POST['number_of_days'],
//         'number_of_nights'      => $_POST['number_of_nights'],
//         'quantity'              => $_POST['quantity'],
//         'id_departure_schedule' => $_POST['id_departure_schedule'] ?? null,
//         'id_tour_guide'         => $guide_id,
//         'id_tour'               => $_POST['id_tour']
//     ];

//     // 4️⃣ Lưu booking
//     $success = $this->booktourModel->createBooking($data);

//     // 5️⃣ Thông báo + load lại view
//     if ($success) {
//         echo '<script>
//             alert("Đặt tour thành công!");
//             window.location.href = "?action=guide_Alltour";
//         </script>';
//     } else {
//         echo '<script>
//             alert("Đặt tour thất bại!");
//             window.history.back(); // quay về trang form trước đó
//         </script>';
//         exit;
//     }  
// }




    public function pending_tour() {
        // 1️⃣ Kiểm tra hướng dẫn viên đăng nhập
        $guide_id = $_SESSION['guide_id'] ?? null;
        if (!$guide_id) {
            header("Location: ?action=login_guide");
            exit;
        }

        // 2️⃣ Lấy danh sách tour chờ duyệt từ model
        $pendingTours = $this->booktourModel->getPendingToursByGuide($guide_id);

        // 3️⃣ Truyền dữ liệu sang view
        $viewFile = "./views/tour_guide/guide_pending_tour.php";
        require "./views/tour_guide/home_guide.php";  
    }

       public function pending_detail()
        {
             $guide_id = $_SESSION['guide_id'] ?? null;
            if (!$guide_id) {
                header("Location: ?action=login_guide");
                exit;
            }

            $id = $_GET['id'] ?? null;
            if (!$id) {
                echo "Thiếu ID!";
                return;
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Nếu bấm nút Xác nhận
        if (isset($_POST['confirm'])) {
            // status = 2 
            $this->booktourModel->updateBookTourStatus($id, 2);
            header("Location: ?action=guide_pending_tour&msg=confirmed");
            exit;
        }
        if (isset($_POST['cancel'])) {
            // status = 5 
            $this->booktourModel->updateBookTourStatus($id, 5);
            header("Location: ?action=guide_pending_tour&msg=canceled");
            exit;
        }
    }
            
            $detail = $this->booktourModel->getBookTourDetail($id);
            $this->toursupplierModel = new Tour_supplier_Model();
            $id_tour = $detail->id_tour;
            $services = $this->toursupplierModel->getTourServices($id_tour);
            $viewFile = "./views/tour_guide/pending_detail.php";
            require "./views/tour_guide/home_guide.php";
        }


    public function updateStatusTour() {
            if (!isset($_GET['id'])) {
                echo "Thiếu ID!";
                return;
            }

            $id = intval($_GET['id']);
            $this->booktourModel->updateStatus($id);
            header("Location: ?action=schedule_guide");
            exit;
        }







// ================== FORM ĐIỂM DANH =======================
public function roll_call_form() {
    $guide_id = $_SESSION['guide_id'] ?? null;
    if (!$guide_id) {
        header("Location: ?action=login_guide");
        return;
    }

    if (!isset($_GET['id_departure_schedule'])) {
        echo "Thiếu ID lịch khởi hành!";
        return;
    }

    $id_departure_schedule = intval($_GET['id_departure_schedule']);

    // Lấy danh sách các phiên điểm danh của lịch trình này
    $rollCalls = $this->rollcallModel->getBySchedule($id_departure_schedule);

    // Nếu có phiên điểm danh mới nhất, lấy chi tiết từng khách
    $rollCallDetails = [];
    if (!empty($rollCalls)) {
        $latestRollCallId = $rollCalls[0]['id']; // phiên mới nhất
        $rollCallDetails = (new Roll_call_detail_Model())->getByRollCall($latestRollCallId);
    }

    $rollcalldetailModel = new Roll_call_detail_Model();

    // Lấy danh sách khách
    $customers = $rollcalldetailModel->getByDepartureSchedule($id_departure_schedule);

    // Lấy id_tour (giả sử tất cả khách cùng tour)
    $id_tour = $customers[0]['id_tour'] ?? null;

    // **Lấy danh sách chặng (address) của tour**
    $address = [];
    if ($id_tour) {
        $address = $rollcalldetailModel->getAddressesByTour($id_tour);
        
    }
    // Truyền xuống view
    $viewFile = "./views/tour_guide/rollcall.php";
    require "./views/tour_guide/home_guide.php";
    
}




// ================== CẬP NHẬT ĐIỂM DANH =======================
public function roll_call_update() {
    $guide_id = $_SESSION['guide_id'] ?? null;
    if (!$guide_id) {
        header("Location: ?action=login_guide");
        return;
    }

    if (!isset($_POST['id_departure_schedule'], $_POST['status'], $_POST['id_address']) || !is_array($_POST['status'])) {
        echo "Thiếu dữ liệu điểm danh hoặc chưa chọn chặng!";
        return;
    }

    $id_departure_schedule = intval($_POST['id_departure_schedule']);
    $id_address = intval($_POST['id_address']); // chặng được chọn
    $note = trim($_POST['note'] ?? "");

    // 1️⃣ Thêm phiên điểm danh mới
    $id_roll_call = $this->rollcallModel->insertRollCall($id_departure_schedule, $note);

    $rollcalldetailModel = new Roll_call_detail_Model();

    // 2️⃣ Lấy danh sách khách của lịch khởi hành này
    $customers = $rollcalldetailModel->getByDepartureSchedule($id_departure_schedule);

    if (empty($customers)) {
        echo "Không có khách nào để điểm danh!";
        return;
    }

    // 3️⃣ Lặp khách và insert điểm danh chỉ cho chặng được chọn
    foreach ($customers as $customer) {
        $status_value = $_POST['status'][$customer['id']] ?? 0; // trạng thái điểm danh
        $rollcalldetailModel->insertDetail($id_roll_call, $customer['id'], $id_address, $status_value);
    }

    // 4️⃣ Quay lại form điểm danh
    echo "<script>
        alert('Cập nhật điểm danh thành công!');
        window.location.href = '?action=roll_call_form&id_departure_schedule={$id_departure_schedule}';
    </script>";
    exit;
}


// ================== XEM CHI TIẾT PHIÊN ĐIỂM DANH =======================
public function rollcall_history_detail() {
    $guide_id = $_SESSION['guide_id'] ?? null;
    if (!$guide_id) {
        header("Location: ?action=login_guide");
        return;
    }

    if (!isset($_GET['id_roll_call'])) {
        echo "Thiếu ID phiên điểm danh!";
        return;
    }

    $id_roll_call = intval($_GET['id_roll_call']);

    // Model phiên điểm danh
    $rollCallModel = new Roll_call_Model();
    $rollCall = $rollCallModel->getById($id_roll_call);

    if (!$rollCall) {
        echo "Phiên điểm danh không tồn tại!";
        return;
    }

    // Model chi tiết điểm danh
    $rollCallDetailModel = new Roll_call_detail_Model();
    $details = $rollCallDetailModel->getByRollCall($id_roll_call);

    // Lấy danh sách các chặng để map id_address -> tên chặng
    $id_tour = null;
    if (!empty($details)) {
        $id_tour = $details[0]['id_tour'] ?? null;
    }
    $addresses = [];
    if ($id_tour) {
        $addressesList = $rollCallDetailModel->getAddressesByTour($id_tour);
        foreach ($addressesList as $addr) {
            $addresses[$addr['id']] = $addr['name'];
        }
    }

    // Truyền xuống view
    $viewFile = "./views/tour_guide/rollcall_history_detail.php";
    require "./views/tour_guide/home_guide.php";
}



}

?> 