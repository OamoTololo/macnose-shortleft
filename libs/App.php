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
}

$obj = new App;
