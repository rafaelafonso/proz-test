<?php

class User {

    private $table = 'User';

    // usernameIsAvailable
    //
    private function usernameIsAvailable($username) {

        $network = new Network();
        $existingUser = $network->search($this->table, "username", $username);
        $row = $existingUser->fetch_assoc();

        return is_null($row);
    }

    // checkCredentials
    //
    private function checkCredentials($username, $password) {

        $network = new Network();
        $storedCredential = $network->search($this->table, "username", $username);
        $row = $storedCredential->fetch_assoc();

        return ($row["password"] == $password);
    }

    // register
    //
    public function register($username, $password) {

        $network = new Network();
        $usernameAvailable = $this->usernameIsAvailable($username);

        if ($usernameAvailable) {
            $network->writeUser($username, $password);
            return true;
        }
        else {
            return false;
        }
    }

    // login
    //
    public function login($username, $password) {

        $userLogged = $this->checkCredentials($username, $password);
        return $userLogged;
    }
}

?>
