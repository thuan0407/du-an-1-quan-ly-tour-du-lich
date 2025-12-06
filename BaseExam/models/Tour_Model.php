<?php
class Tour {
    public $id;
    public $name;
    public $describe;
    public $number_of_days;
    public $price;
    public $date;
    public $id_tourtype;
    public $scope;
    public $number_of_nights;
    public $images;
    public $type_tour;
    public $status;
}

class Tour_Model extends BaseModel {

    protected $table = "tour";

    public function all() {
        try {
            $sql = "SELECT t.*, i.img AS image
                    FROM `tour` t
                    LEFT JOIN img_tour i ON t.id = i.id_tour
                    ORDER BY t.id, i.id";
            $data = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $tours = [];
            foreach($data as $row) {
                $id = $row['id'];
                if(!isset($tours[$id])) {
                    $tour = new Tour();
                    $tour->id               = $row['id'];
                    $tour->name             = $row['name'];
                    $tour->describe         = $row['describe']; // vẫn đọc từ db
                    $tour->number_of_days   = $row['number_of_days'];
                    $tour->price            = $row['price'];
                    $tour->date             = $row['date'];
                    $tour->id_tourtype      = $row['id_tourtype'] ?? null;
                    $tour->scope            = $row['scope'];
                    $tour->number_of_nights = $row['number_of_nights'];
                    $tour->status           = $row['status'];
                    $tour->images           = [];
                    $tour->type_tour        = $row['type_tour'];
                    $tours[$id] = $tour;
                }
                if(!empty($row['image'])) {
                    $tours[$id]->images[] = $row['image'];
                }
            }

            return array_values($tours);
        } catch(PDOException $err) {
            echo "Lỗi truy vấn tour: " . $err->getMessage();
            return [];
        }
    }
    
public function getToursByType($selectedType) {                           //lọc theo loại tour
        try {
            $sql = "SELECT t.*, i.img AS image
                    FROM `tour` t
                    LEFT JOIN img_tour i ON t.id = i.id_tour
                    WHERE `id_tourtype` = $selectedType
                    ORDER BY t.id, i.id";
            $data = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $tours = [];
            foreach($data as $row) {
                $id = $row['id'];
                if(!isset($tours[$id])) {
                    $tour = new Tour();
                    $tour->id               = $row['id'];
                    $tour->name             = $row['name'];
                    $tour->describe         = $row['describe']; // vẫn đọc từ db
                    $tour->number_of_days   = $row['number_of_days'];
                    $tour->price            = $row['price'];
                    $tour->date             = $row['date'];
                    $tour->id_tourtype      = $row['id_tourtype'] ?? null;
                    $tour->scope            = $row['scope'];
                    $tour->number_of_nights = $row['number_of_nights'];
                    $tour->status           = $row['status'];
                    $tour->images           = [];
                    $tour->type_tour        = $row['type_tour'];
                    $tours[$id] = $tour;
                }
                if(!empty($row['image'])) {
                    $tours[$id]->images[] = $row['image'];
                }
            }

            return array_values($tours);
        } catch(PDOException $err) {
            echo "Lỗi truy vấn tour: " . $err->getMessage();
            return [];
        }
    }

