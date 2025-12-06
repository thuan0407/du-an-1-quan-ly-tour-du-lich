<?php
 class Tour_supplier{
    public $id;
    public $type_service;
    public $id_supplier ;
    public $id_tour;
 }


class Tour_supplier_Model extends BaseModel{
   protected $table = "tour_supplier";

   public function all(){               //hiện toàn bộ thông tin nếu loại tour trùng thì chỉ hiện môt lần 
            try{
                $sql="SELECT t.*
                FROM tour_supplier t
                JOIN (
                    SELECT type_service, MAX(id) AS max_id
                    FROM tour_supplier
                    GROUP BY type_service
                ) x ON t.type_service = x.type_service AND t.id = x.max_id;
                `";
                $data=$this->pdo->query($sql)->fetchAll();
                $list=[];
                foreach($data as $tt){
                    $tour_tupplier = new Tour_supplier();
                    $tour_tupplier->id             =$tt['id'];
                    $tour_tupplier->type_service   =$tt['type_service'];
                    $tour_tupplier->id_suppl       =$tt['id_supplier'];
                    $tour_tupplier->id_tour        =$tt['id_tour'];
                    $list[]=$tour_tupplier;
                }
                return $list;

            }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        }
        }

      public function insert($data) {
        $sql = "INSERT INTO tour_supplier (type_service, id_supplier, id_tour) 
                VALUES (:type_service, :id_supplier, :id_tour)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':type_service' => $data['type_service'], // tên dịch vụ
            ':id_supplier'  => $data['id_supplier'],  // id nhà cung cấp
            ':id_tour'      => $data['id_tour']       // id tour vừa lưu
        ]);
        return $this->pdo->lastInsertId();
    }

    public function delete_tour_supplier($tour_id){
        $sql="DELETE FROM tour_supplier WHERE id_tour = :tour_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> execute(['tour_id'=> $tour_id]);
        return $stmt;
    }

public function find_tour_supplier($id){
    $sql = "SELECT * FROM tour_supplier WHERE id_tour = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt-> execute(['id'=>$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Trả về mảng kết hợp (array)
}


    public function update($id, $type_service, $id_supplier) {
        $stmt = $this->pdo->prepare("UPDATE tour_supplier SET type_service = ?, id_supplier = ? WHERE id = ?");
        return $stmt->execute([$type_service, $id_supplier, $id]);
    }

    // lấy thông tin bản ghi theo id
    public function getById($id){
    $sql = "SELECT * FROM tour_supplier WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

    // tùng
// Lưu nhiều dịch vụ cho 1 nhà cung cấp (id_tour = NULL khi mới thêm NCC)
    public function createForSupplier(int $supplierId, array $services): int {
        if ($supplierId <= 0 || empty($services)) return 0;

        // Chuẩn hoá + khử trùng lặp
        $clean = [];
        foreach ($services as $s) {
            $s = trim($s);
            if ($s !== '') $clean[$s] = true;
        }
        $values = array_keys($clean);
        if (empty($values)) return 0;

        // Giới hạn tối đa 7 dịch vụ để khớp yêu cầu
        $values = array_slice($values, 0, 7);

        $sql = "INSERT INTO tour_supplier (type_service, id_supplier, id_tour)
                VALUES (:type_service, :id_supplier, NULL)";
        $stmt = $this->pdo->prepare($sql);

        $count = 0;
        foreach ($values as $type) {
            $ok = $stmt->execute([
                ':type_service' => $type,
                ':id_supplier'  => $supplierId
            ]);
            if ($ok) $count++;
        }
        return $count;
    }

    // Lấy các dịch vụ (theo NCC) để đổ ra view khi cần
    public function getBySupplier(int $supplierId): array {
        $supplierId = (int)$supplierId;
        $sql = "SELECT id, type_service, id_supplier, id_tour
                FROM tour_supplier
                WHERE id_supplier = {$supplierId}
                ORDER BY id ASC";
        return $this->pdo->query($sql)->fetchAll();
    }

public function delete_by_service_id($tour_id, $service_id) {
    $sql = "DELETE FROM tour_supplier WHERE id_tour = :tour_id AND id = :service_id";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        'tour_id' => $tour_id,
        'service_id' => $service_id
    ]);
}

}
?>