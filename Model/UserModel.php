<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
class UserModel extends Database
{
    public function getUsers( int $limit ) {
        $usersData = $this->execute("SELECT * FROM users LIMIT ?", [ "i", $limit ]);
        $users = array();
        foreach ($usersData as $userData) {
            array_push($users, new User($userData['phoneNumber'], $userData['email'], $userData['fullname'], $userData['id']));
        }
        return $users;
    }

    public function findUserById( int $id ) {
        $userData = $this->execute("SELECT * FROM users WHERE id=?", [ "i", $id ])[0];
        if (isset($userData)) {
            $user = new User($userData['phoneNumber'], $userData['email'], $userData['fullname'], $userData['id']);
            return $user;
        }
        return null;
    }
    
    public function findUserByEmail( string $email ) {
        $userData = $this->execute("SELECT * FROM users WHERE email=?", [ "s", $email ])[0];
        if (isset($userData)) {
            $user = new User($userData['phoneNumber'], $userData['email'], $userData['fullname'], $userData['id']);
            return $user;
        }
        return null;
    }

    public function appendUser( User $user ) {
        $findUserByEmailResults = $this->findUserByEmail($user->email);
        if ( isset( $findUserByEmailResults ) ) {
            throw new Exception("The email already exists.");
        } else {
            $this->execute("INSERT INTO users(phoneNumber, email, fullname) VALUES (?, ?, ?)", 
            [ "sss", $user->phoneNumber, $user->email, $user->fullname]);
            return $this->getUsers(1000);
        }
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