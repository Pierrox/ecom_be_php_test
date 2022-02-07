<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 0");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once './config.php';
require_once './Database.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->login) && !empty($data->password)) {

    $userLogin = filter_var($data->login, FILTER_SANITIZE_STRING);
    $userPassword = filter_var($data->password, FILTER_SANITIZE_STRING);

    if ($userLogin && $userPassword) {
        $database = new Database();
        $db = $database->getConnection();
        $db->select_db(MYSQL_DATABASE);

        $insertQuery = "CREATE USER '" . $userLogin . "'@'localhost' IDENTIFIED BY '" . $userPassword . "';";

        if ($queryResult = $db->query($insertQuery)) {
            http_response_code(201);
            echo json_encode(array("message" => "User added successfully."));
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "User already exists."));
        }

        $db->close();
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "The user login or password string is not correct."));
    }
} else{
    http_response_code(400);
    echo json_encode(array("message" => "The user login or password value is empty."));
}