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
    public $amount_money;
    public $tour_scope;
    public $tour_minimum_scope;
    public $pay_amount;
    public $pay_date;

}

class Book_tour_Model extends BaseModel{
    public function get_book_tour_all($status) {
        try {
            $sql = "
                SELECT 
                    bk.*, 
                    t.name AS tour_name,
                    GROUP_CONCAT(DISTINCT i.img SEPARATOR '|') AS images,
                    MAX(p.status) AS pay_status,
                    SUM(p.amount_money) AS amount_money
                FROM book_tour bk
                JOIN tour t ON bk.id_tour = t.id
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
                $book_tour->amount_money          = $tt['amount_money'] ?? 0;
                $book_tour->images                = !empty($tt['images']) ? explode('|', $tt['images']) : [];

                $list[] = $book_tour;
            }

            return $list;

        } catch(PDOException $err) {
            echo "Lỗi truy vấn book_tour: " . $err->getMessage();
            return [];
        }
    }

    // lấy bản ghi mới nhất của pay để hiển thị thông báo đã trả hết tiền hay chưa 
    // lấy thông tin tour có id 1,2,5
    public function get_book_tour_all_125() { 
        try {
            $sql = "
                SELECT 
                    bk.*,
                    t.name AS tour_name,
                    t.scope AS tour_scope,
                    t.minimum_scope AS tour_minimum_scope,

                    -- Lấy ảnh qua subquery để không cần GROUP BY
                    (SELECT GROUP_CONCAT(img SEPARATOR '|') 
                    FROM img_tour 
                    WHERE id_tour = t.id) AS images,

                    -- Lấy bản ghi thanh toán mới nhất
                    p.status AS pay_status,
                    p.amount_money AS pay_amount,
                    p.date AS pay_date

                FROM book_tour bk
                JOIN tour t ON bk.id_tour = t.id

                -- Lấy đúng bản ghi mới nhất bằng ORDER + LIMIT 1
                LEFT JOIN pay p 
                    ON p.id = (
                        SELECT p2.id 
                        FROM pay p2 
                        WHERE p2.id_book_tour = bk.id
                        ORDER BY p2.id DESC
                        LIMIT 1
                    )

                WHERE bk.status IN (1, 2, 5)

                ORDER BY bk.id DESC
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
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
                $book_tour->tour_scope            = $tt['tour_scope'];
                $book_tour->tour_minimum_scope    = $tt['tour_minimum_scope'];

                // thanh toán gần nhất
                $book_tour->pay_status            = $tt['pay_status'];
                $book_tour->pay_amount            = $tt['pay_amount'];
                $book_tour->pay_date              = $tt['pay_date'];

                $book_tour->images = !empty($tt['images']) ? explode('|', $tt['images']) : [];

                $list[] = $book_tour;
            }

            return $list;

        } catch (PDOException $err) {
            echo "Lỗi truy vấn book_tour_all_125: " . $err->getMessage();
            return [];
        }
    }

    public function get_book_tour($id){              
    try {
        $sql = "
            SELECT 
                bk.*,
                t.scope AS tour_scope,
                t.minimum_scope AS tour_minimum_scope,
                t.name AS tour_name,
                GROUP_CONCAT(i.img SEPARATOR '|') AS images
            FROM book_tour AS bk
            JOIN tour AS t ON bk.id_tour = t.id
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
            $book_tour->tour_scope            = $data['tour_scope'];
            $book_tour->tour_minimum_scope    = $data['tour_minimum_scope'];
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
        $sql = "INSERT INTO book_tour (
            date, total_amount, note, status, quantity, id_departure_schedule, 
            id_tour_guide, id_tour, number_of_days, number_of_nights, phone, customername
        ) VALUES (
            :date, :total_amount, :note, :status, :quantity, :id_departure_schedule,
            :id_tour_guide, :id_tour, :number_of_days, :number_of_nights, :phone, :customername
        )";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':date'                 => $book_tour->date,
            ':total_amount'         => $book_tour->total_amount,
            ':note'                 => $book_tour->note,
            ':status'               => $book_tour->status,
            ':quantity'             => $book_tour->quantity,
            ':id_departure_schedule'=> $book_tour->id_departure_schedule,
            ':id_tour_guide'        => empty($book_tour->id_tour_guide) ? null : $book_tour->id_tour_guide,
            ':id_tour'              => $book_tour->id_tour,
            ':number_of_days'       => $book_tour->number_of_days,
            ':number_of_nights'     => $book_tour->number_of_nights,
            ':phone'                => $book_tour->phone,
            ':customername'         => $book_tour->customername
        ]);

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

    public function update_tour_guide($id_tour_guide,$id){
        $sql = "UPDATE book_tour SET id_tour_guide = :id_tour_guide  WHERE id = :id";
        $stmt= $this->pdo->prepare($sql);
        $stmt->execute([
            ':id'           =>$id,
            ':id_tour_guide'=>$id_tour_guide
        ]);
    }

    public function update_price_total($book_tour){
        $sql = "UPDATE book_tour SET quantity = :quantity, total_amount = :total_amount WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':quantity' => $book_tour->quantity,
            ':total_amount' => $book_tour->total_amount,
            ':id' => $book_tour->id
        ]);
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
            AND b.status = 1
            ORDER BY b.id DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$guide_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookTourDetail($id)
        {
            $sql = "SELECT 
                        b.*, 
                        t.name AS tour_name,
                        t.describe AS tour_description,
                        b.number_of_days AS tour_days,
                        b.number_of_nights AS tour_nights
                    FROM book_tour AS b
                    JOIN tour AS t ON t.id = b.id_tour
                    WHERE b.id = ?";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

    public function updateBookTourStatus($id, $status)
        {
            $sql = "UPDATE book_tour SET status = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$status, $id]);
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


    
    //code cùng hùng
    public function updateStatus($id){
        $sql = "UPDATE book_tour SET status = 3 WHERE id = ? AND status = 2";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}


