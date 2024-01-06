<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
class UserModel extends Database
{
    public function getUsers($limit)
    {
            return $this->select("SELECT * FROM users LIMIT ?", ["i", $limit]);
    }

    public function findUser($id) {
        return $this->select("SELECT * FROM users WHERE id=?", ["i", $id]);
    }

    public function appendUser($username, $password, $fullname, $bio) {
        $this->insert("INSERT INTO users(username, password, fullname, bio) VALUES (?, ?, ?, ?)", ["ssss", $username, $password, $fullname, $bio]);
        return $this->getUsers(1000);
    }

}