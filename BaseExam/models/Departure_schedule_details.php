<?php
class Departure_schedule_details {
    public $id;
    public $content;
    public $id_departure_schedule;
}

class Departure_schedule_details_Model extends BaseModel {

    public function insert(array $data) {
        $sql = "INSERT INTO departure_schedule_details (`id_departure_schedule`, `content`) 
                VALUES (:id_departure_schedule, :content)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id_departure_schedule' => $data['id_departure_schedule'],
            'content'               => $data['content']
        ]);
    }

    public function get_all_departure_schedule_details($id_departure_schedule){
        try{
            $sql ="SELECT * FROM departure_schedule_details WHERE id_departure_schedule=:id_departure_schedule";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id_departure_schedule'=>$id_departure_schedule]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $list =[];
            foreach($data as $tt){
                $departure_schedule_details = new Departure_schedule_details();
                $departure_schedule_details->id                        = $tt['id'];
                $departure_schedule_details->content                   = $tt['content'];
                $departure_schedule_details->id_departure_schedule     = $tt['id_departure_schedule'];
                $list[] = $departure_schedule_details;
            }
            return $list;
        }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
            return [];
        }
    }

        public function delete_departure_schedule_details($id_departure_schedule){
            try{
                $sql  ="DELETE FROM departure_schedule_details WHERE id_departure_schedule = :id_departure_schedule";
                $stmt =$this->pdo->prepare($sql);
                $stmt->execute([':id_departure_schedule'=>$id_departure_schedule]);
                return $stmt->rowCount();
            }catch(PDOException $err){
            echo "Lỗi xóa hợp đồng: "  .$err->getMessage();
            return false;
           }
        }
}
?>
