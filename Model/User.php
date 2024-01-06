<?php

use function PHPSTORM_META\override;

class User
{
    public string $username;
    public string $password;
    public string $fullname;
    public string $bio;
    public int $id;

    public function __construct( string $username, string $password, string $fullname, string $bio = "", int $id = -1 ) {
        $this->username = $username;
        $this->password = $password;
        $this->fullname = $fullname;
        $this->bio = $bio;
        $this->id = $id;
    }

    /*
    public function getUsername() : string { return $this->username; }
    public function getpassword() : string { return $this->password; }
    public function getfullname() : string { return $this->fullname; }
    public function getbio() : string { return $this->bio; }
    public function getid() : int { return $this->id; }
    public function setUsername(string $username) { $this->username = $username; }
    public function setpassword(string $password) { $this->password = $password; }
    public function setfullname(string $fullname) { $this->fullname = $fullname; }
    public function setbio(string $bio) { $this->bio = $bio; }
    public function setid(int $id) { $this->id = $id; }
*/
    public function __toString() {
        return "User { " .
            "id: $this->id , username: '$this->username' , password: '$this->password' , " .
            "fullname: '$this->fullname' , bio: '$this->bio' } ";
    }

    public static function print(User|array $users) {
        foreach ($users as $user) {
            echo $user;
        }
    } 

}

?>