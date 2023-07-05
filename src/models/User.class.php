<?php
/*
*
* This class represent a User
*
*/

define('USER_ID', 'id');
define('USER_LOGIN', 'login');
define('USER_TYPE', 'type');

class User {
    var $id;
    var $login;
    var $type;

    public function create(&$db, &$password) {
        $sql = 'INSERT INTO USER(user_login, user_password, user_type) VALUES (?, ?, ?);';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $this->login);
        $stmt->bindParam(2, $password);
        $stmt->bindParam(3, $this->type);
        return $stmt->execute() && $stmt->rowCount() == 1;
    }

    public function update(&$db) {
        $sql = 'UPDATE CAR SET user_login = ? AND user_password = ? AND user_type = ? WHERE user_id = ?';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $this->login);
        $stmt->bindParam(2, password);
        $stmt->bindParam(3, $this->type);
        $stmt->bindParam(4, $this->id);
        return $stmt->execute() && $stmt->rowCount() == 1;
    }

    public function updatePassword(&$db, &$newPassword) {
        $sql = 'UPDATE CAR SET user_password = ? WHERE user_id = ?';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, password);
        $stmt->bindParam(2, $this->id);
        return $stmt->execute() && $stmt->rowCount() == 1;
    }

    public function updateRecoveryKey($db, &$generatedRecoveryKey, $timestamp) {
        // TODO
    }

    public static function readAll(&$db) {
        $sql = 'SELECT user_id, user_login, user_type FROM USER';
        $stmt = $db->prepare($sql);

        $executionResult = $stmt->execute();
        if ($executionResult != true) {
            return null;
        }
        $res = [];
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $res[] = self::extract($row);
        }
        return $res;
    }

    public static function read(&$db, $id) {
        $sql = 'SELECT user_id, user_login, user_type FROM USER WHERE user_id = ?;';
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

    public static function getFromLogin(&$db, &$login) {
        $sql = 'SELECT user_id, user_login, user_type FROM USER WHERE user_login = ?;';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $login);
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

    public static function getFromLoginAndPassword(&$db, &$login, &$password) {
        $sql = 'SELECT user_id, user_login, user_type FROM USER WHERE user_login = ? AND user_password = ?;';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $login);
        $stmt->bindParam(2, $password);
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
        $res->login = $row[1];
        $res->type = $row[2];
        return $res;
    }

    public static function delete(&$db, $id) {
        $sql = 'DELETE FROM USER WHERE user_id = ?;';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $id);
        return $stmt->execute() && $stmt->rowCount() == 1;
    }

    public static function fromArray(&$src) {
        $res = new User();
        $res->id = $src[USER_ID];
        $res->login = $src[USER_LOGIN];
        $res->type = $src[USER_TYPE];
        return $res;
    }

    public function toArray() {
        $res = array();
        $res[USER_ID] = $this->id;
        $res[USER_LOGIN] = $this->login;
        $res[USER_TYPE] = $this->type;
        return $res;
    }
}
?>
