<?php
 class Tour_supplier{
    public $id;
    public $type_service;
    public $id_supplier ;
    public $id_tour;
 }


class Tour_supplier_Model extends BaseModel{
   protected $table = "tour_supplier";

   public function all(){//hiện toàn bộ thông tin
            try{
                $sql="SELECT * FROM `tour_supplier`";
                $data=$this->pdo->query($sql)->fetchAll();
                $list=[];
                foreach($data as $tt){
                    $tour_tupplier = new Tour_supplier();
                    $tour_tupplier->id             =$tt['id'];
                    $tour_tupplier->type_service   =$tt['type_service'];
                    $tour_tupplier->id_supplier    =$tt['id_supplier'];
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
            ':type_service' => $data['type_service'],
            ':id_supplier' => $data['id_supplier'],
            ':id_tour' => $data['id_tour']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function delete_tour_supplier($tour_id){
        $sql="DELETE FROM tour_supplier WHERE id_tour = :tour_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> execute(['tour_id'=> $tour_id]);
        return $stmt;
    }


}
?>