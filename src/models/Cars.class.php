<?php
/*
*
* An example of a CRUD class used to request the database
*
*/

class Car {
    var $id;
    var $brand;
    var $model;
    var $color;
    var $matriculation;

    public function create(&$db) {
        $sql = 'INSERT INTO CAR(car_brand, car_model, car_color, car_matriculation) VALUES (?, ?, ?, ?);';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $this->brand);
        $stmt->bindParam(2, $this->model);
        $stmt->bindParam(3, $this->color);
        $stmt->bindParam(4, $this->matriculation);
        return $stmt->execute() && $stmt->rowCount() == 1;
    }

    public function update(&$db) {
        $sql = 'UPDATE CAR SET car_brand = ? AND car_model = ? AND car_color = ? AND car_matriculation = ? WHERE car_id = ?';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $this->brand);
        $stmt->bindParam(2, $this->model);
        $stmt->bindParam(3, $this->color);
        $stmt->bindParam(4, $this->matriculation);
        $stmt->bindParam(5, $this->id);
        return $stmt->execute() && $stmt->rowCount() == 1;
    }

    public static function readAll(&$db) {
        $sql = 'SELECT car_id, car_brand, car_model, car_color, car_matriculation FROM CAR';
        $stmt = $db->prepare($sql);

        $executionResult = $stmt->execute();
        if ($executionResult != true) {
            return null;
        }
        $res = array();
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $res[] = self::extract($row);
        }
        return $res;
    }

    public static function read(&$db, $id) {
        $sql = 'SELECT car_brand, car_model, car_color, car_matriculation FROM CAR WHERE car_id = ?;';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $id);
        $executionResult = $stmt->execute();
        if ($executionResult != true) {
            return null;
        }
        $row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
        if (!$row) {
            return null;
        }
        return self::extract($row);
    }

    private static function extract(&$row) {
        $res = new self();
        $res->id = $row[0];
        $res->brand = $row[1];
        $res->model = $row[2];
        $res->color = $row[3];
        $res->matriculation = $row[4];
        return $res;
    }

    public static function delete(&$db, $id) {
        $sql = 'DELETE FROM CAR WHERE car_id = ?;';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $id);
        return $stmt->execute() && $stmt->rowCount() == 1;
    }
}
?>
