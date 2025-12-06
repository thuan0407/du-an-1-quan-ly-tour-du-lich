<?php
class Book_tour{
    public $id;
    public $date;
    public $total_amount;
    public $note;
    public $status;
    public $quantity;
    public $id_departure_schedule;
    public $id_tour_guide;
    public $id_tour;
    public $number_of_days;
    public $number_of_nights;
    public $phone;
    public $customername;
    public $tour_name;
    public $images;
    public $pay_status;
}

class Book_tour_Model extends BaseModel{
    public function get_book_tour_all($status){              
        try{
            $sql = "
                SELECT MAX(p.status) AS pay_status, bk.*, t.name as tour_name, GROUP_CONCAT(i.img SEPARATOR '|') as images
                FROM `book_tour` as bk
                JOIN tour as t ON bk.id_tour = t.id
                LEFT JOIN img_tour i ON t.id = i.id_tour
                LEFT JOIN pay p ON p.id_book_tour = bk.id
                WHERE bk.status = ?
                GROUP BY bk.id
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$status]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $list = [];
            foreach($data as $tt){
                $book_tour = new Book_tour();
                $book_tour->id                    = $tt['id'];
                $book_tour->date                  = $tt['date'];
                $book_tour->total_amount          = $tt['total_amount'];
                $book_tour->note                  = $tt['note'];
                $book_tour->status                = $tt['status'];
                $book_tour->quantity              = $tt['quantity'];
                $book_tour->id_departure_schedule = $tt['id_departure_schedule'];
                $book_tour->id_tour_guide         = $tt['id_tour_guide'];
                $book_tour->id_tour               = $tt['id_tour'];
                $book_tour->number_of_days        = $tt['number_of_days'];
                $book_tour->number_of_nights      = $tt['number_of_nights'];
                $book_tour->phone                 = $tt['phone'];
                $book_tour->customername          = $tt['customername'];
                $book_tour->tour_name             = $tt['tour_name'];
                $book_tour->pay_status            = $tt['pay_status'];
                $book_tour->images                = !empty($tt['images']) ? explode('|', $tt['images']) : [];

                $list[] = $book_tour;
            }

            return $list;

        } catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
            return [];
        }
    }


    public function get_book_tour($id){              
        try{
            $sql = "
                SELECT bk.*, t.name as tour_name, GROUP_CONCAT(i.img SEPARATOR '|') as images
                FROM `book_tour` as bk
                JOIN tour as t ON bk.id_tour = t.id
                LEFT JOIN img_tour i ON t.id = i.id_tour
                WHERE bk.id = ?
                GROUP BY bk.id
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if($data !== false){
                $book_tour = new Book_tour();
                $book_tour->id                    = $data['id'];
                $book_tour->date                  = $data['date'];
                $book_tour->total_amount          = $data['total_amount'];
                $book_tour->note                  = $data['note'];
                $book_tour->status                = $data['status'];
                $book_tour->quantity              = $data['quantity'];
                $book_tour->id_departure_schedule = $data['id_departure_schedule'];
                $book_tour->id_tour_guide         = $data['id_tour_guide'];
                $book_tour->id_tour               = $data['id_tour'];
                $book_tour->number_of_days        = $data['number_of_days'];
                $book_tour->number_of_nights      = $data['number_of_nights'];
                $book_tour->phone                 = $data['phone'];
                $book_tour->customername          = $data['customername'];
                $book_tour->tour_name             = $data['tour_name'];
                $book_tour->images                = !empty($data['images']) ? explode('|', $data['images']) : [];
                return $book_tour;
            }

        } catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
            return [];
        }
    }

        public function getidbooking() {                           //lấy id_tour ở bảng book_tour
            try {
                $sql = "SELECT DISTINCT id_tour FROM book_tour";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(); // ✅ phải có ()
                return $stmt->fetchAll(PDO::FETCH_COLUMN); // trả về mảng 1 chiều chứa id_tour
            } catch (PDOException $e) {
                echo "Lỗi truy vấn book_tour: " . $e->getMessage();
                return [];
            }
        }


        
  public function create($book_tour){
    try {
        $sql = "INSERT INTO `book_tour` 
            (`id`, `date`, `total_amount`, `note`, `status`, `quantity`, `id_departure_schedule`, `id_tour_guide`, `id_tour`, `number_of_days`, `number_of_nights`, `phone`, `customername`) 
            VALUES (
                NULL, 
                '".$book_tour->date."', 
                '".$book_tour->total_amount."', 
                '".$book_tour->note."', 
                '".$book_tour->status."', 
                '".$book_tour->quantity."', 
                '".$book_tour->id_departure_schedule."', 
                '".$book_tour->id_tour_guide."', 
                '".$book_tour->id_tour."', 
                '".$book_tour->number_of_days."', 
                '".$book_tour->number_of_nights."', 
                '".$book_tour->phone."', 
                '".$book_tour->customername."'
            );";

        $data = $this->pdo->exec($sql);
        return $this->pdo->lastInsertId();

    } catch (PDOException $e){
        echo "Lỗi insert book_tour: " . $e->getMessage();
        return false;
    }
}


