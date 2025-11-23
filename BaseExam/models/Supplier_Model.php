<?php 

class supplier {
    public $id;
    public $name;
    public $address;
    public $representative;
    public $phone_number;
    public $status;
    public $email;
    public $note;
}

class Supplier_Model extends BaseModel {

    protected $table = "supplier";

    // Lấy toàn bộ thông tin nhà cung cấp
    public function all() {
        try {
            $sql  = "SELECT * FROM supplier";
            $data = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            $list = [];

            foreach ($data as $row) {
                $sp = new supplier();
                $sp->id             = $row['id'];
                $sp->name           = $row['name'];
                $sp->address        = $row['address'];
                $sp->representative = $row['representative'];
                $sp->phone_number   = $row['phone_number'];
                $sp->status         = $row['status'];
                $sp->email          = $row['email'];
                $sp->note           = $row['note'];
                $list[] = $sp;
            }

            return $list;

        } catch (PDOException $err) {
            echo "Lỗi supplier all(): " . $err->getMessage();
            return [];
        }
    }

    // Thêm nhà cung cấp mới
    public function create(supplier $sp) {
        try {
            $sql = "INSERT INTO supplier
                        (name, address, representative, phone_number, status, email, note)
                    VALUES
                        (:name, :address, :representative, :phone_number, :status, :email, :note)";

            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([
                ':name'           => $sp->name,
                ':address'        => $sp->address,
                ':representative' => $sp->representative,
                ':phone_number'   => $sp->phone_number,
                ':status'         => (int)$sp->status,
                ':email'          => $sp->email,
                ':note'           => $sp->note,
            ]);

            if ($ok) {
                return (int)$this->pdo->lastInsertId(); // ID supplier mới
            }
            return 0;

        } catch (PDOException $err) {
            echo "Lỗi supplier create(): " . $err->getMessage();
            return 0;
        }
    }

    // Lấy 1 nhà cung cấp theo ID
    public function find($id) {
        try {
            $id  = (int)$id;
            $sql = "SELECT * FROM supplier WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data === false) return null;

            $sp = new supplier();
            $sp->id             = $data['id'];
            $sp->name           = $data['name'];
            $sp->address        = $data['address'];
            $sp->representative = $data['representative'];
            $sp->phone_number   = $data['phone_number'];
            $sp->status         = $data['status'];
            $sp->email          = $data['email'];
            $sp->note           = $data['note'];

            return $sp;

        } catch (PDOException $err) {
            echo "Lỗi supplier find(): " . $err->getMessage();
            return null;
        }
    }

    // Cập nhật thông tin nhà cung cấp
    public function update(supplier $sp) {
        try {
            $sql = "UPDATE supplier SET
                        name           = :name,
                        address        = :address,
                        representative = :representative,
                        phone_number   = :phone_number,
                        email          = :email,
                        status         = :status
                    WHERE id = :id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name'           => $sp->name,
                ':address'        => $sp->address,
                ':representative' => $sp->representative,
                ':phone_number'   => $sp->phone_number,
                ':email'          => $sp->email,
                ':status'         => (int)$sp->status,
                ':id'             => (int)$sp->id,
            ]);

            return $stmt->rowCount(); // 0 hoặc 1

        } catch (PDOException $err) {
            echo "Lỗi supplier update(): " . $err->getMessage();
            return 0;
        }
    }

    // Thêm dịch vụ cho tour (tránh trùng với bảng supplier)
    public function insertForTour($tour_id, $service_name) {
        try {
            $sql = "INSERT INTO supplier_tour (tour_id, service_name) VALUES (:tour_id, :service_name)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':tour_id'      => $tour_id,
                ':service_name' => $service_name
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $err) {
            echo "Lỗi insertForTour(): " . $err->getMessage();
            return 0;
        }
    }


    public function getByServiceName(string $serviceName) {
    try {
        $sql = "SELECT s.* 
                FROM supplier s
                JOIN tour_supplier ts ON s.id = ts.id_supplier
                WHERE ts.type_service = :service_name
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':service_name' => $serviceName]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $sp = new supplier();
            $sp->id             = $data['id'];
            $sp->name           = $data['name'];
            $sp->address        = $data['address'];
            $sp->representative = $data['representative'];
            $sp->phone_number   = $data['phone_number'];
            $sp->status         = $data['status'];
            $sp->email          = $data['email'];
            $sp->note           = $data['note'];
            return $sp;
        }
        return null;
    } catch (PDOException $err) {
        echo "Lỗi getByServiceName(): " . $err->getMessage();
        return null;
    }
}

}

?>
