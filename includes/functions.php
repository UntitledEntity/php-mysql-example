<?php

require 'mysql_connect.php';

function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// global ip variable
$ip = fetch_ip();

function fetch_ip()
{
    return $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
}

function login($user,$pass)
{
    // get the mysql_link
    global $mysql_link;

    // get the ip
    global $ip;

    // sanitize
    $user = sanitize($user);
    $pass = sanitize($pass);
    
    // find user
    $result = mysqli_query($mysql_link, "SELECT * FROM users WHERE username = '$user'");
    
    // unable to find user
    if (mysqli_num_rows($result) === false)
    {
        return 'user_not_found';
    }
    
    // get user data
    while ($row = mysqli_fetch_array($result))
    {
        $pw = $row['password'];
        $hwidd = $row['hwid'];
        $banned = $row['banned'];
    }
    
    // check if pass matches
    if (password_verify($pass, $pw) === false)
    {
        return 'password_mismatch';
    }
    
    // update last login time
    $timestamp = time();
    mysqli_query($mysql_link, "UPDATE users SET lastlogin = '$timestamp' WHERE username = '$user'");
    
    // update the ip
    mysqli_query($mysql_link, "UPDATE users SET ip = '$ip' WHERE username = '$user'");

    return 'validated';
}

function register($user, $pass)
{
    // get the mysql_link
    global $mysql_link;

    // get the ip
    global $ip;

    // hash the password 
    $password = password_hash($pass, PASSWORD_BCRYPT);

    // check if there's an existing user before inserting one
    $result = mysqli_query($mysql_link, "SELECT * FROM users WHERE username = '$user'");
    
    // found existing username
    if (mysqli_num_rows($result) >= 1)
    {
        return 'user_already_taken';
    }

    $timestamp = time();

    $resp = mysqli_query($mysql_link, "INSERT INTO users (username, password, expires, hwid, banned, ip, lastlogin) VALUES ('$user', '$password', '', '', '0', '$ip', '$timestamp')");
    if ($resp === false)
    {
        return mysqli_error($mysql_link);
    }

    return 'registered';
}

?>