    public function getToursHigh() {                                                     // lấy theo giá từ cáo xuống
        try {
            $sql = "SELECT t.*, i.img AS image
                    FROM `tour` t
                    LEFT JOIN img_tour i ON t.id = i.id_tour
                    ORDER BY t.price DESC, i.id";
            $data = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $tours = [];
            foreach($data as $row) {
                $id = $row['id'];
                if(!isset($tours[$id])) {
                    $tour = new Tour();
                    $tour->id               = $row['id'];
                    $tour->name             = $row['name'];
                    $tour->describe         = $row['describe']; // vẫn đọc từ db
                    $tour->number_of_days   = $row['number_of_days'];
                    $tour->price            = $row['price'];
                    $tour->date             = $row['date'];
                    $tour->id_tourtype      = $row['id_tourtype'] ?? null;
                    $tour->scope            = $row['scope'];
                    $tour->number_of_nights = $row['number_of_nights'];
                    $tour->status           = $row['status'];
                    $tour->images           = [];
                    $tour->type_tour        = $row['type_tour'];
                    $tours[$id] = $tour;
                }
                if(!empty($row['image'])) {
                    $tours[$id]->images[] = $row['image'];
                }
            }

            return array_values($tours);
        } catch(PDOException $err) {
            echo "Lỗi truy vấn tour: " . $err->getMessage();
            return [];
        }
    }

public function getToursShort() {                                                     // lấy theo giá từ thấp lêm
        try {
            $sql = "SELECT t.*, i.img AS image
                    FROM `tour` t
                    LEFT JOIN img_tour i ON t.id = i.id_tour
                    ORDER BY t.price ASC, i.id";
            $data = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $tours = [];
            foreach($data as $row) {
                $id = $row['id'];
                if(!isset($tours[$id])) {
                    $tour = new Tour();
                    $tour->id               = $row['id'];
                    $tour->name             = $row['name'];
                    $tour->describe         = $row['describe']; // vẫn đọc từ db
                    $tour->number_of_days   = $row['number_of_days'];
                    $tour->price            = $row['price'];
                    $tour->date             = $row['date'];
                    $tour->id_tourtype      = $row['id_tourtype'] ?? null;
                    $tour->scope            = $row['scope'];
                    $tour->number_of_nights = $row['number_of_nights'];
                    $tour->status           = $row['status'];
                    $tour->images           = [];
                    $tour->type_tour        = $row['type_tour'];
                    $tours[$id] = $tour;
                }
                if(!empty($row['image'])) {
                    $tours[$id]->images[] = $row['image'];
                }
            }

            return array_values($tours);
        } catch(PDOException $err) {
            echo "Lỗi truy vấn tour: " . $err->getMessage();
            return [];
        }
    }

    public function insert(Tour $tour) {
        $sql = "INSERT INTO tour (name, price, number_of_days, number_of_nights, scope, `describe`, status, date, id_tourtype, type_tour)
                VALUES (:name, :price, :number_of_days, :number_of_nights, :scope, :describe, :status, :date, :id_tourtype, :type_tour)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $tour->name,
            ':price' => $tour->price,
            ':number_of_days' => $tour->number_of_days,
            ':number_of_nights' => $tour->number_of_nights,
            ':scope' => $tour->scope,
            ':describe' => $tour->describe,
            ':status' => $tour->status,
            ':date' => $tour->date,
            ':id_tourtype' => $tour->id_tourtype,
            ':type_tour' => $tour->type_tour
        ]);
        return $this->pdo->lastInsertId();
    }

   public function find_tour($id) {
    try {
        $sql = "SELECT t.*, i.img AS image
                FROM `tour` t
                LEFT JOIN img_tour i ON t.id = i.id_tour
                WHERE t.id = :id
                ORDER BY i.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!$data) return null;

        $tour = new Tour();
        $tour->images = [];

        foreach($data as $row) {
            $tour->id               = $row['id'];
            $tour->name             = $row['name'];
            $tour->describe         = $row['describe'];
            $tour->number_of_days   = $row['number_of_days'];
            $tour->price            = $row['price'];
            $tour->date             = $row['date'];
            $tour->id_tourtype      = $row['id_tourtype'];
            $tour->scope            = $row['scope'];
            $tour->number_of_nights = $row['number_of_nights'];
            $tour->type_tour        = $row['type_tour'];

            if(!empty($row['image'])) {
                $tour->images[] = $row['image'];
            }
        }
        return $tour;
    } catch (PDOException $err) {
        echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        return null;
    }
}


    public function delete_tour($tour_id) {
        $sql = "DELETE FROM tour WHERE id = :tour_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['tour_id' => $tour_id]);
        return $stmt;
    }

    // Cập nhật tour
    public function update_tour(Tour $tour){                  
                try{
                    $id=(int)$tour->id;
                    $sql="UPDATE `tour` SET 
                        `name` = '".$tour->name."', 
                        `describe` = '".$tour->describe."', 
                        `number_of_days` = '".$tour->number_of_days."', 
                        `price` = '".$tour->price."', 
                        `date` = '".$tour->date."', 
                        `id_tourtype` = '".$tour->id_tourtype."', 
                        `scope` = '".$tour->scope."', 
                        `number_of_nights` = '".$tour->number_of_nights."',
                        `status` = '".$tour->status."',
                        `type_tour` = '".$tour->type_tour."'
                        WHERE `tour`.`id` = $id;";
                    $data=$this->pdo->exec($sql);
                    return $data;

                }catch (PDOException $err) {
                echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
            }
            }


    public function tour_status($sql) {                                    //hiển thị theo trạng thái
        try {
            $data = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $tours = [];
            foreach($data as $row) {
                $id = $row['id'];
                if(!isset($tours[$id])) {
                    $tour = new Tour();
                    $tour->id               = $row['id'];
                    $tour->name             = $row['name'];
                    $tour->describe         = $row['describe']; // vẫn đọc từ db
                    $tour->number_of_days   = $row['number_of_days'];
                    $tour->price            = $row['price'];
                    $tour->date             = $row['date'];
                    $tour->id_tourtype      = $row['id_tourtype'] ?? null;
                    $tour->scope            = $row['scope'];
                    $tour->number_of_nights = $row['number_of_nights'];
                    $tour->status           = $row['status'];
                    $tour->images           = [];
                    $tour->type_tour        = $row['type_tour'];
                    $tours[$id] = $tour;
                }
                if(!empty($row['image'])) {
                    $tours[$id]->images[] = $row['image'];
                }
            }

            return array_values($tours);
        } catch(PDOException $err) {
            echo "Lỗi truy vấn tour: " . $err->getMessage();
            return [];  
        }
    }

