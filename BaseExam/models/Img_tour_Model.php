<?php
class img_tour{
    public $id;
    public $img;
    public $id_tour;
}

class Img_tour_Model extends BaseModel{
    protected $table = "img_tour";

    public function insert($data){
        try {
            $sql = "INSERT INTO img_tour (id_tour, img) VALUES (:id_tour, :img)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id_tour' => $data['tour_id'],
                ':img'     => $data['image_path']
            ]);
            return true;
        } catch (PDOException $e){
            echo "Lỗi insert img: " . $e->getMessage();
            return false;
        }
    }


    //lấy ảnh để xóa
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

    // Cập nhật ảnh (theo path mới)
    public function update_image($id, $new_path) {
        $stmt = $this->pdo->prepare("UPDATE img_tour SET img = ? WHERE id = ?");
        return $stmt->execute([$new_path, $id]);
    }

    //lấy đường dẫn để update
    public function get_img_tour_with_id($tour_id){
    $sql = "SELECT id, img FROM img_tour WHERE id_tour = :tour_id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['tour_id'=> $tour_id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ); // mỗi phần tử có ->id, ->img
}

}





?>