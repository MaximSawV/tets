<?php
    ini_set('session.gc_maxlifetime', 86400);
    session_set_cookie_params(86400);
    session_start();
?>
<html>
    <head>
        <?php
            require_once("php-function/db_connect.php");
            require_once("php-function/class.php");
            require_once("php-function/get_os.php");
            $loggedIn = 0;
            $version = rand(0,999999999) + rand(0,999999999);
            echo("<link rel='stylesheet' href='phpstyle.css?v=$version'/>
                <script src='php-website-code.js?v=$version'></script>
            ");
            $ip = 0;
            $os = getOS();
            if ($os == "Windows 10") {
                $GLOBALS['ip'] = "192.168.175.128";
            } else if ($os == "Linux") {
                $GLOBALS['ip'] = "localhost";
            }
        ?>
        <meta charset="utf-8"/>
        <link rel="shortcut icon" type="x-icon" href="pictures/logo_small_icon_only.png"/>
        <title>
            Your Requests
        </title>
    </head>
    <body class="bg">
        <div class="face">
            <div class="mail-icon" onclick="showMessages('messageBox')">
                <image src="pictures/mail_icon.png" style="height: 90"/>
            </div>
            <div class="notification">
                <?php
                    $id = $_SESSION['id'];
                    $countNewNews = $pdo->prepare("SELECT COUNT(`N_ID`) as `number` FROM `news` WHERE `For` = '$id' AND `Seen` = 'NO';");
                    $countNewNews->execute();
                    $result = $countNewNews->fetch();
                    $text = $result['number'];
                    echo("<p class='number' id='number'> $text </p>")

                ?>
            </div>
            <div class="programmer-bar">
                <ul>
                    <li class="programmers">
                        <a class="list-face">
                            Programmer
                        </a>
                        <ul>
                            <?php
                                $allProgrammers = getAllProgrammers();
                                foreach ($allProgrammers as $programmer) {
                                    $pid = $programmer->getPid();
                                    $status = $programmer->getStatus();
                                    $mail = $programmer->getEmail();
                                    $username = $programmer->getUsername();
                                    $uid = $programmer->getId();

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
                                    Design
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
                                foreach ($allProgrammers as $programmer) { 
                                    $mail = $programmer->getEmail();
                                    $name = $programmer->getUsername();
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
                <div class="all-requests" id="allRequests" style="display: flex">
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
                        $iconSpaceTop = 300;
                        $allRequests = getAllRequests();
                        foreach ($allRequests as $request) {
                            $rid = $request->getRid();
                            $requestedBy = $request->getRequestedBy();
                            $workingOn = $request->getWorkingOn();
                            $topic = $request->getTopic();
                            $type = $request->getType();
                            $requestedOn = $request->getRequestedOn();
                            $deadline = $request->getDeadline();
                            $status = $request->getStatus();
                            if ($status != "DONE" && $requestedBy == $_SESSION['id'] ) {

                                foreach ($allProgrammers as $programmer) { 
                                    if ($programmer->getPid() == $workingOn) {
                                        $pName = $programmer->getUsername();
                                    }

                                    if ($workingOn == NULL) {
                                        $pName = "None";
                                    }
                                }
                                $iconSpaceTop += 100;
                                echo("
                                    <tr>
                                        <td class='requester'> <a style='width=100%; height=100%; color: white;' href=mailto:''> $pName </a> </td>
                                        <td> $topic </td>
                                        <td> $type </td>
                                        <td> $requestedOn </td>
                                        <td> $deadline </td>
                                        <td> $status </td>
                                        <td>
                                            <div class='edit-icon' id='editIcon'>
                                                <image class='icon-img' src='pictures/edit_icon.png' onclick='editRequest($rid)'/>
                                                <image class='icon-img' src='pictures/delete-icon.png' onclick='deleteRequest($rid)'/>
                                            </div>
                                        </td>
                                    </tr>
                                ");
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
                        $allRequests = getAllRequests();
                        foreach ($allRequests as $request) {
                            $rid = $request->getRid();
                            $requestedBy = $request->getRequestedBy();
                            $workingOn = $request->getWorkingOn();
                            $topic = $request->getTopic();
                            $type = $request->getType();
                            $requestedOn = $request->getRequestedOn();
                            $deadline = $request->getDeadline();
                            $status = $request->getStatus();

                            foreach ($allProgrammers as $programmer) { 
                                if ($programmer->getPid() == $workingOn) {
                                    $pName = $programmer->getUsername();
                                }
                            }

                            if ($status == "DONE" && $requestedBy == $_SESSION['id'] ) {
                                echo("
                                    <tr>
                                        <td id='' class='requester'> <a style='width=100%; height=100%;' href=mailto:''> $pName </a> </td>
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
                                <input type='radio' id='Design' name='type' value='Design'/>
                                <label class='radio-label' for='Design'>Design</label><br>
                                <input type='radio' id='Game' name='type' value='Game'/>
                                <label class='radio-label' for='Game'>Game</label><br>
                                <input type='radio' id='Database' name='type' value='Database'/>
                                <label class='radio-label' for='Database'>Database</label><br>
                                <input type='radio' id='Other' name='type' value='Other'/>
                                <label class='radio-label' for='Other'>Other</label><br>
                                <input class= 'radio-label' type='date' id='Date' name='deadline'/><br>
                                <input type='submit' value='Create Request'/> 
                            ");
                                if (isset($_GET['type']) && isset($_GET['topic']) && isset($_GET['deadline']) && isset($_SESSION['id'])) {
                                    $type = $_GET['type'];
                                    $topic = $_GET['topic'];
                                    $deadline = $_GET['deadline'];
                                    $userId = $_SESSION['id'];
                                    $sqlCreateRequest = $pdo->prepare("INSERT INTO `requests`(`Requested_by`, `Topic`, `Type`, `Deadline`) VALUES ('$userId', '$type', '$topic', '$deadline')");
                                    $sqlCreateRequest->execute();
                                    $ip=$GLOBALS['ip'];

                                    echo ("<script> self.location = 'http://$ip/requestCustomer.php' </script>");
                                }
                            ?>
                        </form>
                    </div>          
                </div>
                <div class="message-box" id="messageBox">
                    <div class="mb-head">
                        <div onclick="closeMessageBox('messageBox')">
                            X 
                        </div>
                    </div>
                    <div class="message-window">
                        <div>
                            <table class='request-table' id='request-table'>
                                <thead>
                                    <tr>
                                        <th> From </th>
                                        <th> Message </th>
                                        <th> Date </th>
                                        <th> Seen </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $curentUser = $_SESSION['id'];
                                $getAllNewNews = $pdo->prepare("SELECT `user`.`Username` as 'From', `news`.`Type` as 'Message', `news`.`Date_of_Creation` as 'Date', `news`.`N_ID` as 'ID'
                                                            FROM `news` INNER JOIN `user` ON `user`.`ID` = `news`.`Programmer` WHERE `news`.`For` = '$curentUser' AND `news`.`Seen` = 'NO';");
                                $getAllNewNews->execute() or die;
                                while ($message = $getAllNewNews->fetch()) {
                                    $from = $message['From'];
                                    $text = $message['Message'];
                                    $date = $message['Date'];
                                    $newsId = $message['ID'];
                                    echo("
                                    <tr>
                                        <td> $from </td>
                                        <td> $text </td>
                                        <td> $date </td>
                                        <td onclick='setSeenYes($newsId)'> NO </td>
                                    </tr>
                                    ");
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="popup" class="popup">
            <input type="date" id="newDeadline"/>
            <div class="popup-button" onclick="setRequestDate()"> Submit </div>
        </div>
    </body>
</html>