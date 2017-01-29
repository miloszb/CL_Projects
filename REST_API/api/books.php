<?php
require_once 'config.php';
require_once 'src/library.php'; // all other includes are there

header('Content-Type:application/json; charset=UTF-8');

$mysqli = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
// database connection details to be supplied by user in config.php
if ($mysqli->connect_error) {
    die(sprintf("connection error: %s\n",$mysqli->connect_error));
}
if (!$mysqli->set_charset('utf8')) {
    die(sprintf("UTF-8 settings error: %s\n",$mysqli->connect_error));
}
$db = new Connection($mysqli);

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
            if($_POST['title'] && $_POST['author']) {
                $book = new Book();
                $book->setTitle($_POST['title']);
                $book->setAuthor($_POST['author']);
                $book->setDescription($_POST['description']);
                $book->save($db);
                if ($book->getID() != -1) {
                    echo json_encode('BOOK SUCCESSFULLY ADDED');
                } else {
                    echo json_encode('ADD FAILED');
                    
                }
            } else {
                echo json_encode('TITLE AND AUTHOR ARE REQUIRED!');
            }
        break;
    case 'GET':
            if(isset($_GET['id'])) {
                $book = new Book();
                $book->get($db, $_GET['id']);
                echo json_encode($book);
            } else {
                $book = new Book();
                $book->getAll($db);
                echo json_encode($book);
            }
        break;
    case 'PUT':
            echo 'EDYCJA';
        break;
    case 'DELETE':
            parse_str(file_get_contents("php://input"), $del_vars);
            if (isset($del_vars['id'])) {
                if (Book::delete($db, $del_vars['id'])) {
                    echo json_encode('BOOK SUCCESSFULLY DELETED'); 
                } else {
                    echo json_encode('DELETE FAILED'); 
                }
            } else {
                echo json_encode('NO ID');
            }
        break;
}
$mysqli->close();
$mysqli = null;    
