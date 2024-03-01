<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
class UserModel extends Database
{
    public function getUsers( int $limit ) {
        $usersData = $this->execute("SELECT * FROM users LIMIT ?", [ "i", $limit ]);
        $users = array();
        foreach ($usersData as $userData) {
            array_push($users, new User($userData['username'], $userData['password'], $userData['fullname'], $userData['bio'], $userData['id']));
        }
        return $users;
    }

    public function findUser( int $id ) {
        $userData = $this->execute("SELECT * FROM users WHERE id=?", [ "i", $id ])[0];
        $user = new User($userData['username'], $userData['password'], $userData['fullname'], $userData['bio'], $userData['id']);
        return $user;
    }

    public function appendUser( User $user ) {
        $this->execute("INSERT INTO users(username, password, fullname, bio) VALUES (?, ?, ?, ?)", 
            [ "ssss", $user->username, $user->password, $user->fullname, $user->bio ]);
        return $this->getUsers(1000);
    }

    public function deleteUser ( int $id ) { 
        $this->execute("DELETE FROM users WHERE id=?", [ "i", $id ]);
        return $this->getUsers(1000);
    }

    public function updateUser (array $changes, int $id) {
        $statement = "UPDATE users SET";
        $types = "";
        $values = [];
        foreach ($changes as $field => $value) {
            $statement .= ( strlen($types) > 0 ? ", " : " " ) . $field . "=?";
            array_push($values, $value);
            $types .= "s";
        }
        $statement .= " WHERE id=?";
        array_push($values, $id);
        $types .= "i";
        $this->execute($statement, [$types, ...$values]);
        return $this->getUsers(1000);
    }
}