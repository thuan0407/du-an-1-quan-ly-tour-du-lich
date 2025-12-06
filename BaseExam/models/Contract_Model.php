    <?php
    class Contract{
        public $id;
        public $name;
        public $date;
        public $content;
        public $value;
        public $status;
        public $id_book_tour;
    }

    class Contract_Model extends BaseModel{
        public function create($contract) {
            $sql = "INSERT INTO `contract` (`id`, `name`, `date`, `status`, `content`, `value`, `id_book_tour`) 
            VALUES (NULL, 
            '".$contract->name."', 
            '".$contract->date."', 
            '".$contract->status."', 
            '".$contract->content."', 
            '".$contract->value."', 
            '".$contract->id_book_tour."');";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $this->pdo->lastInsertId();
        }

        public function delete_contract($id_book_tour){
            try{
                $sql  ="DELETE FROM contract WHERE id_book_tour = :id_book_tour";
                $stmt =$this->pdo->prepare($sql);
                $stmt->execute([':id_book_tour'=>$id_book_tour]);
                return $stmt->rowCount();
            }catch(PDOException $err){
            echo "Lỗi xóa hợp đồng: "  .$err->getMessage();
            return false;
           }
        }


}
    ?>