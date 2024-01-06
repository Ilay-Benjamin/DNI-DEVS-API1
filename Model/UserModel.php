<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
class UserModel extends Database
{
    public function getUsers( $limit ) {
        return $this->execute("SELECT * FROM users LIMIT ?", [ "i", $limit ]);
    }

    public function findUser( $id ) {
        $res = (array) $this->execute("SELECT * FROM users WHERE id=?", [ "i", $id ]);
        $userData = (array) $res[0];
        $user = new User($userData['username'], $userData['password'], $userData['fullname'], $userData['bio'], $userData['id']);
        return $user;
    }

    public function appendUser( $username, $password, $fullname, $bio ) {
        $this->execute("INSERT INTO users(username, password, fullname, bio) VALUES (?, ?, ?, ?)", [ "ssss", $username, $password, $fullname, $bio ]);
        return $this->getUsers(1000);
    }

}