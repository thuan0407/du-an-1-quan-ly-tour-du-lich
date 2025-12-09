<?php
class Tour {
    public $id;
    public $name;
    public $describe;
    public $number_of_days;
    public $price;
    public $date;
    public $id_tourtype;
    public $scope;
    public $number_of_nights;
    public $images;
    public $type_tour;
    public $status;
    public $minimum_scope;
}

class Tour_Model extends BaseModel {

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
                    $tour->describe         = $row['describe']; // vẫn đọc từ db
                    $tour->number_of_days   = $row['number_of_days'];
                    $tour->price            = $row['price'];
                    $tour->date             = $row['date'];
                    $tour->id_tourtype      = $row['id_tourtype'] ?? null;
                    $tour->scope            = $row['scope'];
                    $tour->number_of_nights = $row['number_of_nights'];
                    $tour->status           = $row['status'];
                    $tour->status           = $row['status'];
                    $tour->minimum_scope    = $row['minimum_scope'];
                    $tour->type_tour        = $row['type_tour'];
                    $tours[$id] = $tour;
                }
                if(!empty($row['image'])) {
                    $tours[$id]->images[] = $row['image'];
                }
            }

            return array_values($tours);
        } catch(PDOException $err) {
            echo "Lỗi truy vấn tour: " . $err->getMessage();
            return [];
        }
    }
    
public function getToursByType($selectedType) {                           //lọc theo loại tour
        try {
            $sql = "SELECT t.*, i.img AS image
                    FROM `tour` t
                    LEFT JOIN img_tour i ON t.id = i.id_tour
                    WHERE `id_tourtype` = $selectedType
                    ORDER BY t.id, i.id";
            $data = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $tours = [];
            foreach($data as $row) {
                $id = $row['id'];
                if(!isset($tours[$id])) {
                    $tour = new Tour();
                    $tour->id               = $row['id'];
                    $tour->name             = $row['name'];
                    $tour->describe         = $row['describe']; // vẫn đọc từ db
                    $tour->number_of_days   = $row['number_of_days'];
                    $tour->price            = $row['price'];
                    $tour->date             = $row['date'];
                    $tour->id_tourtype      = $row['id_tourtype'] ?? null;
                    $tour->scope            = $row['scope'];
                    $tour->number_of_nights = $row['number_of_nights'];
                    $tour->status           = $row['status'];
                    $tour->images           = [];
                    $tour->type_tour        = $row['type_tour'];
                    $tours[$id] = $tour;
                }
                if(!empty($row['image'])) {
                    $tours[$id]->images[] = $row['image'];
                }
            }

            return array_values($tours);
        } catch(PDOException $err) {
            echo "Lỗi truy vấn tour: " . $err->getMessage();
            return [];
        }
    }

    public function getToursHigh() {                                                     // lấy theo giá từ cáo xuống
        try {
            $sql = "SELECT t.*, i.img AS image
                    FROM `tour` t
                    LEFT JOIN img_tour i ON t.id = i.id_tour
                    ORDER BY t.price DESC, i.id";
            $data = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $tours = [];
            foreach($data as $row) {
                $id = $row['id'];
                if(!isset($tours[$id])) {
                    $tour = new Tour();
                    $tour->id               = $row['id'];
                    $tour->name             = $row['name'];
                    $tour->describe         = $row['describe']; // vẫn đọc từ db
                    $tour->number_of_days   = $row['number_of_days'];
                    $tour->price            = $row['price'];
                    $tour->date             = $row['date'];
                    $tour->id_tourtype      = $row['id_tourtype'] ?? null;
                    $tour->scope            = $row['scope'];
                    $tour->number_of_nights = $row['number_of_nights'];
                    $tour->status           = $row['status'];
                    $tour->images           = [];
                    $tour->type_tour        = $row['type_tour'];
                    $tours[$id] = $tour;
                }
                if(!empty($row['image'])) {
                    $tours[$id]->images[] = $row['image'];
                }
            }

            return array_values($tours);
        } catch(PDOException $err) {
            echo "Lỗi truy vấn tour: " . $err->getMessage();
            return [];
        }
    }

