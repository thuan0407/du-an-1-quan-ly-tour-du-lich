<?php
class Customer_list{
    public $id;
    public $list_customer;
    public $quantity;
    public $note;
    public $id_book_tour;
}

class Customer_list_Model extends BaseModel{
    public function create($customer_list){
        try {
            $sql = "INSERT INTO `customer_list` (`id`, `list_customer`, `quantity`, `note`, `id_book_tour`) 
            VALUES (NULL, 
            '".$customer_list->list_customer."', 
            '".$customer_list->quantity."', 
            '".$customer_list->note."', 
            '".$customer_list->id_book_tour."');";

            $data = $this->pdo->exec($sql);
            return $this->pdo->lastInsertId();

        } catch (PDOException $e){
            echo "Lỗi insert book_tour: " . $e->getMessage();
            return false;
        }
    }

        public function delete_customer_list($id_book_tour){
            try{
                $sql  ="DELETE FROM customer_list WHERE id_book_tour = :id_book_tour";
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