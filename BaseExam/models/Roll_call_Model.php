<?php
 class Roll_call{
    public $id;
    public $id_departure_schedule;
    public $date;
    public $note;
 }


class Roll_call_Model extends BaseModel {
    // Lấy danh sách điểm danh theo lịch khởi hành
    public function getBySchedule($id_departure_schedule) {
        $sql = "SELECT * FROM roll_call WHERE id_departure_schedule = ?";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([$id_departure_schedule]);
        return $stm->fetchAll();
    }

    // Kiểm tra đã có điểm danh chưa
    public function findOne($id_departure_schedule) {
        $sql = "SELECT * FROM roll_call WHERE id_departure_schedule = ?";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([$id_departure_schedule]);
        return $stm->fetch();
    }

    // Thêm điểm danh mới
    public function insertRollCall($id_departure_schedule, $note = "") {
        $sql = "INSERT INTO roll_call (id_departure_schedule, date, note)
                VALUES (?, NOW(), ?)";
        $stm = $this->pdo->prepare($sql);
        return $stm->execute([$id_departure_schedule, $note]);
    }
}

?>