public function update_book_tour($book_tour)
{
    try {
        $sql = "UPDATE book_tour SET
            date = :date,
            total_amount = :total_amount,
            note = :note,
            status = :status,
            quantity = :quantity,
            id_departure_schedule = :id_departure_schedule,
            id_tour_guide = :id_tour_guide,
            number_of_days = :number_of_days,
            number_of_nights = :number_of_nights,
            phone = :phone,
            customername = :customername
        WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':date'                   => $book_tour->date,
            ':total_amount'           => $book_tour->total_amount,
            ':note'                   => $book_tour->note !== '' ? $book_tour->note : null,
            ':status'                 => $book_tour->status,
            ':quantity'               => $book_tour->quantity,
            ':id_departure_schedule'  => $book_tour->id_departure_schedule,
            ':id_tour_guide'          => $book_tour->id_tour_guide,
            ':number_of_days'         => $book_tour->number_of_days,
            ':number_of_nights'       => $book_tour->number_of_nights,
            ':phone'                  => $book_tour->phone,
            ':customername'           => $book_tour->customername,
            ':id'                     => $book_tour->id
        ]);

        return true;

    } catch (PDOException $err) {
        echo "Lỗi update book_tour: " . $err->getMessage();
        return false;
    }
}

    public function delete_book_tour($id){
        $sql ="DELETE FROM book_tour WHERE id =:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return $stmt->rowCount();
    }

    public function update_book_tour_status($id, $status){
        try{
            $sql ="UPDATE book_tour SET status = :status WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id'      => $id,
                ':status'  => $status
            ]);
            return $stmt->rowCount();
        }catch(PDOException $err){
            echo "Lỗi không thể update giá của bảng pay: " .$err->getMessage();
            return null;
        }
    }


    public function getTotalToursStatus($status) {                   //lấy tổng số tour chờ duyệt
        try {
            $sql = "SELECT COUNT(*) AS total FROM book_tour WHERE status = :status";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':status'=>$status]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return $data['total'] !== null ? (int)$data['total'] : 0;

        } catch (PDOException $err) {
            echo "Lỗi getTotalToursStatus1: " . $err->getMessage();
            return 0;
        }
    }

/////============= code của hùng ======================


    /**
     * Lấy tất cả tour kèm ảnh (mỗi tour 1 dòng, ảnh nối bằng '|')
     */
   public function getAllTours() {
    try {
        $sql = "
            SELECT 
                t.id,
                t.name,
                t.describe,
                t.number_of_days,
                t.price,
                t.date,
                t.type_tour,
                t.id_tourtype,
                tt.tour_type_name AS tour_type_name,
                t.scope,
                t.number_of_nights,
                GROUP_CONCAT(DISTINCT i.img SEPARATOR '|') AS images,
                GROUP_CONCAT(DISTINCT a.name ORDER BY a.id ASC SEPARATOR ' -> ') AS route
            FROM tour t
            LEFT JOIN img_tour i ON i.id_tour = t.id
            LEFT JOIN address a ON a.id_tour = t.id
            LEFT JOIN tour_type tt ON tt.id = t.id_tourtype
            GROUP BY t.id
            ORDER BY t.id DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $err) {
        echo "Lỗi truy vấn tour: " . $err->getMessage();
        return [];
    }
}

    public function getTourDetail($id) {
        try {
            $sql = "
                SELECT 
                    t.*,
                    tt.tour_type_name AS tour_type_name,
                    t.scope AS qt,
                    GROUP_CONCAT(DISTINCT i.img SEPARATOR '|') AS images,
                    GROUP_CONCAT(DISTINCT a.name ORDER BY a.id ASC SEPARATOR ' -> ') AS route
                FROM tour t
                LEFT JOIN img_tour i ON i.id_tour = t.id
                LEFT JOIN address a ON a.id_tour = t.id
                LEFT JOIN tour_type tt ON tt.id = t.id_tourtype
                WHERE t.id = ?
                GROUP BY t.id
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            echo "Lỗi getTourDetail: " . $e->getMessage();
            return null;
        }
    }

    // Tạo booking
    public function createBooking($data) {
        try {
            $sql = "
                INSERT INTO book_tour 
                (customername, phone, date, total_amount, note, status,
                number_of_days, number_of_nights, quantity,
                id_departure_schedule, id_tour_guide, id_tour)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";

            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([
                $data['customername'],
                $data['phone'],
                $data['date'],
                $data['total_amount'],
                $data['note'],
                1,  // status mặc định = 1 khi đặt tour từ HDV
                $data['number_of_days'],
                $data['number_of_nights'],
                $data['quantity'],
                $data['id_departure_schedule'],
                $data['id_tour_guide'],
                $data['id_tour']
            ]);

        } catch(PDOException $e) {
            echo "Lỗi createBooking: " . $e->getMessage();
            return false;
        }
    }
    public function getPendingToursByGuide($guide_id)
    {
        $sql = "
            SELECT 
                b.*, 
                t.name AS tour_name,
                
                b.number_of_days AS days,
                b.number_of_nights AS nights
            FROM book_tour AS b
            JOIN tour AS t ON t.id = b.id_tour
            WHERE b.id_tour_guide = ?
            ORDER BY b.id DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$guide_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getBookingsByTourAndStatus($tourId, $status = 3)
    {
        try {
            $sql = "SELECT *
                    FROM book_tour
                    WHERE id_tour = :tourId
                      AND status  = :status";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':tourId' => $tourId,
                ':status' => $status
            ]);

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return [];
        }
    }
}


