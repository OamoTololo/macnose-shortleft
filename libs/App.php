<?php require '../config/config.php';

class App
{
    // Variables
    public string $host = DB_HOST;
    public string $user = DB_USER;
    public string $password = DB_PASS;
    public string $database = DB_NAME;
    public $port = DB_PORT;
    public $link;

    // Functions:

    public function __construct()
    {
        $this->connect();
    }
    // Connecting to database
    public function connect()
    {
        $this->link = new PDO("mysql:host=$this->host:$this->port;dbname=$this->database", $this->user, $this->password);

        if ($this->link) {
            echo "Connected successfully";
        }
    }
    // Selecting all the data from the database
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
    // Selecting a single row of data from the database
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
    // Inserting data into a database
    public function insert($query, $array, $path)
    {
        if ($this->validate($array) == "Empty") {
            echo "<script>alert('One or more inputs are empty!')</script>";
        } else {
            $insert = $this->link->prepare($query);
            $insert->execute($array);

            header("Location:" . $path);
        }
    }
    // Updating data in a database
    public function update($query, $array, $path)
    {
        if ($this->validate($array) == "Empty") {
            echo "<script>alert('One or more inputs are empty!')</script>";
        } else {
            $update = $this->link->prepare($query);
            $update->execute($array);

            header("Location:" . $path);
        }
    }
    // Deleting data in a database
    public function delete($query, $path)
    {
        $delete = $this->link->query($query);
        $delete->execute($query);

        header("Location:" . $path);
    }
    // Validating inputted data
    public function validate($array)
    {
        if (in_array("", $array)) {
            echo "Empty";
        } else {
            return true;
        }
    }
    public function register($query, $array, $path)
    {
        if ($this->validate($array) == "Empty") {
            echo "<script>alert('One or more inputs are empty!')</script>";
        } else {
            $registerUser = $this->link->prepare($query);
            $registerUser->execute($array);

            header("Location:" . $path);
        }
    }

    public function login($query, $data, $path)
    {
        // Validating email
        $loginUser = $this->link->prepare($query);
        $loginUser->execute();

        $fetch = $loginUser->fetch(PDO::FETCH_OBJ);

        if ($fetch->rowCount() == 1) {
            // Validate password
            if (password_verify($data["password"], $fetch->password)) {
                // Start session

                header("Location:" . $path);
            }
        }
    }
    // Starting session
    public function userSession()
    {
        session_start();
    }
    // Validating sessions
    public function sessionValidation($path)
    {
        if (isset($_SESSION['id'])) {
            header("Location:" . $path);
        }
    }
    public function disconnect()
    {
        $this->link = null;
    }
}

$obj = new App;
