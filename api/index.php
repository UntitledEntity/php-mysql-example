<?php

switch ($_POST['type']) 
{
    case 'login':
        $user = sanitize($_POST['user']);
        $pass = sanitize($_POST['pass']);

        $login_resp = login($user, $pass);
        switch ($login_resp)
        {
            case 'user_not_found':
                die(json_encode(array(
                    "success" => false,
                    "error" => "Invalid username."
                )));

            case 'password_mismatch':
                die(json_encode(array(
                    "success" => false,
                    "error" => "Invalid password."
                )));

            case 'banned':
                die(json_encode(array(
                    "success" => false,
                    "error" => "User banned."
                )));

            default:
                // you could add a HWID check here, or in the login function itself.
                
                die(json_encode(array(
                    "success" => false,
                    "data" => $login_resp
                )));
        }

}

?>