<?php
class Departure_schedule_details {
    public $id;
    public $date;                     // dùng date trong PHP
    public $content;
    public $id_departure_schedule;
}

class Departure_schedule_details_Model extends BaseModel {

    public function addDailyPlan($data) {

        $sql = "INSERT INTO departure_schedule_details
                (id_departure_schedule, date, content)
                VALUES (?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $data['id_departure_schedule'],
            $data['date'],   // map PHP $date → cột DB day
            $data['content']
        ]);
    }
}
?>
