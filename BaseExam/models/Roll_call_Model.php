<?php
 class Roll_call{
    public $id;
    public $id_departure_schedule;
    public $date;
    public $note;
 }


class Roll_call_Model extends BaseModel {
     public function getBySchedule($id_departure_schedule) {
        $sql = "SELECT * FROM roll_call WHERE id_departure_schedule = ? ORDER BY date DESC";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([$id_departure_schedule]);
        return $stm->fetchAll();
    }

    public function insertRollCall($id_departure_schedule, $note = "") {
        $sql = "INSERT INTO roll_call (id_departure_schedule, date, note) VALUES (?, NOW(), ?)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([$id_departure_schedule, $note]);
        return $this->pdo->lastInsertId();
    }
        public function getById($id_roll_call) {
        $sql = "SELECT * FROM roll_call WHERE id = ?";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([$id_roll_call]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }
}

?>