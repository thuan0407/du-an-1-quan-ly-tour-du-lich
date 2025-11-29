<?php
class Departure_schedule{
    public $id;
    public $start_date;
    public $end_date;
    public $status;
    public $id_tour_guide;
    public $note;
    public $incidental_costs;
    public $start_location;
    public $end_location;
}

class departure_schedule_Model extends BaseModel{
    public function create($departure_schedule){
        try {
            $sql = "INSERT INTO `departure_schedule` (`id`, `start_date`, `end_date`, `status`, `id_tour_guide`, `note`, `incidental_costs`, `start_location`, `end_location`) 
            VALUES (NULL, 
            '".$departure_schedule->start_date."', 
            '".$departure_schedule->end_date."', 
            '".$departure_schedule->status."', 
            '".$departure_schedule->id_tour_guide."', 
            '".$departure_schedule->note."', NULL, 
            '".$departure_schedule->start_location."', 
            '".$departure_schedule->end_location."');";
             $data=$this->pdo->exec($sql);
            return $this->pdo->lastInsertId();

        } catch (PDOException $e){
            echo "Lỗi insert img: " . $e->getMessage();
            return false;
        }
    }

    public function get_departure_schedule($id){
        $sql ="SELECT * FROM departure_schedule WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return $departure_schedule =$stmt->fetch(PDO::FETCH_OBJ);
    }

 //code thằng e Hùng (lấy all lịch làm việc, all lịch lm vc của hdv, lịch theo ngày(chưa dùng), chi tiết lịch)
    // Lấy tất cả lịch làm việc
   public function allWithTour() {
        try {
            $sql = "SELECT s.id, s.start_date, s.end_date, s.note, s.incidental_costs, t.name AS tour_name
                    FROM departure_schedule s
                    LEFT JOIN book_tour b ON s.id = b.departure_id
                    LEFT JOIN tour t ON b.id_tour = t.id";  // <-- sửa b.tour_id thành b.id_tour
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $err) {
            echo "Lỗi truy vấn lịch làm việc: " . $err->getMessage();
            return [];
        }
    }

    // Lấy lịch làm việc theo hướng dẫn viên
    public function getByGuide($guide_id) {
        try {
            $sql = "SELECT 
                        s.id, s.start_date, s.end_date, s.status, s.note, s.incidental_costs,
                        t.name AS tour_name
                    FROM departure_schedule s
                    LEFT JOIN book_tour b ON s.id = b.id_departure_schedule
                    LEFT JOIN tour t ON b.id_tour = t.id
                    WHERE s.id_tour_guide = ?
                    AND b.status = 2";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$guide_id]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $err) {
            echo "Lỗi truy vấn lịch làm việc theo hướng dẫn viên: " . $err->getMessage();
            return [];
        }
    }


    // Lấy lịch theo ngày cụ thể (chưa dùng)
    public function getByDate($guide_id, $date) {
        try {
            $sql = "SELECT s.id, s.start_date, s.end_date, s.note, s.incidental_costs, t.name AS tour_name
                    FROM departure_schedule s
                    LEFT JOIN book_tour b ON s.id = b.departure_id
                    LEFT JOIN tour t ON b.id_tour = t.id  -- <-- sửa ở đây
                    WHERE s.id_tour_guide = ? 
                      AND s.start_date <= ? 
                      AND s.end_date >= ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$guide_id, $date, $date]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $err) {
            echo "Lỗi truy vấn lịch theo ngày: " . $err->getMessage();
            return [];
        }
    }
    public function findDetail($id) {
        try {
            $sql = "SELECT 
                        s.*, 
                        t.name AS tour_name,
                        t.describe AS tour_description,
                        t.price AS tour_price,
                        b.number_of_days AS days,
                        b.number_of_nights AS nights,
                        b.customername AS CusName,
                        b.phone AS CusPhone,
                        b.id AS book_id
                    FROM departure_schedule s
                    LEFT JOIN book_tour b ON s.id = b.id_departure_schedule
                    LEFT JOIN tour t ON b.id_tour = t.id
                    WHERE s.id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $detail = $stmt->fetch(PDO::FETCH_OBJ);

            // Lấy danh sách khách hàng nếu có
            if ($detail && isset($detail->book_id)) {
                $sql_cust = "SELECT * FROM customer_list WHERE id_book_tour = ?";
                $stmt_cust = $this->pdo->prepare($sql_cust);
                $stmt_cust->execute([$detail->book_id]);
                $detail->customers = $stmt_cust->fetchAll(PDO::FETCH_OBJ);
            }

            return $detail;
        } catch (PDOException $err) {
            echo "Lỗi lấy chi tiết lịch: " . $err->getMessage();
            return null;
        }
        }
        public function updateStatus($id, $status) {
        try {
            $sql = "UPDATE departure_schedule SET status = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$status, $id]);
        } catch (PDOException $err) {
            echo "Lỗi cập nhật trạng thái: " . $err->getMessage();
        }
    }


public function update_status_departurescheduleModel($id, $status){
    try {
        $sql = "UPDATE departure_schedule SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':status' => $status,
            ':id'     => $id
        ]);
        return true;
    } catch (PDOException $err) {
        echo "Lỗi cập nhật trạng thái: " . $err->getMessage();
        return false;
    }
}




}
?>