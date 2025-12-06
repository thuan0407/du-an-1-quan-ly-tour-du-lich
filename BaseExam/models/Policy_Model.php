<?php
 class Policy{
    public $id;
    public $title;
    public $content;
    public $id_tour;
 }


class Policy_Model extends BaseModel{
   protected $table = "policy";

    public function insert(array $data) {
        $sql = "INSERT INTO policy (id_tour, title, content) VALUES (:id_tour, :title, :content)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_tour' => $data['id_tour'],
            ':title'   => $data['title'],
            ':content' => $data['content']
        ]);
        return $this->pdo->lastInsertId();
    }



    public function get_policy($tour_id){
        $sql="SELECT content FROM policy WHERE id_tour = :tour_id ";
        $stmt = $this->pdo->prepare($sql);
        $stmt ->execute(['tour_id'=>$tour_id]);
        $contents = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $contents; 
    }

    public function delete_policy($tour_id){
        $sql="DELETE FROM policy WHERE id_tour = :tour_id ";
        $stmt = $this->pdo->prepare($sql);
        $stmt ->execute(['tour_id'=>$tour_id]);
        return $stmt; 
    }

    public function find_policy($id){ 
        $sql = "SELECT * FROM policy WHERE id_tour = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // trả về id + content
    }

    public function update_policy($id, $title, $content) {
        $sql = "UPDATE {$this->table} SET title = :title, content = :content WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':title'   => $title,
            ':content' => $content,
            ':id'      => $id
        ]);
        return $stmt->rowCount();
    }



    public function getById($id) {                                                    //lấy dữ liệu theo id
    $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_OBJ); // hoặc FETCH_ASSOC
}

    public function delete_by_service_id($tour_id, $service_id) {
        $sql = "DELETE FROM tour_supplier WHERE id_tour = :tour_id AND id = :service_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'tour_id' => $tour_id,
            'service_id' => $service_id
        ]);
    }

}
?>