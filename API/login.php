<?php

    //$ creates a var = 0 for int, '' for char, "" for string

    $inData = getRequestInfo();

    $id = 0;
    $firstName = "";
    $lastName = "";

    $connection = new mysqli(hostname:"localhost", username:"ADMIN", password:"Password", database:"COP4331");

    if($connection->connect_error)
    {
        returnWithError($connection->connect_error);
    }
    else
    {
        $prepString = "SELECT ID, firstName, lastName FROM Users WHERE Login=? AND Password=?";
        $statement = $connection->prepare($prepString);
        $statement->bind_param(types:"ss", var1:$inData["login"], var2:$inData["password"])
    }
?>