<?php
 class Tour_type{
    public $id;
    public $tour_type_name;
    public $date;
 }


class Tour_type_Model extends BaseModel{
   public function all(){//hiện toàn bộ thông tin
            try{
                $sql="SELECT * FROM `tour_type`";
                $data=$this->pdo->query($sql)->fetchAll();
                $list=[];
                foreach($data as $tt){
                    $tour_tpye = new Tour_type();
                    $tour_tpye->id               =$tt['id'];
                    $tour_tpye->tour_type_name   =$tt['tour_type_name'];
                    $tour_tpye->date             =$tt['date'];
                    $list[]=$tour_tpye;
                }
                return $list;

            }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        }
        }

    public function create(Tour_type $tour_type){        //thêm danh mục
            try{
                $sql="INSERT INTO `tour_type` (`id`, `tour_type_name`, `date`) VALUES 
                (NULL, '".$tour_type->tour_type_name."', '".$tour_type->date."');";
                $data=$this->pdo->exec($sql);
                return $data;

            }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        }
        }

    public function delete_tour_tour($id){      
            try{
                $sql="DELETE FROM tour_type WHERE `tour_type`.`id` = $id";
                $data=$this->pdo->exec($sql);
                return $data;

            }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        }
        }

     public function find_tour_type($id){                                     //tìm
            try{
                $sql="SELECT * FROM `tour_type` WHERE id = $id";
                $data=$this->pdo->query($sql)->fetch();
                if($data !== false){
                    $tour_type = new Tour_type();
                    $tour_type->id               = $data['id'];
                    $tour_type->tour_type_name   = $data['tour_type_name'];
                    $tour_type->date             = $data['date'];
                    return $tour_type;
                }

            }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        }
        }

    public function update_tour_type(Tour_type $tour_type){        //thêm danh mục
            try{
                $id=(int)$tour_type->id;
                $sql ="UPDATE `tour_type` SET `tour_type_name` = '".$tour_type->tour_type_name."', `date` = '".$tour_type->date."' WHERE `tour_type`.`id` = $id;";
                $data=$this->pdo->exec($sql);
                return $data;

            }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        }
        }    
    public function delete_tour($tour_id){      
            try{
                $sql="DELETE FROM tour WHERE id_loai_tour = $tour_id 
                DELETE FROM loai_tour WHERE id = $tour_id;";
                $data=$this->pdo->exec($sql);
                return $data;

            }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        }
        }
}
?>