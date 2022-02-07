<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 0");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once './config.php';
require_once './Database.php';

if (isset($_GET['user']) && !empty($_GET['user'])) {

    $user = filter_var($_GET['user'], FILTER_SANITIZE_STRING);

    if ($user) {
        $database = new Database();
        $db = $database->getConnection();
        $db->select_db(MYSQL_DATABASE);

        $selectQuery = "SELECT * FROM mysql.user WHERE User=\"". $user ."\";";

        if ($queryResult = $db->query($selectQuery)) {

            if ($queryResult->num_rows > 0) {
                $responseArray = array();

                while ($row = $queryResult->fetch_assoc()) {
                    $responseArray[] = $row;
                }

                $db->close();

                http_response_code(200);
                echo json_encode($responseArray);

            } else {
                http_response_code(404);
                echo json_encode(array("message" => "No user found with this ID"));
            }

        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No user found."));
        }
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "An error occurred."));
    }

}