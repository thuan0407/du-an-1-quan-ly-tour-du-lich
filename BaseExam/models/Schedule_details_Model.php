<?php
class Schedule_details{
    public $id;
    public $content;
    public $id_tour;
}

class Schedule_details_Model extends BaseModel{
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
}
?>