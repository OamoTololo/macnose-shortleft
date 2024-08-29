<?php require '../config/config.php';

class App
{
    public string $host = DB_HOST;
    public string $user = DB_USER;
    public string $password = DB_PASS;
    public string $database = DB_NAME;
    public $port = DB_PORT;
    public $link;
    // Connecting to database
    public function __construct()
    {
        $this->connect();
    }
    public function connect()
    {
        $this->link = new PDO("mysql:host=$this->host:$this->port;dbname=$this->database", $this->user, $this->password);

        if ($this->link) {
            echo "Connected successfully";
        }
    }
    public function selectAll($query)
    {
        $statement = $this->link->query($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }
    public function selectOne($query)
    {
        $statement = $this->link->query($query);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_OBJ);

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }
    public function disconnect()
    {
        $this->link = null;
    }
}

$obj = new App;
