<?php

use function PHPSTORM_META\override;

class User
{

    public string $fullname;
    public string $phoneNumber;
    public string $email;
    public int $id;

    public function __construct( string $phoneNumber, string $email, string $fullname, int $id = -1 ) {
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->fullname = $fullname;
        $this->id = $id;
    }

    /*
    public function getphoneNumber() : string { return $this->phoneNumber; }
    public function getemail() : string { return $this->email; }
    public function getfullname() : string { return $this->fullname; }
    public function getbio() : string { return $this->bio; }
    public function getid() : int { return $this->id; }
    public function setphoneNumber(string $phoneNumber) { $this->phoneNumber = $phoneNumber; }
    public function setemail(string $email) { $this->email = $email; }
    public function setfullname(string $fullname) { $this->fullname = $fullname; }
    public function setbio(string $bio) { $this->bio = $bio; }
    public function setid(int $id) { $this->id = $id; }
*/
    public function __toString() {
        return "User { " .
            "id: $this->id , fullname: '$this->fullname' phoneNumber: '$this->phoneNumber' , " .
            "email: '$this->email' } ";
    }

    public static function print(User|array $users) {
        foreach ($users as $user) {
            echo $user;
        }
    } 

}

?>