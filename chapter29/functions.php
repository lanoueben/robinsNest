<?php
//To access the MySQL databases go to:
//http://localhost/phpMyAdmin/?lang=en
//https://courses.cs.washington.edu/courses/cse154/18au/resources/servers/mamp_mysql.html


$host = 'localhost';
$data = 'robinsnest';
$user = 'ben';
$pass = 'password';
$chrs = 'utf8mb4';
$attr = "mysql:host=$host;dbname=$data;charset=$chrs";
$opts =
[
    PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
//attempt to get a PDO, or a PHP Data Object
//This $pdo variable is a "SQL Database" object
//that lets us interact with the Database 

try{
    $pdo = new PDO($attr,$user,$pass,$opts);
}
catch(PDOException $e){
    throw new PDOException($e->getMessage(),(int)$e ->getCode());
}



//Functions

function createTable($name, $query){
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
}



function queryMysql($query)
{
    global $pdo;
    return $pdo->query($query);
}

function destroySession()
{
    $_SESSION=array();

    if(session_id() != "" || isset($_COOKIE[session_name()]))
    setcookie(session_name(), '',time()-2592000,'/');

    session_destroy();
}




function showProfile($user)
{
    global $pdo;
    if(file_exists("$user.jpg"))
    {
        echo "<img src='$user.jpg' style = 'float:left'>";
    }

    $result = $pdo->query("SELECT * FROM profiles WHERE user='$user'");

    while($row = $result->fetch() )
    {
        echo (stripslashes($row['text']) . "<br style='clear:left;'><br>");
    }


    

}

?>

