<?php
 class Tour_guide{
    public $id;
    public $name;
    public $email;
    public $password;
    public $img;
    public $phone_number;
    public $type_guide;
    public $status ;
    public $foreign_languages;
    public $certificate;
    public $years_experience;
    public $sex;
    public $health;
    public $year_birth;
 }


class Tour_guide_Model extends BaseModel{
   public function all(){//hiện toàn bộ thông tin
            try{
                $sql="SELECT * FROM `tour_guide`";
                $data=$this->pdo->query($sql)->fetchAll();
                $list=[];
                foreach($data as $tt){
                    $tour_guide = new Tour_guide();
                    $tour_guide->id                =$tt['id'];
                    $tour_guide->name              =$tt['name'];
                    $tour_guide->password          =$tt['password'];
                    $tour_guide->img               =$tt['img'];
                    $tour_guide->phone_number      =$tt['phone_number'];
                    $tour_guide->type_guide        =$tt['type_guide'];
                    $tour_guide->status            =$tt['status'];
                    $tour_guide->foreign_languages =$tt['foreign_languages'];
                    $tour_guide->certificate       =$tt['certificate'];
                    $tour_guide->years_experience  =$tt['years_experience'];
                    $tour_guide->sex               =$tt['sex'];
                    $tour_guide->health            =$tt['health'];
                    $tour_guide->year_birth        =$tt['year_birth'];
                    $list[]=$tour_guide;
                }
                return $list;

            }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        }
        }
    
    public function find($id){//hiện toàn bộ thông tin
            try{
                $sql="SELECT * FROM `tour_guide` WHERE `id`=$id";
                $data=$this->pdo->query($sql)->fetchAll();
                if($data !== false){
                    $tour_guide = new Tour_guide();
                    $tour_guide->id                =$data['id'];
                    $tour_guide->name              =$data['name'];
                    $tour_guide->password          =$data['password'];
                    $tour_guide->img               =$data['img'];
                    $tour_guide->phone_number      =$data['phone_number'];
                    $tour_guide->type_guide        =$data['type_guide'];
                    $tour_guide->status            =$data['status'];
                    $tour_guide->foreign_languages =$data['foreign_languages'];
                    $tour_guide->certificate       =$data['certificate'];
                    $tour_guide->years_experience  =$data['years_experience'];
                    $tour_guide->sex               =$data['sex'];
                    $tour_guide->health            =$data['health'];
                    $tour_guide->year_birth        =$data['year_birth'];
                }
                return $tour_guide;

            }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        }
        }
}
?>