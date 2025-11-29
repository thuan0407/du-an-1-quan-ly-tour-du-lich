<?php
 class Pay{
    public $id;
    public $date;
    public $payment_method;
    public $status;
    public $amount_money;
    public $note;
    public $id_book_tour ;
 }


class Pay_Model extends BaseModel{
    public function create($pay){
        try {
            $sql = "INSERT INTO `pay` (`id`, `date`, `payment_method`, `status`, `amount_money`, `note`, `id_book_tour`) 
            VALUES (NULL, 
            '".$pay->date."', 
            '".$pay->payment_method."', 
            '".$pay->status."', 
            '".$pay->amount_money."', 
            '".$pay->note."', 
            '".$pay->id_book_tour."');";

            $data = $this->pdo->exec($sql);
            return $this->pdo->lastInsertId();

        } catch (PDOException $e){
            echo "Lỗi insert book_tour: " . $e->getMessage();
            return false;
        }
    }
}
?>