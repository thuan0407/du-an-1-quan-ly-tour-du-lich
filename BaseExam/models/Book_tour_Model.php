<?php
class Book_tour{
    public $id;
    public $date;
    public $total_amount;
    public $note;
    public $status;
    public $id_user;
    public $quantity;
    public $id_departure_schedule;
    public $id_tour_guide;
    public $id_tour;
}

class Book_tour_Model extends BaseModel{
    public function all(){//hiện toàn bộ thông tin
            try{
                $sql="SELECT * FROM `book_tour`";
                $data=$this->pdo->query($sql)->fetchAll();
                $list=[];
                foreach($data as $tt){
                    $address = new Address();
                    $address->id                       =$tt['id'];
                    $address->date                     =$tt['date'];
                    $address->total_amount             =$tt['total_amount'];
                    $address->note                     =$tt['note'];
                    $address->status                   =$tt['status'];
                    $address->id_user                  =$tt['id_user'];
                    $address->quantity                 =$tt['quantity'];
                    $address->id_departure_schedule    =$tt['id_departure_schedule'];
                    $address->id_tour_guide            =$tt['id_tour_guide'];
                    $address->id_tour                  =$tt['id_tour'];
                    $list[]=$address;
                }
                return $list;

            }catch (PDOException $err) {
            echo "Lỗi truy vấn sản phẩm: " . $err->getMessage();
        }
        }

        public function getidbooking() {                           //lấy id_tour ở bảng book_tour
            try {
                $sql = "SELECT DISTINCT id_tour FROM book_tour";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(); // ✅ phải có ()
                return $stmt->fetchAll(PDO::FETCH_COLUMN); // trả về mảng 1 chiều chứa id_tour
            } catch (PDOException $e) {
                echo "Lỗi truy vấn book_tour: " . $e->getMessage();
                return [];
            }
        }
}
?>