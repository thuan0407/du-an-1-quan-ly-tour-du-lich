<?php
 class Tour{
    public $id;
    public $name;
    public $describe;
    public $number_day;
    public $price;
    public $date;
    public $id_tourtype;
    public $id_user;
    public $scope;
    public $number_of_nights;
    public $images;
 }


class Tour_Model extends BaseModel{

   protected $table = "tour";

public function all() {
    try {
        $sql = "SELECT t.*, i.img AS image
                FROM `tour` t
                LEFT JOIN img_tour i ON t.id = i.id_tour
                ORDER BY t.id, i.id";
        $data = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        $tours = [];
        foreach($data as $row) {
            $id = $row['id'];
            if(!isset($tours[$id])) {
                $tour = new Tour();
                $tour->id               = $row['id'];
                $tour->name             = $row['name'];
                $tour->describe         = $row['describe'];
                $tour->number_day       = $row['number_day'];
                $tour->price            = $row['price'];
                $tour->date             = $row['date'];
                $tour->id_tourtype      = $row['id_tourtype'] ?? null; // sửa typo
                $tour->id_user          = $row['id_user'];
                $tour->scope            = $row['scope'];
                $tour->number_of_nights = $row['number_of_nights'];
                $tour->images           = [];
                $tours[$id] = $tour;
            }
            if(!empty($row['image'])) {
                $tours[$id]->images[] = $row['image']; // sửa tên cột
            }
        }

        return array_values($tours);
    } catch(PDOException $err) {
        echo "Lỗi truy vấn tour: " . $err->getMessage();
        return [];
    }
}



      public function insert($data){
        try{
         $sql = "INSERT INTO `tour` 
            (`name`, `describe`, `number_day`, `price`, `date`, `id_tourtype`, `id_user`, `scope`, `number_of_nights`) 
            VALUES 
            (:name, :describe, :number_day, :price, :date, :id_tourtype, :id_user, :scope, :number_of_nights)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
               ':name' => $data['name'],
               ':describe' => $data['describe'],
               ':number_day' => $data['number_day'],
               ':price' => $data['price'],
               ':date' => $data['date'],
               ':id_tourtype' => $data['id_tourtype'], // Sửa từ id_tourtpype
               ':id_user' => $data['id_user'],
               ':scope' => $data['scope'],
               ':number_of_nights' => $data['number_of_nights']
            ]);

            return $this->pdo->lastInsertId(); // trả về ID vừa insert
        } catch(PDOException $err){
            echo "Lỗi insert tour: ".$err->getMessage();
            return false;
        }
    }

    public function find_tour($id){                                     //tìm
            try{
                $sql="SELECT * FROM `tour` WHERE id = $id";
                $data=$this->pdo->query($sql)->fetch();
                if($data !== false){
                    $tour = new Tour();
                    $tour->id               = $data['id'];
                    $tour->name             = $data['name'];
                    $tour->describe         = $data['describe'];
                    $tour->number_day       = $data['number_day'];
                    $tour->price            = $data['price'];
                    $tour->date             = $data['date'];
                    $tour->id_tourtype      = $data['id_tourtype'];
                    $tour->id_user          = $data['id_user'];
                    $tour->scope            = $data['scope'];
                    $tour->number_of_nights = $data['number_of_nights'];
                    return $tour;
                }
            }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        }
        }
    public function delete_tour($tour_id){
        $sql="DELETE FROM tour WHERE id = :tour_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['tour_id'=>$tour_id]);
        return $stmt;
    }


}
?>