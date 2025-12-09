<?php require_once 'Base_Controller.php'; 

// kế thừa từ BaseController
class Tour_Controller extends Base_Controller{
    public function __construct() {
        parent::__construct(); 
        
    }
    //=============================        quản lý tour        ===============================================

    function tour_manager_content(){
        $notification="";     //thông báo lỗi  

        $selectedType = $_GET['tour_type_name'] ?? '';                                     //bộ lọc theo loại tour    
        if($selectedType){
            $list = $this->tourModel->getToursByType($selectedType);
        } else {
            $list = $this->tourModel->all();
        }

        $price = $_GET['price'] ?? '';
            if ($price == 1){
                $list = $this->tourModel->getToursHigh();   // GIÁ CAO → THẤP
            }
            elseif ($price == 2){
                $list = $this->tourModel->getToursShort();  // GIÁ THẤP → CAO
            }


        // $list = $this-> tourModel->all();
        $list_tour_type = $this->tourtypeModel->all();
        $list_tour_supplier = $this-> toursupplierModel->all();

        // Lấy tất cả id_tour đã có booking
         $bookedTours = $this->booktourModel->getidbooking();
        
        include 'views/admin/tour_manager/tour_manager_content.php';
    }

    public function add_tour() {                                                      //Tạo tour mới
    $list_type_tour = $this->tourtypeModel->all();
    $list_toursupplier = $this->toursupplierModel->all();
    $success = "";

    if(isset($_POST['create'])){ 
        // 1. Tạo đối tượng Tour
        $tour = new Tour();
        $tour->name             = trim($_POST['name'] ?? '');
        $tour->price            = floatval($_POST['price'] ?? 0);
        $tour->number_of_days   = intval($_POST['number_of_days'] ?? 0);
        $tour->number_of_nights = intval($_POST['number_of_nights'] ?? 0);
        $tour->scope            = intval($_POST['scope'] ?? 0);
        $tour->describe         = trim($_POST['describe'] ?? '');
        $tour->status           = 1;
        $tour->type_tour        = $_POST['type_tour'];
        $tour->date             = date("Y-m-d");
        $tour->id_tourtype      = $_POST['id_tourtype'] ?? null;
        $tour->type_tour        = $_POST['type_tour'] ?? 1;
        $tour->minimum_scope    = $_POST['minimum_scope'];
        // $tour->location         = $_POST['type_tour'] ?? 1;

        // 2. Lưu tour vào DB
        $tour_id = $this->tourModel->insert($tour);

        if($tour_id > 0){
            // 3. Lưu ảnh tour
            if(!empty($_FILES['images']['name'])){
                foreach($_FILES['images']['name'] as $key => $name){
                    if($_FILES['images']['error'][$key] === 0){
                        $tmp_name = $_FILES['images']['tmp_name'][$key];
                        $unique_name = time() . "_" . $name;
                        $path = "uploads/tour/$unique_name";
                        move_uploaded_file($tmp_name, $path);
                        $this->imgtourModel->insert([
                            'tour_id'    => $tour_id,
                            'image_path' => $path
                        ]);
                    }
                }
            }

            // 4. Lưu địa điểm
            if(!empty($_POST['address'])){
                $addresses = array_unique(array_map('trim', $_POST['address']));
                foreach($addresses as $addr){
                    if($addr !== ""){
                        $this->addressModel->insert([
                            'id_tour' => $tour_id,
                            'name'    => $addr,
                            'status'  => 1
                        ]);
                    }
                }
            }

            // 5. Lưu chính sách
            $titles = $_POST['title'] ?? [];
            $contents = $_POST['content'] ?? [];

            for ($i = 0; $i < count($contents); $i++) {

                // Nếu cả tiêu đề và nội dung đều trống thì bỏ qua
                if (empty(trim($titles[$i])) && empty(trim($contents[$i]))) continue;

                $this->policyModel->insert([
                    'id_tour' => $tour_id,
                    'title'   => trim($titles[$i]),
                    'content' => trim($contents[$i])
                ]);
            }

            //lịch khởi hành từng ngày
            $contents = $_POST['detailed_content_every_day'];
            foreach ($contents as $content) {
                if (empty(trim($content))) continue;
                $detail = [
                    'id_tour' => $tour_id,
                    'content' => $content
                ];
                $this->scheduledetailsModel->addDailyPlan($detail);
            }


            // 6. Lưu dịch vụ
            if(!empty($_POST['name_supplier'])){
                $services = array_unique(array_map('trim', $_POST['name_supplier']));
                foreach($services as $service){
                    if($service !== ""){
                        $serviceName = trim($service);

                        // Tìm nhà cung cấp tương ứng
                        $supplierObj = $this->supplierModel->getByServiceName($serviceName);
                        $idSupplier = $supplierObj ? $supplierObj->id : null;

                        if ($idSupplier) {
                            $this->toursupplierModel->insert([
                                'id_tour'      => $tour_id,
                                'type_service' => $serviceName,
                                'id_supplier'  => $idSupplier
                            ]);
                        } else {
                            // Nếu không tìm thấy supplier, log hoặc thông báo
                            // echo "Không tìm thấy nhà cung cấp cho dịch vụ: $serviceName";
                        }
                    }
                }
            }

            // 7. Thông báo thành công
            echo "<script>alert('Tạo tour thành công!'); window.location.href='?action=tour_manager_content';</script>";
            exit();
        } else {
            $success = "Tạo tour thất bại!";
        }
    }

    // Load view thêm tour
    include 'views/admin/tour_manager/add_tour.php';
}


function delete_tour($id){  
    $bookedTours = $this->booktourModel->getidbooking();                  // lấy toàn bộ id của bảng book tour để so sánh
    $notification="";     //thông báo lỗi
    $error = "";
    $success = "";
    // 1. Lấy đối tượng tour
    $tourObject = $this->tourModel->find_tour($id);
    if (!$tourObject) {
        $error = "Tour không thể xóa ";
        $list = $this->tourModel->all();
        include __DIR__ . '/../views/admin/tour_manager/tour_manager_content.php';
        return;
    }

    $tour_id = $tourObject->id;

    // 3. Xóa địa chỉ liên quan
    if(method_exists($this->addressModel,'delete_address')){
        $res = $this->addressModel->delete_address($tour_id);
        if(!$res) $error .= " Xóa địa chỉ thất bại.";
    }

    // 4. Xóa ảnh tour (file + DB)
    if(method_exists($this->imgtourModel,'get_img_tour') && method_exists($this->imgtourModel,'delete_img_tour')){
        $images = $this->imgtourModel->get_img_tour($tour_id); 
        if(!empty($images)){
            foreach($images as $img){
                $file_path = __DIR__ . '/../uploads/images/' . $img;
                if(file_exists($file_path) && !unlink($file_path)){
                    $error .= " Xóa file ảnh $img thất bại.";
                }
            }
        }
        if(!$this->imgtourModel->delete_img_tour($tour_id)) $error .= " Xóa bản ghi ảnh thất bại.";
    }

    // 5. Xóa chính sách liên quan
    if(method_exists($this->policyModel,'get_policy') && method_exists($this->policyModel,'delete_policy')){
        $policies = $this->policyModel->get_policy($tour_id);
        if(!empty($policies)){
            foreach($policies as $policy){
                if(!empty($policy['img'])){
                    $file_path = __DIR__ . '/../uploads/policy/' . $policy['img'];
                    if(file_exists($file_path) && !unlink($file_path)){
                        $error .= " Xóa file policy $policy[img] thất bại.";
                    }
                }
            }
        }
        if(!$this->policyModel->delete_policy($tour_id)) $error .= " Xóa bản ghi policy thất bại.";
    }

    // 6. Xóa nhà cung cấp liên quan
    if(method_exists($this->toursupplierModel,'delete_tour_supplier')){
        if(!$this->toursupplierModel->delete_tour_supplier($tour_id)) $error .= " Xóa nhà cung cấp thất bại.";
    }

    // 7. Xóa lịch trình từng ngày
    if (method_exists($this->scheduledetailsModel, 'delete_daily')) {
        $this->scheduledetailsModel->delete_daily($tour_id);
    }

    // 8. Xóa tất cả policy thuộc tour
    if (method_exists($this->policyModel, 'delete_policy')) {
        $this->policyModel->delete_policy($tour_id);
    }
    $success = "Xóa tour thành công!";

    // 8. Xóa tour với try-catch
    try {
        if(method_exists($this->tourModel,'delete_tour')){
            $this->tourModel->delete_tour($tour_id);
            $success = "Xóa tour thành công!";
        }
    } catch (PDOException $e) {
        $error .= " Xóa tour thất bại đang có booking tour ";
    }

    // 9. Load lại danh sách tour
    $list = $this->tourModel->all();
    include __DIR__ . '/../views/admin/tour_manager/tour_manager_content.php';
}

public function tour_detail($id)
{
    // Lấy dữ liệu hiện tại
    $tour_detail        = $this->tourModel->find_tour($id);
    $list_tour_type     = $this->tourtypeModel->all();
    $addresses          = $this->addressModel->find_address($id);
    $policies           = $this->policyModel->find_policy($id);
    $tour_supplier      = $this->toursupplierModel->find_tour_supplier($id);
    $list_tour_supplier = $this->toursupplierModel->all();
    $images = $tour_detail->images;
    // Lấy lịch trình tour
    $schedules = $this->scheduledetailsModel->find_by_tour($id);

    if (isset($_POST['update'])) {
        // Cập nhật tour
        $tour_detail->name             = trim($_POST['name']);
        $tour_detail->price            = floatval($_POST['price']);
        $tour_detail->number_of_days   = intval($_POST['number_of_days']);
        $tour_detail->number_of_nights = intval($_POST['number_of_nights']);
        $tour_detail->scope            = intval($_POST['scope']);
        $tour_detail->describe         = trim($_POST['describe']);
        $tour_detail->date             = $_POST['date'];
        $tour_detail->id_tourtype      = $_POST['id_tourtype'];
        $tour_detail->status           = $_POST['status'];
        $tour_detail->minimum_scope    = $_POST['minimum_scope'];
        $this->tourModel->update_tour($tour_detail);

        // Xử lý ảnh tour mới (xóa cũ nếu có upload)
        if (!empty($_POST['old_images'])) {
            $oldImages = $_POST['old_images']; // Danh sách ảnh còn tồn tại trên form
            $dbImages  = $tour_detail->images; // Danh sách ảnh hiện có trong DB

            // === 1. XÓA NHỮNG ẢNH KHÔNG CÒN TRONG old_images (user bấm Xóa ảnh) ===
            foreach ($dbImages as $imgPath) {
                if (!in_array($imgPath, $oldImages)) {
                    // Xóa file
                    $file = __DIR__ . '/../' . $imgPath;
                    if (file_exists($file)) unlink($file);
                    // Xóa record trong DB
                    $this->imgtourModel->delete_image_path($imgPath);
                }
            }

            // === 2. XỬ LÝ ẢNH ĐƯỢC THAY THẾ ===
            foreach ($oldImages as $index => $oldImgPath) {

                // Nếu có file upload mới tại vị trí này
                if (!empty($_FILES['new_images']['name'][$index])) {

                    // Xóa file cũ
                    $file = __DIR__ . '/../' . $oldImgPath;
                    if (file_exists($file)) unlink($file);

                    // Upload file mới
                    $tmp  = $_FILES['new_images']['tmp_name'][$index];
                    $name = $_FILES['new_images']['name'][$index];
                    $unique = time() . "_" . $name;

                    $newPath = "uploads/tour/" . $unique;
                    move_uploaded_file($tmp, $newPath);

                    // Update DB
                    $this->imgtourModel->update_image_path($oldImgPath, $newPath);
                }
            }
        }

        // === 3. XỬ LÝ ẢNH MỚI THÊM ===
        if (!empty($_FILES['new_images']['name'])) {

            foreach ($_FILES['new_images']['name'] as $index => $name) {
                // Chỉ xử lý ảnh mới thêm (không có old_images tương ứng)
                if (!isset($_POST['old_images'][$index]) && $_FILES['new_images']['error'][$index] === 0) {
                    $tmp = $_FILES['new_images']['tmp_name'][$index];
                    $unique = time() . "_" . $name;
                    $path = "uploads/tour/" . $unique;
                    move_uploaded_file($tmp, $path);
                    $this->imgtourModel->insert([
                        'tour_id' => $id,
                        'image_path' => $path
                    ]);
                }
            }
        }


        // Cập nhật địa điểm
        if (isset($_POST['address'])) {
            
            // 1. Lọc ra các địa điểm hợp lệ (không rỗng hoặc chỉ chứa khoảng trắng)
            $validAddresses = array_filter($_POST['address'], function($addr) {
                return trim($addr) !== "";
            });

            // 2. Nếu có bất kỳ địa điểm hợp lệ nào hoặc người dùng xóa hết (mảng tồn tại nhưng rỗng)
            // Thực hiện xóa toàn bộ danh sách cũ trong DB.
            $this->addressModel->delete_address($id);
            
            // 3. Thêm mới các địa điểm hợp lệ
            if (!empty($validAddresses)) {
                foreach ($validAddresses as $addr) {
                    $this->addressModel->insert([
                        'id_tour' => $id,
                        'name'    => trim($addr), // Lưu giá trị đã được làm sạch khoảng trắng
                        'status'  => 1
                    ]);
                }
            }
        }

        // Cập nhật dịch vụ tour
        $currentServices = array_map(fn($s) => $s['id'], $tour_supplier);
        $newServices     = array_map('intval', $_POST['type_service'] ?? []);
        $toDelete = array_diff($currentServices, $newServices);
        foreach ($toDelete as $delID) $this->toursupplierModel->delete_by_service_id($id, $delID);
        $toAdd = array_diff($newServices, $currentServices);
        foreach ($toAdd as $srvID) {
            $srvObj = $this->toursupplierModel->getById($srvID);
            if ($srvObj) {
                $this->toursupplierModel->insert([
                    'id_tour'      => $id,
                    'type_service' => $srvObj->type_service,
                    'id_supplier'  => $srvObj->id_supplier ?? null
                ]);
            }
        }

        
        // Xóa tất cả chính sách cũ trước khi thêm mới
        $this->policyModel->delete_policy($id);

        // Thêm mới chính sách
        if (!empty($_POST['title'])) {
            foreach ($_POST['title'] as $key => $title) {
                $title = trim($title);
                $content = trim($_POST['content'][$key] ?? '');
                if ($title !== '' && $content !== '') {
                    $this->policyModel->insert([
                        'id_tour' => $id,
                        'title'   => $title,
                        'content' => $content
                    ]);
                }
            }
        }

        // lịch trình
        $old_schodeledet_tails = $this->scheduledetailsModel->find_by_tour($id);  //lấy lịch trình cũ trong database
        if (!$old_schodeledet_tails) {                            // Nếu chưa có dữ liệu, trả về mảng rỗng
            $old_schodeledet_tails = [];
        }
        $oldIds = array_column($old_schodeledet_tails, 'id');  // lấy id của lịch trình cũ
        $newIds = $_POST['schedule_id'] ?? [];                 // chỉ những ID còn tồn tại trong form
        $deletedIds = array_diff($oldIds, $newIds);            //tìm những id đã bị xóa
        foreach ($deletedIds as $delId) {                       // xóa theo id đã không còn tồn tại ở form
            $this->scheduledetailsModel->delete_old_daily($delId);
        }

        // 2. Xử lý update/insert
        foreach ($_POST['schedule_content'] as $key => $content) {
            $id_s = $_POST['schedule_id'][$key] ?? null;
            $content = trim($content);
            if ($content === '') continue;

            if ($id_s) {
                $this->scheduledetailsModel->update($id_s, ['content' => $content]);
            } else {
                $this->scheduledetailsModel->insert([
                    'id_tour' => $id,
                    'content' => $content
                ]);
            }
        }



        echo "<script>alert('Cập nhật tour thành công!'); window.location.href='?action=tour_manager_content';</script>";
        exit();
    }

    include 'views/admin/tour_manager/tour_detail.php';
}



function search_tour(){
        // Xử lý tìm kiếm
        $bookedTours = $this->booktourModel->getidbooking(); // biến lấy toàn bộ danh id trong bảng book tour để sa sánh
        $result=[];
        $notification="";
        $list = $this->tourModel->all();
        if(isset($_GET['search_tour'])){
            $key_word = trim($_GET['key_word']);
            if($key_word === ""){
                $notification = "Bạn chưa nhập dữ liệu";
            } else {
                $result = [];
                foreach($list as $tt){
                    if(stripos($tt->name, $key_word) !== false){
                        $result[] = $tt;
                    }
                }

                if(empty($result)){
                    $notification = "Không tìm thấy kết quả";
                } else {
                    $list = $result; // gán kết quả tìm được
                }
            }
        }
        include 'views/admin/tour_manager/tour_manager_content.php';
    }

}