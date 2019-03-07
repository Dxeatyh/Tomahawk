<?PHP
header('Content-Type: application/json');
$data = file_get_contents('php://input');
session_start();

if(strlen($data) > 1){

    $_SESSION["newsession"] = $data;
    echo $data;
}else{
    $json = json_encode(json_decode($_SESSION["newsession"]), JSON_PRETTY_PRINT);
    echo $json;
}