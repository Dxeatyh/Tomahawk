<?PHP
session_start();

header('Content-Type: application/json');
$data = file_get_contents('php://input');


if(strlen($data) > 1){
    $_SESSION["json_data"] = $data;
    echo $data;
}else{
    if(isset($_SESSION['json_data'])){
        echo json_encode(json_decode($_SESSION["json_data"]), JSON_PRETTY_PRINT);
    }else{
        echo '{ "error" : "I\'m using sessions and it seems that the server does not support my method"}';
    }
}