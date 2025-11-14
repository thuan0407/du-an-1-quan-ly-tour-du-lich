<?php
class Address{
    public $id;
    public $name;
    public $status;
    public $id_tour;
}
class Address_Model extends BaseModel{

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
}
?>