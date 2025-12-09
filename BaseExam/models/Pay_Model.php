<?php
 class Pay{
    public $id;
    public $date;
    public $payment_method;
    public $status;
    public $amount_money;
    public $note;
    public $id_book_tour ;
    public $total_money ;
 }


class Pay_Model extends BaseModel{
    public function get_total_amount(){  //lấy tổng toàn bộ bảng pay
        try{
            $sql = "SELECT SUM(amount_money) AS total_money FROM pay";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            $pay = new Pay();
            $pay->total_money = $data['total_money'] !== null ? $data['total_money'] : 0;

            return $pay;

        }catch(PDOException $err){
            echo "Lỗi get_total_amount: " . $err->getMessage();
            return null;
        }
    }

public function getRevenueByMonth($year = null) {                 // doanh thu theo tháng
    try {
        if (!$year) $year = date('Y');
        $sql = "
            SELECT MONTH(date) AS month, COALESCE(SUM(amount_money),0) AS total
            FROM pay
            WHERE YEAR(date) = :year
            GROUP BY MONTH(date)
            ORDER BY MONTH(date)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':year' => $year]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Khởi tạo 12 tháng = 0 nếu không có dữ liệu
        $labels = [];
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[$i] = 'Tháng ' . $i;
            $data[$i] = 0;
        }
        foreach ($result as $row) {
            $month = (int)$row['month'];
            $data[$month] = (float)$row['total'];
        }
        return [
            'labels' => array_values($labels),
            'data'   => array_values($data)
        ];
    } catch (PDOException $e) {
        echo "Lỗi getRevenueByMonth: " . $e->getMessage();
        return ['labels'=>[], 'data'=>[]];
    }
}

    public function create($pay){
        try {
            $sql = "INSERT INTO `pay` (`id`, `date`, `payment_method`, `status`, `amount_money`, `note`, `id_book_tour`) 
            VALUES (NULL, 
            '".$pay->date."', 
            '".$pay->payment_method."', 
            '".$pay->status."', 
            '".$pay->amount_money."', 
            '".$pay->note."', 
            '".$pay->id_book_tour."');";

            $data = $this->pdo->exec($sql);
            return $this->pdo->lastInsertId();

        } catch (PDOException $e){
            echo "Lỗi insert book_tour: " . $e->getMessage();
            return false;
        }
    }


        public function get_latest_pay($id_book_tour){   // lấy bản ghi mới nhất
        try {
            $sql = "SELECT * FROM pay 
                    WHERE id_book_tour = :id_book_tour
                    ORDER BY id DESC 
                    LIMIT 1"; // lấy bản ghi mới nhất theo id
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id_book_tour' => $id_book_tour]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if($data !== false){
                $pay = new Pay();
                $pay->id             = $data['id'];
                $pay->date           = $data['date'];
                $pay->payment_method = $data['payment_method'];
                $pay->status         = $data['status'];
                $pay->amount_money   = $data['amount_money'];
                $pay->note           = $data['note'];
                $pay->id_book_tour   = $data['id_book_tour'];
                return $pay;
            }
            return null;
        } catch(PDOException $err){
            echo "Lỗi get_latest_pay: " . $err->getMessage();
            return null;
        }
    }

    public function get_all_pay($id_book_tour){ // lấy toàn bộ thanh toán theo booking
        try {
            $sql = "SELECT * FROM pay 
                    WHERE id_book_tour = :id_book_tour
                    ORDER BY id DESC";  

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id_book_tour' => $id_book_tour]);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $pays = [];
            foreach ($result as $data) {
                $pay = new Pay();
                $pay->id             = $data['id'];
                $pay->date           = $data['date'];
                $pay->payment_method = $data['payment_method'];
                $pay->status         = $data['status'];
                $pay->amount_money   = $data['amount_money'];
                $pay->note           = $data['note'];
                $pay->id_book_tour   = $data['id_book_tour'];

                $pays[] = $pay;
            }

            return $pays;

        } catch (PDOException $err) {
            echo "Lỗi get_all_pay: " . $err->getMessage();
            return [];
        }
    }



    // public function amount_money_pay($id, $amount_money){        //cập nhật giá tiền đã thanh toán
    //     try{
    //         $sql ="UPDATE pay SET amount_money = :amount_money WHERE id = :id";
    //         $stmt = $this->pdo->prepare($sql);
    //         $stmt->execute([
    //             ':id'            => $id,
    //             ':amount_money'  => $amount_money
    //         ]);
    //         return $stmt->rowCount();
    //     }catch(PDOException $err){
    //         echo "Lỗi không thể update giá của bảng pay: " .$err->getMessage();
    //         return null;
    //     }
    // }


    ///====================code của tùng =================

    // Tổng tiền đã thu của 1 TOUR (dùng cho màn hình tổng kết)
    public function getPaidAmountForTour($tourId, $status = 3)
    {
        $sql = "SELECT COALESCE(SUM(p.amount_money), 0) AS total_paid
                FROM book_tour bt
                JOIN pay p ON p.id_book_tour = bt.id
                WHERE bt.id_tour = :tourId
                  AND bt.status  = :status";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':tourId' => $tourId,
            ':status' => $status,
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float)($row['total_paid'] ?? 0);
    }

    // Tổng tiền đã thu của 1 BOOKING (1 dòng trong book_tour)
    public function getPaidAmountByBooking($bookingId)
    {
        $sql = "SELECT COALESCE(SUM(amount_money), 0) AS total_paid
                FROM pay
                WHERE id_book_tour = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $bookingId]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float)($row['total_paid'] ?? 0);
    }

    // Tạo 1 bản ghi thanh toán tự động để bù nốt phần còn thiếu
    public function createAutoPayment($bookingId, $amount, $note = 'Đánh dấu đã thanh toán đủ')
    {
        $sql = "INSERT INTO pay (date, payment_method, status, amount_money, note, id_book_tour)
                VALUES (NOW(), :method, 1, :amount, :note, :bookingId)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':method'    => 'Điều chỉnh',
            ':amount'    => $amount,
            ':note'      => $note,
            ':bookingId' => $bookingId,
        ]);

        return $this->pdo->lastInsertId();
    }
}
?>