<?php
 class Policy{
    public $id;
    public $type_policy;
    public $content;
    public $id_tour;
 }


class Policy_Model extends BaseModel{
   protected $table = "policy";

    public function insert(array $data) {
        $sql = "INSERT INTO policy (id_tour, content) VALUES (:id_tour, :content)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_tour' => $data['id_tour'],
            ':content' => $data['content']
        ]);
        return $this->pdo->lastInsertId(); // trả về id mới nếu cần
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

    public function update_policy($id, $new_content) {
        $stmt = $this->pdo->prepare("UPDATE policy SET content = ? WHERE id = ?");
        $stmt->execute([$new_content, $id]);
        return $stmt->rowCount(); // trả về số row bị ảnh hưởng
    }


    public function getById($id) {                                                    //lấy dữ liệu theo id
    $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_OBJ); // hoặc FETCH_ASSOC
}
}
?>