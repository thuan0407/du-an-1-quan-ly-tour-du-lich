<?php
class img_tour{
    public $id;
    public $img;
    public $id_tour;
}

class Img_tour_Model extends BaseModel{
    protected $table = "img_tour";

    public function insert($data) {
        $sql = "INSERT INTO img_tour (img, id_tour) VALUES (:img, :id_tour)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':img' => $data['img'],
            ':id_tour' => $data['id_tour']
        ]);
        return $this->pdo->lastInsertId(); // trả về ID mới tạo
    }


    public function get_img_tour($tour_id){
    $sql = "SELECT img FROM img_tour WHERE id_tour = :tour_id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['tour_id'=> $tour_id]);
    $images = $stmt->fetchAll(PDO::FETCH_COLUMN); // trả về tất cả ảnh
    return $images;
    }

    public function delete_img_tour($tour_id){
        $sql="DELETE FROM img_tour WHERE id_tour = :tour_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['tour_id'=> $tour_id]);
        return $stmt;
    }

}





?>