<?php

    $servername = "db";
    $username = "maxim";
    $password = "maxim_password";
    $dbname ="maxwels";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    class User {
        public $id;
        public $username;
        public $email;
        public $password;
        public $is;
        public $dateOfCreation;

        function __construct($id, $username, $email, $password, $is, $dateOfCreation) {
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->is = $is;
            $this->dateOfCreation = $dateOfCreation;
        }

        public function getId() {
            return $this->id;
        }

        public function getUsername() {
            return $this->username;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getPassword() {
            return $this->password;
        }

        public function getIs() {
            return $this->is;
        }

        public function getDateOfCreation() {
            return $this->dateOfCreation;
        }

        public function getLogin() {
            $user = $this->getId();
            $pass = $this->getPassword();
            $login = array ("name" => $user, "password" => $pass);
            return $login;
        }
    }


    class Programmer  extends User{
        public $pid;
        public $firstName;
        public $lastName;
        public $doneRequests;
        public $status;

        function __construct($pid, $firstName, $lastName, $doneRequests, $status, $id, $username, $email, $password, $is, $dateOfCreation) {
            parent::__construct($id, $username, $email, $password, $is, $dateOfCreation);
            $this->pid = $pid;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->doneRequests = $doneRequests;
            $this->status = $status;
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->is = $is;
            $this->dateOfCreation = $dateOfCreation;

        }

        public function getPid() {
            return $this->pid;
        }

        public function getFirstName() {
            return $this->firstName;
        }

        public function getLastName() {
            return $this->lastName;
        }

        public function getDoneRequests() {
            return $this->doneRequests;
        }

        public function getStatus() {
            return $this->status;
        }

        
    }


    class Customer extends User {
        public $cid;
        public $firstName;
        public $lastName;
        public $phone;
        public $corp;

        function __construct($cid, $firstName, $lastName, $phone, $corp, $id, $username, $email, $password, $is, $dateOfCreation) {
            parent::__construct($id, $username, $email, $password, $is, $dateOfCreation);
            $this->cid = $cid;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->phone = $phone;
            $this->corp = $corp;
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->is = $is;
            $this->dateOfCreation = $dateOfCreation;

        }

        public function getCid() {
            return $this->cid;
        }

        public function getFirstName() {
            return $this->firstName;
        }

        public function getLastName() {
            return $this->lastName;
        }

        public function getPhone() {
            return $this->phone;
        }

        public function getCorp() {
            return $this->corp;
        }

        public function createRequest($topic1, $type1, $deadline1) {
            $rid = Null;
            $requestedBy =  Null;
            $workingOn = "NONE";
            $topic = $topic1;
            $type = $type1;
            $requestedOn = Null;
            $deadline = $deadline1;
            $request = new Request();
            $status = "REQUESTED";
        }
    }


    class Request {
        public $rid;
        public $requestedBy;
        public $workingOn;
        public $topic;
        public $type;
        public $requestedOn;
        public $deadline;
        public $status;

        function __construct($rid, $requestedBy, $workingOn, $topic, $type, $requestedOn, $deadline, $status, $satisfied) {
            $this->rid = $rid;
            $this->requestedBy = $requestedBy;
            $this->workingOn = $workingOn;
            $this->topic = $topic;
            $this->type = $type;
            $this->requestedOn = $requestedOn;
            $this->deadline = $deadline;
            $this->status = $status;
            $this->satisfied =$satisfied;
        }

        public function getRid() {
            return $this->rid;
        }

        public function getRequestedBy() {
            return $this->requestedBy;
        }

        public function getWorkingOn() {
            return $this->workingOn;
        }

        public function getTopic() {
            return $this->topic;
        }

        public function getType() {
            return $this->type;
        }

        public function getRequestedOn() {
            return $this->requestedOn;
        }

        public function getDeadline() {
            return $this->deadline;
        }

        public function getStatus() {
            return $this->status;
        }

        public function getSatisfied() {
            return $this->satisfied;
        }
    }
    
    $sqlGetAllUsers = $conn->query("SELECT * FROM `user`");
    $allUsers = array();
    while ($row = $sqlGetAllUsers -> fetch_assoc()) {
        $newUser = new User($row["ID"], $row["Username"], $row["Email"], $row["Password"], $row["is"], $row["Date of creation"]);
        array_push($allUsers,$newUser);
    }

    $sqlGetAllProgrammers = $conn->query("SELECT * FROM `programmer` INNER JOIN `user` ON `programmer`.`P_ID`=`user`.`ID`");
    $allProgrammers = array();
    while ($row = $sqlGetAllProgrammers -> fetch_assoc()) {
        $newProgrammer = new Programmer($row["P_ID"], $row["First_Name"], $row["Last_Name"], $row["Done_Request"], $row["Status"], $row["ID"], $row["Username"], $row["Email"], $row["Password"], $row["is"], $row["Date of creation"]);
        array_push($allProgrammers, $newProgrammer);
    }

    $sqlGetAllCustommers = $conn->query("SELECT * FROM `customer` INNER JOIN `user` ON `customer`.`C_ID`=`user`.`ID`");
    $allCustomers = array();
    while ($row = $sqlGetAllCustommers -> fetch_assoc()) {
        $newCustommer = new Customer($row["C_ID"], $row["FirstName_or_NameOfCompany"], $row["Last_Name"], $row["Phone"], $row["Company_or_Privat"], $row["ID"], $row["Username"], $row["Email"], $row["Password"], $row["is"], $row["Date of creation"]);
        array_push($allCustomers, $newCustommer);
    }

    $sqlGetAllRequests = $conn->query("SELECT * FROM `requests`");
    $allRequests = array();
    while ($row = $sqlGetAllRequests -> fetch_assoc()) {
        $newRequest = new Request($row["R_ID"], $row["Requested_by"], $row["Working_on"], $row["Topic"], $row["Type"], $row["Requested_on"], $row["Deadline"], $row["Status"], $row["Satisfied"] );
        array_push($allRequests, $newRequest);
    }

    function test($q) {
        echo($q);
    }


?>