public function getToursShort() {                                                     // lấy theo giá từ thấp lêm
        try {
            $sql = "SELECT t.*, i.img AS image
                    FROM `tour` t
                    LEFT JOIN img_tour i ON t.id = i.id_tour
                    ORDER BY t.price ASC, i.id";
            $data = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $tours = [];
            foreach($data as $row) {
                $id = $row['id'];
                if(!isset($tours[$id])) {
                    $tour = new Tour();
                    $tour->id               = $row['id'];
                    $tour->name             = $row['name'];
                    $tour->describe         = $row['describe']; // vẫn đọc từ db
                    $tour->number_of_days   = $row['number_of_days'];
                    $tour->price            = $row['price'];
                    $tour->date             = $row['date'];
                    $tour->id_tourtype      = $row['id_tourtype'] ?? null;
                    $tour->scope            = $row['scope'];
                    $tour->number_of_nights = $row['number_of_nights'];
                    $tour->status           = $row['status'];
                    $tour->images           = [];
                    $tour->type_tour        = $row['type_tour'];
                    $tours[$id] = $tour;
                }
                if(!empty($row['image'])) {
                    $tours[$id]->images[] = $row['image'];
                }
            }

            return array_values($tours);
        } catch(PDOException $err) {
            echo "Lỗi truy vấn tour: " . $err->getMessage();
            return [];
        }
    }

    public function insert(Tour $tour) {
        $sql = "INSERT INTO tour (name, price, number_of_days, number_of_nights, scope, `describe`, status, date, id_tourtype, type_tour,minimum_scope)
                VALUES (:name, :price, :number_of_days, :number_of_nights, :scope, :describe, :status, :date, :id_tourtype, :type_tour,:minimum_scope)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $tour->name,
            ':price' => $tour->price,
            ':number_of_days' => $tour->number_of_days,
            ':number_of_nights' => $tour->number_of_nights,
            ':scope' => $tour->scope,
            ':describe' => $tour->describe,
            ':status' => $tour->status,
            ':date' => $tour->date,
            ':id_tourtype' => $tour->id_tourtype,
            ':type_tour' => $tour->type_tour,
            ':minimum_scope' => $tour->minimum_scope
        ]);
        return $this->pdo->lastInsertId();
    }

   public function find_tour($id) {
    try {
        $sql = "SELECT t.*, i.img AS image
                FROM `tour` t
                LEFT JOIN img_tour i ON t.id = i.id_tour
                WHERE t.id = :id
                ORDER BY i.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!$data) return null;

        $tour = new Tour();
        $tour->images = [];

        foreach($data as $row) {
            $tour->id               = $row['id'];
            $tour->name             = $row['name'];
            $tour->describe         = $row['describe'];
            $tour->number_of_days   = $row['number_of_days'];
            $tour->price            = $row['price'];
            $tour->date             = $row['date'];
            $tour->id_tourtype      = $row['id_tourtype'];
            $tour->scope            = $row['scope'];
            $tour->number_of_nights = $row['number_of_nights'];
            $tour->type_tour        = $row['type_tour'];
            $tour->minimum_scope    = $row['minimum_scope'];

            if(!empty($row['image'])) {
                $tour->images[] = $row['image'];
            }
        }
        return $tour;
    } catch (PDOException $err) {
        echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        return null;
    }
}


    public function delete_tour($tour_id) {
        $sql = "DELETE FROM tour WHERE id = :tour_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['tour_id' => $tour_id]);
        return $stmt;
    }

    // Cập nhật tour
    public function update_tour(Tour $tour){                  
                try{
                    $id=(int)$tour->id;
                    $sql="UPDATE `tour` SET 
                        `name` = '".$tour->name."', 
                        `describe` = '".$tour->describe."', 
                        `number_of_days` = '".$tour->number_of_days."', 
                        `price` = '".$tour->price."', 
                        `date` = '".$tour->date."', 
                        `id_tourtype` = '".$tour->id_tourtype."', 
                        `scope` = '".$tour->scope."', 
                        `number_of_nights` = '".$tour->number_of_nights."',
                        `status` = '".$tour->status."',
                        `type_tour` = '".$tour->type_tour."',
                        `minimum_scope` = '".$tour->minimum_scope."'
                        WHERE `tour`.`id` = $id;";
                    $data=$this->pdo->exec($sql);
                    return $data;

                }catch (PDOException $err) {
                echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
            }
            }


    public function tour_status($sql) {                                    //hiển thị theo trạng thái
        try {
            $data = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $tours = [];
            foreach($data as $row) {
                $id = $row['id'];
                if(!isset($tours[$id])) {
                    $tour = new Tour();
                    $tour->id               = $row['id'];
                    $tour->name             = $row['name'];
                    $tour->describe         = $row['describe']; // vẫn đọc từ db
                    $tour->number_of_days   = $row['number_of_days'];
                    $tour->price            = $row['price'];
                    $tour->date             = $row['date'];
                    $tour->id_tourtype      = $row['id_tourtype'] ?? null;
                    $tour->scope            = $row['scope'];
                    $tour->number_of_nights = $row['number_of_nights'];
                    $tour->status           = $row['status'];
                    $tour->images           = [];
                    $tour->type_tour        = $row['type_tour'];
                    $tours[$id] = $tour;
                }
                if(!empty($row['image'])) {
                    $tours[$id]->images[] = $row['image'];
                }
            }

            return array_values($tours);
        } catch(PDOException $err) {
            echo "Lỗi truy vấn tour: " . $err->getMessage();
            return [];  
        }
    }

}
?>
