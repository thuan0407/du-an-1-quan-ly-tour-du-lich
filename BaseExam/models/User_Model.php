<?php
 class User{
    public $id;
    public $name;
    public $email;
    public $password;
    public $phone_number;
    public $role;
    public $status;
    public $img;
    public $date;
    public $sex;
 }


class User_Model extends BaseModel{
   public function all(){//hiện toàn bộ thông tin
            try{
                $sql="SELECT * FROM `user`";
                $data=$this->pdo->query($sql)->fetchAll();
                $list=[];
                foreach($data as $tt){
                    $user = new User();
                    $user->id            = $tt['id'];
                    $user->name          = $tt['name'];
                    $user->email         = $tt['email'];
                    $user->phone_number  = $tt['phone_number'];
                    $user->img           = $tt['img'];
                    $user->password      = $tt['password'];
                    $user->role          = $tt['role'];
                    $user->status        = $tt['status'];
                    $user->sex           = $tt['sex'];
                    $user->date          = $tt['date'];
                    $list[]=$user;
                }
                return $list;

            }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        }
        }


   public function create(user $user){
        try{
        $sql="INSERT INTO `user` (`id`, `email`, `password`, `name`, `phone_number`, `role`, `status`, `img`, `date`, `sex`) 
        VALUES (NULL, '".$user->email."', '".$user->password."', '".$user->name."', '".$user->phone_number."',
         '".$user->role."', '".$user->status."', '".$user->img."', '".$user->date."', '".$user->sex."');";
        $data=$this->pdo->exec($sql);
        return $data;
           
        }catch(Exception $error){
            echo "lỗi: ".$error->getMessage()."<br>";
        }
    }
}
?>