//code của tùng

       public function get_tour_ended_detail($id)
        {
            // Tạm thời m chỉ cần chi tiết giống find_tour
            // Sau này muốn join thêm gì thì sửa trong hàm này, không ảnh hưởng ai
            return $this->find_tour($id);
        }

        
        // Hàm lấy danh sách tour theo trạng thái đơn hàng (JOIN giữa bảng book_tour và tour)
    public function get_tours_by_status($status) {
        try {
            // Câu lệnh SQL: Lấy thông tin từ bảng book_tour, nối sang bảng tour để lấy tên, giá, ảnh...
            $sql = "SELECT bt.*, t.name, t.price, t.number_of_days, t.number_of_nights, t.date as tour_date, i.img as image
                    FROM book_tour bt
                    JOIN tour t ON bt.id_tour = t.id
                    LEFT JOIN img_tour i ON t.id = i.id_tour
                    WHERE bt.status = :status
                    GROUP BY bt.id 
                    ORDER BY bt.date DESC"; // Sắp xếp ngày đặt mới nhất lên đầu

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['status' => $status]);
            
            // Trả về dạng Object để bên View dùng được cú pháp $tour->name
            return $stmt->fetchAll(PDO::FETCH_OBJ);

        } catch (PDOException $err) {
            // Nếu lỗi thì trả về mảng rỗng
            return [];
        }
    }

   
  
    
    // 
    // Hàm này CHỈ DÙNG cho trang Tour Đã Hủy
    public function get_canceled_tours_detail() {
        try {
            // Sửa lại SQL: Chỉ lấy 1 ảnh đại diện (ảnh có id nhỏ nhất hoặc lớn nhất) để tránh lỗi GROUP BY
            $sql = "SELECT bt.*, 
                           t.name as tour_name, 
                           u.name as user_name, 
                           u.phone_number,
                           (SELECT img FROM img_tour WHERE id_tour = t.id LIMIT 1) as image
                    FROM book_tour bt
                    JOIN tour t ON bt.id_tour = t.id
                    LEFT JOIN user u ON bt.id_user = u.id
   
                    WHERE bt.status = 4  -- Chỉ lấy trạng thái 4 (Đã hủy)
                    ORDER BY bt.date DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_OBJ);

        } catch (PDOException $err) {
            return [];
        }
    }
}
?>
