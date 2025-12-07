<?php
class Schedule_details{
    public $id;
    public $content;
    public $id_tour;
}

class Schedule_details_Model extends BaseModel{
      protected $table = 'schedule_details'; // thêm dòng này
    public function addDailyPlan($data) {

        $sql = "INSERT INTO schedule_details
                (id_tour, content)
                VALUES ( ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $data['id_tour'],
            $data['content']
        ]);
    }

    // HÀM XÓA LỊCH TRÌNH THEO TOUR ID
    public function delete_daily($tour_id) {
        $sql = "DELETE FROM schedule_details WHERE id_tour = :tour_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['tour_id' => $tour_id]);
    }

    //xóa lịch trình theo id
    public function delete_old_daily($id) {
    $sql = "DELETE FROM schedule_details WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
}

    //  lấy lịch triinfh theo id tour
    public function find_by_tour($tour_id) {  
        $sql = "SELECT * FROM schedule_details WHERE id_tour = :tour_id ORDER BY id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['tour_id' => $tour_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm mới 1 lịch trình
    public function insert($data) {
            $sql = "INSERT INTO {$this->table} (id_tour, content) VALUES (:id_tour, :content)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'id_tour' => $data['id_tour'],
                'content' => $data['content']
            ]);
        }


    // Cập nhật nội dung dòng theo ID
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET content = :content WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'content' => $data['content'],
            'id'      => $id
        ]);
    }
}
?>