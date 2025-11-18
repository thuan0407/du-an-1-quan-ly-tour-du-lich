<?php
 class Policy{
    public $id;
    public $type_policy;
    public $content;
    public $id_tour;
 }


class Policy_Model extends BaseModel{
   protected $table = "policy";

   public function insert($data) {
        $sql = "INSERT INTO policy (type_policy, content, id_tour) 
                VALUES (:type_policy, :content, :id_tour)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':type_policy' => $data['type_policy'],
            ':content' => $data['content'],
            ':id_tour' => $data['id_tour']
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
}
?>