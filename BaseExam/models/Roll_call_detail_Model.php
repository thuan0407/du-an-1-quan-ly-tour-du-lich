<?php
class Roll_call_detail_Model extends BaseModel {

    // Lấy chi tiết điểm danh theo phiên
    public function getByRollCall($roll_call_id) {
        $sql = "SELECT rcd.*, cl.name, cl.phone, rcd.id_address, ad.name AS address_name
                FROM roll_call_detail rcd
                JOIN customer_list cl ON cl.id = rcd.id_customer_list
                JOIN address ad ON ad.id = rcd.id_address
                WHERE rcd.id_roll_call = ?";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([$roll_call_id]);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm chi tiết điểm danh cho từng khách và từng chặng
    public function insertDetail($id_roll_call, $id_customer_list, $id_address, $status) {
        $sql = "INSERT INTO roll_call_detail (id_roll_call, id_customer_list, id_address, status)
                VALUES (?, ?, ?, ?)";
        $stm = $this->pdo->prepare($sql);   
        return $stm->execute([$id_roll_call, $id_customer_list, $id_address, $status]); 
    }


    // Lấy danh sách khách của lịch khởi hành
    public function getByDepartureSchedule($id_departure_schedule) {
        $sql = "SELECT cl.*, bt.id_tour 
                FROM customer_list cl
                JOIN book_tour bt ON bt.id = cl.id_book_tour
                WHERE bt.id_departure_schedule = :id_departure_schedule";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_departure_schedule' => $id_departure_schedule]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách chặng theo id_tour
    public function getAddressesByTour($id_tour) {
        $sql = "SELECT * FROM address WHERE id_tour = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_tour]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}


?>