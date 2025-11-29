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

        
        public function get_languages_unique() {
            try {
                $sql = "SELECT DISTINCT foreign_languages FROM tour_guide WHERE foreign_languages IS NOT NULL AND foreign_languages != ''";
                $stmt = $this->pdo->query($sql);
                return $stmt->fetchAll(PDO::FETCH_COLUMN); // Lấy mảng 1 chiều các ngôn ngữ
            } catch (PDOException $e) {
                echo "Lỗi: " . $e->getMessage();
                return [];
            }
        }

        
        public function get_type_guide($type_guide){                     //hiện toàn bộ thông tin HDV có cùng khu vực vực với loại tour
                try{
                    $sql="SELECT * FROM `tour_guide` WHERE `type_guide` = $type_guide";
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

            
          //code thằng e Hùng (đăng nhập hdv, sửa thông tin)
            // Đăng nhập hướng dẫn viên
    public function login($email, $password) {
        try {
            $sql = "SELECT * FROM tour_guide WHERE email = ? AND password = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email, $password]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$data) return false;

            $guide = new Tour_guide();
            foreach ($data as $key => $value) {
                $guide->$key = $value;
            }

            return $guide;

        } catch (PDOException $err) {
            echo "Lỗi truy vấn login(): " . $err->getMessage();
        }
    }
    //sửa thông tin hdv
    public function updateProfile($id, $name, $sex, $phone_number, $password = null, $img = null, $year_birth = null) {
    try {
        if ($password && $img !== null && $year_birth !== null) {
            $sql = "UPDATE tour_guide 
                    SET name=?, sex=?, phone_number=?, password=?, img=?, year_birth=?
                    WHERE id=?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$name, $sex, $phone_number, $password, $img, $year_birth, $id]);
        } 
        else if ($password && $img !== null) { // không thay ngày sinh
            $sql = "UPDATE tour_guide 
                    SET name=?, sex=?, phone_number=?, password=?, img=?
                    WHERE id=?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$name, $sex, $phone_number, $password, $img, $id]);
        } 
        else if ($password && $year_birth !== null) { // không thay ảnh
            $sql = "UPDATE tour_guide 
                    SET name=?, sex=?, phone_number=?, password=?, year_birth=?
                    WHERE id=?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$name, $sex, $phone_number, $password, $year_birth, $id]);
        } 
        else if ($password) { // chỉ thay password
            $sql = "UPDATE tour_guide 
                    SET name=?, sex=?, phone_number=?, password=?
                    WHERE id=?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$name, $sex, $phone_number, $password, $id]);
        } 
        else if ($img !== null && $year_birth !== null) { // thay ảnh + năm sinh
            $sql = "UPDATE tour_guide 
                    SET name=?, sex=?, phone_number=?, img=?, year_birth=?
                    WHERE id=?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$name, $sex, $phone_number, $img, $year_birth, $id]);
        } 
        else if ($img !== null) { // chỉ thay ảnh
            $sql = "UPDATE tour_guide 
                    SET name=?, sex=?, phone_number=?, img=?
                    WHERE id=?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$name, $sex, $phone_number, $img, $id]);
        } 
        else if ($year_birth !== null) { // chỉ thay năm sinh
            $sql = "UPDATE tour_guide 
                    SET name=?, sex=?, phone_number=?, year_birth=?
                    WHERE id=?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$name, $sex, $phone_number, $year_birth, $id]);
        } 
        else { // chỉ thay các trường cơ bản
            $sql = "UPDATE tour_guide 
                    SET name=?, sex=?, phone_number=?
                    WHERE id=?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$name, $sex, $phone_number, $id]);
        }

    } catch (PDOException $err) {
        echo "Lỗi updateProfile: " . $err->getMessage();
        return false;
    }

    //thay ảnh
    }
    public function updateProfileImg($id, $img) {
        try {
            $sql = "UPDATE tour_guide SET img = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$img, $id]);
        } catch (PDOException $err) {
            echo "Lỗi updateProfileImg: " . $err->getMessage();
            return false;
        }
    }

    }
    ?>