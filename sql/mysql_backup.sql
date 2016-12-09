// Piotrze tu coś kiedyś będzie, be ready!
//Czekam i czekam!!!

$pdo = new PDO("mysql:host=localhost;dbname=Shop_db", 'root', 'coderslab');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=Shop_db", 'root', 'coderslab');
    echo 'Połączenie udane';
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}