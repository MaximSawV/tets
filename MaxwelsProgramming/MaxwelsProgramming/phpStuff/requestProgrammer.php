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
    <body class="bg" id="body">
        <div class="face">
            <div class="programmer-bar">
                <ul>
                    <li class="programmers">
                        <a class="list-face">
                            Programmer
                        </a>
                        <ul id="programmer-chart">
                             <?php
                                $user = $_GET['user'];
                                for ($i = 0; $i < (count($allProgrammers)); $i++) {
                                    $pid = $allProgrammers[$i]->getPid();
                                    $name = $allProgrammers[$i]->getFirstName();
                                    $status = $allProgrammers[$i]->getStatus();
                                    $mail = $allProgrammers[$i]->getEmail();
                                    $username = $allProgrammers[$i]->getUsername();
                                    $uid = $allProgrammers[$i]->getId();
                                    if($uid != $_GET['user']) {
                                        if ($status == "AVAILABLE") {
                                        echo ("<li> <a href='mailto:$mail' id='you' class='programmer-icon' style='background-color: #00ff00'> $name is $status </a></li>");
                                        }

                                        if ($status == "BUSY") {
                                            echo ("<li> <a id='you' class='programmer-icon' style='background-color: #ff0000'> $name is $status </a></li>");
                                        }
                                    } else {
                                        global $userstatus;
                                        $userstatus = $status;
                                    }
                                }
                            ?>
                        </ul>
                    </li>
                    <li class="programm-theme">
                        <a class="list-face">
                            Programms
                        </a>
                        <ul id="programms">
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
                        <form class="search-field">
                            <input class="type-field" type="text" placeholder="Name/Mail/ID..."/>
                            <input class="search-button" type="submit" value="🔎"/>
                        </form>
                    </li>
                    <li class="help">
                        <a href="mailto:maxwels.contacts@gmail.com" class="list-face">
                            ?
                        </a>
                    </li>
                    <?php
                        $user = $_GET['user'];
                        echo("
                    <li style='width: 40%;'>
                        <a id='busy' class='list-face' onclick='setBusy(`$user`)' style='color: #ff0000; display: flex;'>
                            BUSY
                        </a>
                        <a id='available' class='list-face' onclick='setAvailable(`$user`)' style='color: #00ff00; display: flex;'>
                            AVAILABLE
                        </a>
                    </li>
                    ");
                    ?>
                </ul>
            </div>
            <div class="request-bar">
                <ul>
                    <li class="request-list">
                        <a class="list-face" onclick="showAll2()">
                            Show all
                        </a>
                    </li>
                    <li class="add-request">
                        <a class="list-face" onclick="myRequests()">
                            Work in progress
                        </a>
                    </li>
                    <li class="done-requests">
                        <a class="list-face" onclick="showDone2()">
                            Done
                        </a>
                    </li>
                    <li class="done-requests">
                        <a class="list-face" onclick="showColorPicker()">
                            Color
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
                                        <th> Requested by </th>
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

                            if ($status == "REQUESTED") {
                                echo("
                                    <tr>
                                        <td class='requester'> <a style='width=100%; height=100%;' href=mailto:''> $requestedBy </a> </td>
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
                <!--------------------------------------------------------------------------------------->
                <div class="all-requests" id="myRequests">
                    <?php

                        echo( "
                            <table class='request-table' id='request-table'>
                                <thead>
                                    <tr>
                                        <th> Requested by </th>
                                        <th> Topic </th>
                                        <th> Type </th>
                                        <th> Requested on </th>
                                        <th> Deadline </th>
                                        <th> Status </th>
                                    </tr>
                                </thead>
                                <tbody>
                        ");

                        for ($i = 0; $i < count($allProgrammers); $i++) {
                            if ($allProgrammers[$i]->getUsername() == $_GET['user']);{
                                for ($i2 = 0; $i2 < count($allRequests); $i2++) {
                                    $rid = $allRequests[$i2]->getRid();
                                    $requestedBy = $allRequests[$i2]->getRequestedBy();
                                    $workingOn = $allRequests[$i2]->getWorkingOn();
                                    $topic = $allRequests[$i2]->getTopic();
                                    $type = $allRequests[$i2]->getType();
                                    $requestedOn = $allRequests[$i2]->getRequestedOn();
                                    $deadline = $allRequests[$i2]->getDeadline();
                                    $status = $allRequests[$i2]->getStatus();

                                    if ($status == "IN PROGRESS" && $workingOn == $_GET['user']) {
                                    
                                        echo("
                                            <tr>
                                                <td class='requester'> <a style='width=100%; height=100%;' href=mailto:''> $requestedBy </a> </td>
                                                <td> $topic </td>
                                                <td> $type </td>
                                                <td> $requestedOn </td>
                                                <td> $deadline </td>
                                                <td> $status </td>
                                            </tr>"
                                        );
                                    }
                                }
                            }
                            break;
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
                                        <th> Requested by </th>
                                        <th> Topic </th>
                                        <th> Type </th>
                                        <th> Satisfied </th>
                                    </tr>
                                </thead>
                                <tbody>
                        ");

                        for ($i = 0; $i < count($allProgrammers); $i++) {
                            if ($allProgrammers[$i]->getUsername() == $_GET['user']);{
                                for ($i2 = 0; $i2 < count($allRequests); $i2++) {
                                    $rid = $allRequests[$i2]->getRid();
                                    $requestedBy = $allRequests[$i2]->getRequestedBy();
                                    $workingOn = $allRequests[$i2]->getWorkingOn();
                                    $topic = $allRequests[$i2]->getTopic();
                                    $type = $allRequests[$i2]->getType();
                                    $requestedOn = $allRequests[$i2]->getRequestedOn();
                                    $deadline = $allRequests[$i2]->getDeadline();
                                    $status = $allRequests[$i2]->getStatus();
                                    $satisfaction = $allRequests[$i2]->getSatisfied();

                                    if ($status == "DONE" && $workingOn == $_GET['user']) {
                                    
                                        echo("
                                            <tr>
                                                <td class='requester'> <a style='width=100%; height=100%;' href=mailto:''> $requestedBy </a> </td>
                                                <td> $topic </td>
                                                <td> $type </td>
                                                <td> $satisfaction </td>
                                            </tr>"
                                        );
                                    }
                                }
                            }
                            break;
                        }
                        echo("
                                </tbody>
                            </table>
                        ");
                        
                    ?>
                </div>
                <div id="colorPickerMenu" class="colorPickerWindow" style="background: linear-gradient(to bottom, #0c2436 0%,#84cafe 100%);">
                    <div class="color-preview">
                        <div id="green2" style="background: rgb(0, 255, 0)">
                            <label for="green"> Green </label>
                        </div>
                        
                        <div id="red2" style="background: rgb(255, 0, 0)">
                            <label for="red"> Red </label>
                        </div>

                        <div id="blue2"  style="background: rgb(0, 0, 255)">
                            <label for="blue"> Blue </label>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: row;">
                        <div style="display: flex; flex-direction: column;" >
                            <div class="color-picker">
                                <input id="green" onchange="changeColor(1)" name="green" type="range" min="0" max="255" value="255"/>
                                <input id="red" onchange="changeColor(2)" name="red" type="range" min="0" max="255" value="255"/>
                                <input id="blue" onchange="changeColor(3)" name="blue" type="range" min="0" max="255" value="255"/>
                            </div>
                            <div id="color1" onclick="selectColor('color1')" class="color-field" style="border: black solid 2px;"> Color1</div>
                            <div id="color2" onclick="selectColor('color2')" class="color-field" style="border: black solid 2px;"> Color2 </div>
                        </div>
                        <div class="submit-color-change" onclick="submitColorChange()">
                            Submit
                        </div>
                    </div>
                </div>
            </div>
        <?php
            if ($userstatus == "AVAILABLE") {
                $color = "#00ff00";
                $cord ="2400px";
            } else {
                $color = "#ff0000";
                $cord ="1970px";
            }
            echo("
            <span id='indicator' class='status-indicator' style='background: $color; left: $cord';>

            </span>
            ");
        ?>
        </div>
    </body>
</html>