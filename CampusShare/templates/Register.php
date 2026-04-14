<?php 
    $name = filter_input(INPUT_POST, 'username') ;
    $email = filter_input(INPUT_POST, 'email') ;
    $password = filter_input(INPUT_POST, 'password') ;

    $servername = "localhost" ;
    $username = "root" ;
    $password = "" ;
    $dbname = "GUIT" ;

    $connection = new mysqli ($servername , $username , $password, $dbname) ;
    if(mysqli_connect_error()) {
        die('connection Error ('. mysqli_connect_errn().')' . mysqli_connect_error() ) ;
    }
    else{
        $sql = "INSERT INTO users ( name, email, password ) value ('$name', '$email' , '$password')" ;
        $sql2 = "SELECT * FROM users WHERE email= '$email' " ;
    }

?>