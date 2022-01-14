<?php

    $inData = getRequestInfo();

    $id = 0;
    $firstName = "";
    $lastName = "";

    $connection = new mysqli(hostname:"localhost", username:"USER", password:"PASSWORD", database:"COP4331");

    if($connection->connect_error)
    {
        returnWithError($connection->connect_error);
    }
    else
    {
        $prepString = "SELECT ID, firstName, lastName FROM Users WHERE Login=? AND Password=?";
        
        $statement = $connection->prepare($prepString);
        $statement->bind_param(types:"ss", var1:$inData["login"], var2:$inData["password"]); //? var1 and var2 are placeholders, they may not work and can me deleted
        $statement->execute();

        $result = $statement->get_result();

        if ($row = $result->fetch_assoc())
        {
            returnWithInfo($row["firstName"], $row["lastName"], $row["id"]);
        }
        else
        {
            returnWithError("No Records Found");
        }

        $statement->close();
        $connection->close();
    }

    function getRequestInfo()
    {
        return jason_decode(file_get_contents("php://input"), true); //? this line was in his login.php but I don't see this function
    }

    function sendResultInfoAsJson($obj)
    {
        header("Content-type: application/json");
        echo $obj;
    }

    function returnWithError($err)
    {
        $retValue = '{"id":0, "firstName":"", "lastName":"", "error":"' . $err . '"}';
        sendResultInfoAsJson($retValue);
    }

    function returnWithInfo($firstName, $lastName, $id)
    {
        $retValue = '{"id":" . $id . ", "firstName":"' . $firstName . '", "lastName":"' . $lastName . '", "error":""}';
    }
?>