<?php 
require_once __DIR__ . '/../Classes/UserManager.php';
require_once __DIR__ .'/../Classes/Student.php';
require_once __DIR__ .'/../Classes/Course.php';
require_once __DIR__ .'/../Classes/Teacher.php';
class User{
    private string $Name;

    private string $User_ID;

    private string $Password;

    private string $Email;

    private string $Phone_Number;

    private string $Role;
    
    public $UserManager;
     public $Data;

    public function __construct(string $Name,string $User_ID, string $Password, string $Email, string $Role,string $Phone_Number){
        //set User ID & Password
        $this->UserManager=new UserManager();
        $this->Data = new Data();
        $this->Name=$Name;
        $this->User_ID=$User_ID;
        $this->Password=$Password;
        $this->Email=$Email;
        $this->Role=$Role;
        $this->Phone_Number=$Phone_Number;
        
    }
    
    public function getName(){
        //return User Name
        return $this->Name;
    }
    public function getUserID(){
        //return User_ID
        return $this->User_ID;
    }
    public function getPassword(){
        //return Password
        return $this->Password;
    }
     public function getEmail(){
        //return email
        return $this->Email;
    }

    public function getPhone_Number(){
        //return Phone_Number
        return $this->Phone_Number;
    }

    public function SetRole(){
        //user when singup there role will set as student, teacher or else cant sing up they must be added in db
        $this->Role = "Student";
    }
    
    public function UserFactory(){
        //call User Manager to return the object either student or no 
        $this->UserManager->CreateUser($this->getUserID(), $this->getPassword());
    }

    public function EmailValid(){
        //check is user email is valid 
        return filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL);
    }

    public function DBsave(){
        // This method will save the current user object to the database.
    
        // 1. Prepare connection (using PDO, mysqli, etc.)
        // $conn = new PDO(...); // Example only

        // 2. Prepare the SQL query (INSERT INTO users ...)
        // $sql = "INSERT INTO users (name, user_id, password, email, phone_number, role) VALUES (?, ?, ?, ?, ?, ?)";

        //role will be set as student
        // 3. Bind parameters and execute
        // $stmt = $conn->prepare($sql);
        // $stmt->execute([$this->Name, $this->User_id, $this->password, $this->Email, $this->Phone_Number, $this->Role]);

        // 4. Handle errors and success
        // if ($stmt->rowCount() > 0) {
        //     echo "User saved successfully!";
        // } else {
        //     echo "Failed to save user.";
        // }

    // Placeholder message for now
    echo "DBsave() called: This would save the user to the database in production.";
    }
}



?>