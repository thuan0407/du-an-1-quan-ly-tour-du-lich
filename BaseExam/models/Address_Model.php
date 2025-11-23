<?php
class Address{
    public $id;
    public $name;
    public $status;
    public $id_tour;
}
class Address_Model extends BaseModel{

    protected $table = "address";

        public function all(){//hiện toàn bộ thông tin
            try{
                $sql="SELECT * FROM `address`";
                $data=$this->pdo->query($sql)->fetchAll();
                $list=[];
                foreach($data as $tt){
                    $address = new Address();
                    $address->id          =$tt['id'];
                    $address->name        =$tt['name'];
                    $address->status      =$tt['status'];
                    $address->id_tour     =$tt['id_tour'];
                    $list[]=$address;
                }
                return $list;

            }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        }
        }

    public function insert($data){
    $sql = "INSERT INTO address (name, status, id_tour) VALUES (:name, :status, :id_tour)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        ':name'    => $data['name'],        // tên địa điểm
        ':status'  => $data['status'] ?? 1, // mặc định 1 nếu chưa có
        ':id_tour' => $data['id_tour']      // id tour vừa tạo
    ]);
    return $this->pdo->lastInsertId();
}

    public function delete_address($tour_id){
        $sql="DELETE FROM address WHERE id_tour = :tour_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt-> execute(['tour_id'=>$tour_id]);
        return $stmt;
    }

    public function find_address($id){
        $sql = "SELECT * FROM address WHERE id_tour = :id ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id'=>$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     public function update($id, $name) {
        $stmt = $this->pdo->prepare("UPDATE addresses SET name = ? WHERE id = ?");
        return $stmt->execute([$name, $id]);
    }

}
?>