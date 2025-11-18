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
                        $tour_guide->email             =$tt['email'];
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
        
        public function find_tour_guide($id){                                                     //hiện toàn bộ thông tin của một hướng dẫn viên
                try{
                    $sql="SELECT * FROM `tour_guide` WHERE `id`=$id";
                    $data=$this->pdo->query($sql)->fetch();
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

        public function update_tour_guide(Tour_guide $tour_guide){                            //update
                try{
                    $id=(int)$tour_guide->id;
                    $sql ="UPDATE `tour_guide` SET 
                    `name` = '".$tour_guide->name."', 
                    `email` = '".$tour_guide->email."', 
                    `img` = '".$tour_guide->img."', 
                    `phone_number` = '".$tour_guide->phone_number."', 
                    `type_guide` = '".$tour_guide->type_guide."', 
                    `foreign_languages` = '".$tour_guide->foreign_languages."', 
                    `certificate` = '".$tour_guide->certificate."', 
                    `years_experience` = '".$tour_guide->years_experience."', 
                    `sex` = '".$tour_guide->sex."', 
                    `health` = '".$tour_guide->health."', 
                    `year_birth` = '".$tour_guide->year_birth."'
                    WHERE `tour_guide`.`id` = $id;";
                    $data=$this->pdo->exec($sql);
                    return $data;

                }catch (PDOException $err) {
                echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
            }
            }
            

        public function change_status_tour_guide(Tour_guide $tour_guide, $value){        //sửa trạng thái
                try{
                    $id=(int)$tour_guide->id;
                    $sql ="UPDATE `tour_guide` SET 
                    `status` = '".$value."'
                    WHERE `tour_guide`.`id` = $id;";
                    $data=$this->pdo->exec($sql);
                    return $data;

                }catch (PDOException $err) {
                echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
            }
            }


        public function filter_tour_guide($sql){                                         //hiện toàn bộ thông tin
                try{
                    $data=$this->pdo->query($sql)->fetchAll();
                    $list=[];
                    foreach($data as $tt){
                        $tour_guide = new Tour_guide();
                        $tour_guide->id                =$tt['id'];
                        $tour_guide->name              =$tt['name'];
                        $tour_guide->email             =$tt['email'];
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


    public function create_tour_guide(Tour_guide $tour_guide){        //thêm hướng dẫn viên
            try{
                $sql="INSERT INTO `tour_guide` (`id`, `name`, `email`, `password`, `img`, `phone_number`, `type_guide`, `status`, 
                `foreign_languages`, `certificate`, `years_experience`, `sex`, `health`, `year_birth`) 
                VALUES (NULL,  
                '".$tour_guide->name."', 
                '".$tour_guide->email."', 
                '".$tour_guide->password."', 
                '".$tour_guide->img."', 
                '".$tour_guide->phone_number."', 
                '".$tour_guide->type_guide."', 
                '".$tour_guide->status."', 
                '".$tour_guide->foreign_languages."', 
                '".$tour_guide->certificate."', 
                '".$tour_guide->years_experience."', 
                '".$tour_guide->sex."', 
                '".$tour_guide->health."',
                '".$tour_guide->year_birth."');";
                $data=$this->pdo->exec($sql);
                return $data;

            }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        }
        }

    }
    ?>