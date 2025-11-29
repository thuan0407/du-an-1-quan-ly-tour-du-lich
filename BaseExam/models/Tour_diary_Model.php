<?php
 class Tour_diary{
    public $id;
    public $date;
    public $content;
    public $img;
    public $service_provider_evaluation;
    public $note;
    public $id_tour_guide ;
    public $id_departure_schedule;
}


class Tour_diary_Model extends BaseModel{
// Tạo nhật ký mới
    public function create($id_tour_guide, $id_departure_schedule, $content, $img = null, $service_provider_evaluation = '', $note = '') {
        try {
            $sql = "INSERT INTO tour_diary
                    (date, content, img, service_provider_evaluation, note, id_tour_guide, id_departure_schedule)
                    VALUES (NOW(), ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$content, $img, $service_provider_evaluation, $note, $id_tour_guide, $id_departure_schedule]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $err) {
            echo "Lỗi tạo nhật ký: " . $err->getMessage();
            return false;
        }
    }

    // Lấy tất cả nhật ký theo lịch và HDV
    public function getBySchedule($id_tour_guide, $id_departure_schedule) {
        try {
            $sql = "SELECT * FROM tour_diary 
                    WHERE id_tour_guide = ? AND id_departure_schedule = ? 
                    ORDER BY date DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_tour_guide, $id_departure_schedule]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $err) {
            echo "Lỗi lấy nhật ký: " . $err->getMessage();
            return [];
        }
    }

    // Lấy nhật ký theo ID
    public function getById($id) {
        try {
            $sql = "SELECT * FROM tour_diary WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $err) {
            echo "Lỗi lấy nhật ký theo ID: " . $err->getMessage();
            return null;
        }
    }


    // Xoá nhật ký
    public function delete($id) {
        try {
            $sql = "DELETE FROM tour_diary WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $err) {
            echo "Lỗi xoá nhật ký: " . $err->getMessage();
            return false;
        }
    }



        // Cập nhật nhật ký (có thể dùng đến)
    // public function update($id, $content, $img = null, $service_provider_evaluation = '', $note = '') {
    //     try {
    //         if ($img) {
    //             $sql = "UPDATE tour_diary 
    //                     SET content = ?, img = ?, service_provider_evaluation = ?, note = ? 
    //                     WHERE id = ?";
    //             $params = [$content, $img, $service_provider_evaluation, $note, $id];
    //         } else {
    //             $sql = "UPDATE tour_diary 
    //                     SET content = ?, service_provider_evaluation = ?, note = ? 
    //                     WHERE id = ?";
    //             $params = [$content, $service_provider_evaluation, $note, $id];
    //         }
    //         $stmt = $this->pdo->prepare($sql);
    //         return $stmt->execute($params);
    //     } catch (PDOException $err) {
    //         echo "Lỗi cập nhật nhật ký: " . $err->getMessage();
    //         return false;
    //     }
    // }
}
?>