<?php
    session_start();
?>
<html>
    <head>
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
            $test = 0;
            $loggedIn = 0;
            $version = rand(0,999999999) + rand(0,999999999);
            echo("<link rel='stylesheet' href='phpstyle.css?v=$version'/>
                <script src='php-website-code.js?v=$version'></script>
            ");

            include 'class.php';
        ?>
        <meta charset="utf-8"/>
        <link rel="shortcut icon" type="x-icon" href="logo_small_icon_only.png"/>
        <title>
            Your Requests
        </title>
    </head>
    <body class="bg">
        <div class="face">
            <div class="programmer-bar">
                <ul>
                    <li class="programmers">
                        <a class="list-face">
                            Programmer
                        </a>
                        <ul>
                            <?php
                                for ($i = 0; $i < (count($allProgrammers)); $i++) {
                                    $pid = $allProgrammers[$i]->getPid();
                                    $status = $allProgrammers[$i]->getStatus();
                                    $mail = $allProgrammers[$i]->getEmail();
                                    $username = $allProgrammers[$i]->getUsername();
                                    $uid = $allProgrammers[$i]->getId();

                                    if($uid != $_SESSION['id']) {
                                        if ($status == "AVAILABLE") {
                                        echo ("<li> <a href='mailto:$mail' id='you' class='programmer-icon' style='background-color: #00ff00; color:black;'> $username is $status </a></li>");
                                        }

                                        if ($status == "BUSY") {
                                            echo ("<li> <a id='you' class='programmer-icon' style='background-color: #ff0000; color:black;'> $username is $status </a></li>");
                                        }
                                    }
                                }
                            ?>
                        </ul>
                    </li>
                    <li class="programm-theme">
                        <a class="list-face">
                            Programms
                        </a>
                        <ul>
                            <li>
                                <a>
                                    Website
                                </a>
                            </li>
                            <li>
                                <a>
                                    Webdesign
                                </a>
                            </li>
                            <li>
                                <a>
                                    Game
                                </a>
                            </li>
                            <li>
                                <a>
                                    Database
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <form class="search-field" method="post">
                            <input class="type-field" type="test" list ="suggestions"name="search"/>
                            <datalist id="suggestions" name="search">
                            <?php
                                for ($i=0; $i < count($allProgrammers) ; $i++) { 
                                    $mail = $allProgrammers[$i]->getEmail();
                                    $name = $allProgrammers[$i]->getUsername();
                                    echo("<option value='$name | $mail'>");
                                }
                            ?>
                            </datalist>
                            <input class="search-button" type="submit" value="🔎" onclick="search($_GET['search'])"/>
                        </form>

                    </li>
                    <li class="help">
                        <a href="mailto:maxwels.contacts@gmail.com" class="list-face">
                            ?
                        </a>
                    <li>
                </ul>
            </div>
            <div class="request-bar">
                <ul>
                    <li class="request-list">
                        <a class="list-face" onclick="showAll()">
                            Show all
                        </a>
                    </li>
                    <li class="add-request">
                        <a class="list-face" onclick="addRequests()">
                            Add
                        </a>
                    </li>
                    <li class="done-requests">
                        <a class="list-face" onclick="showDone()">
                            Done
                        </a>
                    </li>
                </ul>
            </div>
            <div class="main-screen">
                <div class="all-requests" id="allRequests">
                    <?php
                        echo( "
                            <table class='request-table' id='request-table'>
                                <thead>
                                    <tr>
                                        <th> Working on </th>
                                        <th> Topic </th>
                                        <th> Type </th>
                                        <th> Requested on </th>
                                        <th> Deadline </th>
                                        <th> Status </th>
                                    </tr>
                                </thead>
                                <tbody>
                        ");
                        for ($i = 0; $i < count($allRequests); $i++) {
                            $rid = $allRequests[$i]->getRid();
                            $requestedBy = $allRequests[$i]->getRequestedBy();
                            $workingOn = $allRequests[$i]->getWorkingOn();
                            $topic = $allRequests[$i]->getTopic();
                            $type = $allRequests[$i]->getType();
                            $requestedOn = $allRequests[$i]->getRequestedOn();
                            $deadline = $allRequests[$i]->getDeadline();
                            $status = $allRequests[$i]->getStatus();
                            if ($status != "DONE" && $requestedBy == $_SESSION['id'] ) {

                                for ($i=0; $i < count($allProgrammers); $i++) { 
                                    if ($allProgrammers[$i]->getPid() == $workingOn) {
                                        $programmer = $allProgrammers[$i]->getUsername();
                                    }
                                }
                                echo("
                                    <tr>
                                        <td class='requester'> <a style='width=100%; height=100%;' href=mailto:''> $programmer </a> </td>
                                        <td> $topic </td>
                                        <td> $type </td>
                                        <td> $requestedOn </td>
                                        <td> $deadline </td>
                                        <td> $status </td>
                                    </tr>"
                                );
                            }
                        }
                        echo("
                                </tbody>
                            </table>
                        ");
                    ?>
                </div>
                <div class="all-requests" id="doneRequests">
                    <?php
                        echo( "
                            <table class='request-table' id='request-table'>
                                <thead>
                                    <tr>
                                        <th> Working on </th>
                                        <th> Topic </th>
                                        <th> Type </th>
                                        <th> Requested on </th>
                                        <th> Deadline </th>
                                        <th> Status </th>
                                    </tr>
                                </thead>
                                <tbody>
                        ");

                        for ($i = 0; $i < count($allRequests); $i++) {
                            $rid = $allRequests[$i]->getRid();
                            $requestedBy = $allRequests[$i]->getRequestedBy();
                            $workingOn = $allRequests[$i]->getWorkingOn();
                            $topic = $allRequests[$i]->getTopic();
                            $type = $allRequests[$i]->getType();
                            $requestedOn = $allRequests[$i]->getRequestedOn();
                            $deadline = $allRequests[$i]->getDeadline();
                            $status = $allRequests[$i]->getStatus();

                            for ($i=0; $i < count($allProgrammers); $i++) { 
                                if ($allProgrammers[$i]->getPid()) {
                                    $programmer = $allUsers[$i]->getUsername();
                                }
                            }

                            if ($status == "DONE" && $requestedBy == $_SESSION['id'] ) {
                                echo("
                                    <tr>
                                        <td class='requester'> <a style='width=100%; height=100%;' href=mailto:''> $programmer </a> </td>
                                        <td> $topic </td>
                                        <td> $type </td>
                                        <td> $requestedOn </td>
                                        <td> $deadline </td>
                                        <td> $status </td>
                                    </tr>"
                                );
                            }
                        }
                        echo("
                                </tbody>
                            </table>
                        ");
                    ?>
                </div>
                <div class="all-requests" id="addRequests">
                    <div class="createRequestBG">
                        <form class="createRequest">
                            <?php
                                echo("
                                <label for='topic'> What is it about </label><br>
                                <input type='text' id='topic' name='topic'/><br>
                                <input type='radio' id='website' name='type' value='Website'/>
                                <label class='radio-label' for='website'> Website </label><br>
                                <input type='radio' id='Webdesign' name='type' value='Webdesign'/>
                                <label class='radio-label' for='Webdesign'>Webdesign</label><br>
                                <input type='radio' id='Game' name='type' value='Game'/>
                                <label class='radio-label' for='Game'>Game</label><br>
                                <input type='radio' id='Database' name='type' value='Database'/>
                                <label class='radio-label' for='Database'>Database</label><br>
                                <input type='radio' id='Other' name='type' value='Other'/>
                                <label class='radio-label' for='Other'>Other</label><br>
                                <input type='submit' value='Create Request'/> 
                            ");
                                if (isset($_GET['type']) && isset($_GET['topic']) && isset($_SESSION['id'])) {
                                    $type = $_GET['type'];
                                    $topic = $_GET['topic'];
                                    $user = $_SESSION['id'];
                                    $sqlCreateRequest = "INSERT INTO `requests`(`Requested_by`, `Topic`, `Type`) VALUES ('$user', '$type', '$topic')";
                                    $conn->query($sqlCreateRequest) or die($conn-> error);
                                    echo ("<script> self.location = 'http://localhost/requestCustomer.php' </script>");
                                }
                            ?>
                        </form>
                    </div>          
                </div>
            </div>
        </div>
    </body>
</html>