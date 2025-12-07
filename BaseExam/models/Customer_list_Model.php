<?php
class Customer_list{
    public $id;
    public $name;
    public $phone;
    public $note;
    public $id_book_tour;
    public $sex;
    public $status;
}

class Customer_list_Model extends BaseModel{
    public function create($customer_list){
        try {
            $sql = "INSERT INTO `customer_list` (`id`, `status`, `sex`, `note`, `id_book_tour`, `name`, `phone`)
             VALUES (NULL, 
             '".$customer_list->status."', 
             '".$customer_list->sex."', NULL, 
             '".$customer_list->id_book_tour."', 
             '".$customer_list->name."', 
             '".$customer_list->phone."');";

            $data = $this->pdo->exec($sql);
            return $this->pdo->lastInsertId();

        } catch (PDOException $e){
            echo "Lỗi insert book_tour: " . $e->getMessage();
            return false;
        }
    }

    public function delete_customer_list($id_book_tour){       // xóa danh sách theo id book tour
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


    public function delete($id){                                //xóa khánh hàng theo id
        try{
            $sql  ="DELETE FROM customer_list WHERE id= :id";
            $stmt =$this->pdo->prepare($sql);
            $stmt->execute([':id'=>$id]);
            return $stmt->rowCount();
        }catch(PDOException $err){
        echo "Lỗi xóa hợp đồng: "  .$err->getMessage();
        return false;
        }
    }

    public function get_customer_list($id_book_tour){
        try{
            $sql = "SELECT * FROM customer_list WHERE id_book_tour = :id_book_tour";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id_book_tour'=>$id_book_tour]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $err){
        echo "Lỗi xóa hợp đồng: "  .$err->getMessage();
        return false;
        }
    }


     // Insert khách hàng mới
    public function insert($data){
        try {
            $sql = "INSERT INTO customer_list 
                    (status, sex, note, id_book_tour, name, phone) 
                    VALUES (:status, :sex, :note, :id_book_tour, :name, :phone)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':status' => $data['status'] ?? 1,
                ':sex' => $data['sex'] ?? 0,
                ':note' => $data['note'] ?? null,
                ':id_book_tour' => $data['id_book_tour'],
                ':name' => $data['name'],
                ':phone' => $data['phone']
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e){
            echo "Lỗi insert customer: " . $e->getMessage();
            return false;
        }
    }

    
    // Update khách hàng theo id
    public function update($id, $data){
        try {
            $sql = "UPDATE customer_list SET 
                        name = :name, 
                        phone = :phone, 
                        sex = :sex, 
                        status = :status 
                    WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $data['name'],
                ':phone'=> $data['phone'],
                ':sex'  => $data['sex'] ?? 0,
                ':status'=> $data['status'] ?? 1,
                ':id'   => $id
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e){
            echo "Lỗi update customer: " . $e->getMessage();
            return false;
        }
    }

}
?>