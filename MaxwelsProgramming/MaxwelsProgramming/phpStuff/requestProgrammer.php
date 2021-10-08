<?php
    session_start();
?>
<html>
    <head>
        <?php
            require_once("php-function/db_connect.php");
            require_once("php-function/class.php");
            $loggedIn = 0;
            $version = rand(0,999999999) + rand(0,999999999);
            echo("<link rel='stylesheet' href='phpstyle.css?v=$version'/>
                <script src='php-website-code.js?v=$version'></script>
            ");
        ?>
        <meta charset="utf-8"/>
        <link rel="shortcut icon" type="x-icon" href="pictures/logo_small_icon_only.png"/>
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
                                $allProgrammers = getAllProgrammers();
                                foreach ($allProgrammers as $programmer) {
                                    $pid = $programmer->getPid();
                                    $name = $programmer->getFirstName();
                                    $status = $programmer->getStatus();
                                    $mail = $programmer->getEmail();
                                    $username = $programmer->getUsername();
                                    $uid = $programmer->getId();
                                    if($uid != $_SESSION['id']) {
                                        if ($status == "AVAILABLE") {
                                        echo ("<li> <a href='mailto:$mail' id='you' class='programmer-icon' style='background-color: #00ff00; color: black;'> $username is $status </a></li>");
                                        }

                                        if ($status == "BUSY") {
                                            echo ("<li> <a id='you' class='programmer-icon' style='background-color: #ff0000; color: black;'> $username is $status </a></li>");
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
                    </li>
                    <?php
                        echo("
                    <li style='width: 40%;'>
                        <a id='busy' class='list-face' onclick='setBusy()' style='color: #ff0000; display: flex;'>
                            BUSY
                        </a>
                        <a id='available' class='list-face' onclick='setAvailable()' style='color: #00ff00; display: flex;'>
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
                        $iconSpaceTop = 300;
                        $allRequests = getAllRequests();
                        $allUsers = getAllUsers();
                        foreach ($allRequests as $request) {
                            $rid = $request->getRid();
                            $requestedBy = $request->getRequestedBy();
                            $workingOn = $request->getWorkingOn();
                            $topic = $request->getTopic();
                            $type = $request->getType();
                            $requestedOn = $request->getRequestedOn();
                            $deadline = $request->getDeadline();
                            $status = $request->getStatus();

                            foreach ($allUsers as $user) {
                                if ($requestedBy == $user->getId()) {
                                    $uName = $user->getUsername();
                                }
                            }

                            if ($status == "REQUESTED" && $workingOn == null) {
                                $iconSpaceTop += 100;
                                echo("
                                    <tr>
                                        <td class='requester'> <a style='width=100%; height=100%;' href=mailto:''> $uName </a> </td>
                                        <td> $topic </td>
                                        <td> $type </td>
                                        <td> $requestedOn </td>
                                        <td> $deadline </td>
                                        <td> $status </td>
                                        <td>
                                            <div class='edit-icon' id='editIcon'>
                                                <image class='icon-img' src='pictures/submitbutton.png' onclick='takeRequest($rid)'/>
                                            </div>
                                        </td>
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
                        $allRequests = getAllRequests();
                        foreach ($allProgrammers as $programmer) {
                            if ($programmer->getId() == $_SESSION['id']);{
                                foreach ($allRequests as $request) {
                                    $rid = $request->getRid();
                                    $requestedBy = $request->getRequestedBy();
                                    $workingOn = $request->getWorkingOn();
                                    $topic = $request->getTopic();
                                    $type = $request->getType();
                                    $requestedOn = $request->getRequestedOn();
                                    $deadline = $request->getDeadline();
                                    $status = $request->getStatus();

                                    foreach ($allUsers as $user) {
                                        if ($requestedBy == $user->getId()) {
                                            $uName = $user->getUsername();
                                        }
                                    }

                                    if ($status == "IN PROGRESS" && $workingOn == $_SESSION['id']) {
                                    
                                        echo("
                                            <tr>
                                                <td class='requester'> <a style='width=100%; height=100%;' href=mailto:''> $uName </a> </td>
                                                <td> $topic </td>
                                                <td> $type </td>
                                                <td> $requestedOn </td>
                                                <td> $deadline </td>
                                                <td> $status </td>
                                                <td>
                                                    <div class='edit-icon' id='editIcon'>
                                                        <image class='icon-img' src='pictures/submitbutton.png' onclick='setRequestDone($rid)'/>
                                                    </div>
                                                </td>
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
                        $allRequests = getAllRequests();
                        foreach ($allProgrammers as $programmer) {
                            if ($programmer->getId() == $_SESSION['id']);{
                                foreach ($allRequests as $request) {
                                    $rid = $request->getRid();
                                    $requestedBy = $request->getRequestedBy();
                                    $workingOn = $request->getWorkingOn();
                                    $topic = $request->getTopic();
                                    $type = $request->getType();
                                    $requestedOn = $request->getRequestedOn();
                                    $deadline = $request->getDeadline();
                                    $status = $request->getStatus();
                                    $satisfaction = $request->getSatisfied();

                                    foreach ($allUsers as $user) {
                                        if ($requestedBy == $user->getId()) {
                                            $uName = $user->getUsername();
                                        }
                                    }

                                    if ($status == "DONE" && $workingOn == $_SESSION['id']) {
                                    
                                        echo("
                                            <tr>
                                                <td class='requester'> <a style='width=100%; height=100%;' href=mailto:''> $uName </a> </td>
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
            foreach($allProgrammers as $programmer) {
                if($programmer->getId() == $_SESSION['id']) {
                    $userstatus = $programmer->getStatus();
                }
            }
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