<?php
 class Special_request{
    public $id;
    public $date;
    public $content;
    public $status;
    public $id_book_tour;
    public $id_tour_guide ;
 }


class Special_request_Model extends BaseModel{
    public function create($special_request){
        try {
            $sql = "INSERT INTO `special_request` (`id`, `date`, `content`, `status`, `id_book_tour`) 
            VALUES (NULL, 
            '".$special_request->date."', 
            '".$special_request->content."', 
            '".$special_request->status."', 
            '".$special_request->id_book_tour."');";

            $data = $this->pdo->exec($sql);
            return $this->pdo->lastInsertId();

        } catch (PDOException $e){
            echo "Lỗi insert book_tour: " . $e->getMessage();
            return false;
        }
    }


    protected $table = "special_request";

    // Lấy tất cả yêu cầu đặc biệt của 1 tour guide trong 1 tour cụ thể
public function getAllRequests($id_tour_guide, $id_book_tour) {
    $sql = "SELECT * FROM special_request 
            WHERE id_tour_guide = :id_tour_guide
              AND id_book_tour = :id_book_tour
            ORDER BY date DESC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        'id_tour_guide' => $id_tour_guide,
        'id_book_tour' => $id_book_tour
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Thêm yêu cầu đặc biệt
    public function addSpecialRequest($data) {
        $sql = "INSERT INTO special_request (date, content, status, id_book_tour, id_tour_guide)
                VALUES (:date, :content, :status, :id_book_tour, :id_tour_guide)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'date' => $data['date'],
            'content' => $data['content'],
            'status' => $data['status'],
            'id_book_tour' => $data['id_book_tour'],
            'id_tour_guide' => $data['id_tour_guide']
        ]);
    }

    // Cập nhật yêu cầu đặc biệt
    public function updateSpecialRequest($id, $id_tour_guide, $id_book_tour, $data) {
        $sql = "UPDATE special_request 
                SET date = :date, content = :content, status = :status
                WHERE id = :id AND id_tour_guide = :id_tour_guide AND id_book_tour = :id_book_tour";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'date' => $data['date'],
            'content' => $data['content'],
            'status' => $data['status'],
            'id' => $id,
            'id_tour_guide' => $id_tour_guide,
            'id_book_tour' => $id_book_tour
        ]);
    }



    // Lấy 1 yêu cầu đặc biệt theo id, tour guide và book tour
    public function getSpecialRequestById($id, $id_tour_guide, $id_book_tour) {
        $sql = "SELECT * FROM special_request 
                WHERE id = :id AND id_tour_guide = :id_tour_guide AND id_book_tour = :id_book_tour";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'id_tour_guide' => $id_tour_guide,
            'id_book_tour' => $id_book_tour
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // chỉnh sửa trạng thái special_request
    public function updateStatus($id, $id_tour_guide, $status) {
        $sql = "UPDATE special_request
                SET status = :status
                WHERE id = :id AND id_tour_guide = :id_tour_guide";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'status' => $status,
            'id' => $id,
            'id_tour_guide' => $id_tour_guide
        ]);
    }

    //lấy danh sách yêu cầu đặc biệt theo id của book tour
    public function get_special_request_list($id_book_tour){
        try{
            $sql ="SELECT * FROM special_request WHERE id_book_tour =:id_book_tour";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id_book_tour'=>$id_book_tour]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $list =[];
            foreach($data as $tt){
                $special_request = new Special_request();
                $special_request->id             =$tt['id'];
                $special_request->content        =$tt['content'];
                $special_request->status         =$tt['status'];
                $special_request->id_book_tour   =$tt['id_book_tour'];
                $special_request->id_tour_guide  =$tt['id_tour_guide'];
                $special_request->date           =$tt['date'];
                $list[]=$special_request;
            }
            return $list;
        }catch(PDOException $err){
            echo "Câu truy vấn lỗi :".$err->getMessage();
            return null;
        } 
    }

        public function delete_special_request($id_book_tour){
            try{
                $sql  ="DELETE FROM special_request WHERE id_book_tour = :id_book_tour";
                $stmt =$this->pdo->prepare($sql);
                $stmt->execute([':id_book_tour'=>$id_book_tour]);
                return $stmt->rowCount();
            }catch(PDOException $err){
            echo "Lỗi xóa hợp đồng: "  .$err->getMessage();
            return false;
           }
        }

}
?>