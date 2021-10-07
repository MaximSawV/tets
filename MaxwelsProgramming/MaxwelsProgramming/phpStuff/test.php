<?php
    ini_set('session.gc_maxlifetime', 86400);
    session_set_cookie_params(86400);
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
            $loggedIn = false;
            $version = rand(0,999999999) * rand(0,999999999);
            echo("<link rel='stylesheet' href='phpstyle.css?v=$version'/>
                    <script src='php-website-code.js'></script>
            ");

            include 'class.php';
            
            if (isset($_GET['logged'])) {
                if ($_GET['logged'] == "no") {
                    session_unset();
                    session_destroy();
                    echo('<script>logout(2)</script>');

                }
            }

            // $user = select * from user where Username = $login ["name"]
            //  wenn $user == null => dann login geht
            // wenn $user != null => Passwort prüfen

            if (isset($_SESSION['user']) && isset($_SESSION['login-password']) && isset($_SESSION['id'])) {
                for ($i = 0; $i < count($allUsers); $i++) {
                    $login = $allUsers[$i]->getLogin();
                    for ($i = 0; $i < count($allUsers); $i++) {
                        $user = $allUsers[$i]->getUsername();
                        $password = $allUsers[$i]->getPassword();

                        if ($login["name"] == $user && $login["password"] == $password) {
                            $loggedIn = true;
                        }
                    }
                }
            }
        ?>
        <title>
            Maxwels
        </title>
        <link rel="shortcut icon" type="x-icon" href="pictures/logo_small_icon_only.png"/>
        <meta charset="utf-8"/>
    </head>
    <body>
        <?php
            if(isset($_SESSION['user'])) {
                $user = $_SESSION['user'];
                echo("
                <div class='spacer'>
                    <p> Welcome $user </p>
                </div>
                ");
            }
        ?>
        <div class="easter-egg" id="eegg" onclick="eegg('eegg')">
            .
        </div>
        <div class="page">
            <ul class="side-menu" id="sideMenu">
                <?php
                    if ($loggedIn === false) {
                        echo('
                                <li class="login-field" id="loginField" style="display: none;">
                                    <form class="login" method:post;>
                                        <input type="text" placeholder="Username" name="user"/>
                                        <input type="password" placeholder="Password" name="login-password"/>
                                        <span class="log-buttons">
                                            <input type="submit" value="Login"/>
                                            <input type="button" value="Register" onclick="register()"/>
                                            <input type="button" value="Cancel" onclick="logout()"/>
                                            ');
                                                if (isset($_GET['user']) && isset($_GET['login-password'])) {
                                                    $user = $_GET['user'];
                                                    $password = $_GET['login-password'];
                                                    for ($i=0; $i < count($allUsers); $i++) { 
                                                        if ($user == $allUsers[$i]->getUsername() && $password == $allUsers[$i]->getPassword()) {
                                                            $_SESSION['user'] = $allUsers[$i]->getUsername();
                                                            $_SESSION['login-password'] = $password;
                                                            $_SESSION['id'] = $allUsers[$i]->getId();
                                                            $loggedIn = true;
                                                            echo('<script> reload() </script>');
                                                        }
                                                    }

                                                    if ($loggedIn === false) {
                                                        session_unset();
                                                        echo('<script>logout(0)</script>');
                                                    }
                                                }
                                            echo("
                                        </span>
                                    </form>
                                </li>
                        ");
                    }
                ?>
                <li>
                    <a onclick="showLogin()" id="showLoginButton">
                        Login
                    </a>
                </li>
                <?php
                    if ($loggedIn === true ) {
                        $currentUser = $_SESSION['id'];
                        echo('<script>test()</script>');

                        $sqlTestIs = "SELECT `is` from `user` WHERE `ID` = '$currentUser';";
                        $TestIs = $conn->query($sqlTestIs);
                        while($row = mysqli_fetch_assoc($TestIs)) {
                            if($row["is"] == "Programmer" || $row["is"] == "Master") {
                                echo ("<li> <a href='http://localhost/requestProgrammer.php' target='_blank' id='request'> Requests </a> </li>");
                            }

                            if($row["is"] == "Customer") {
                                echo("<il> <a href='http://localhost/requestCustomer.php' target='_blank' id='request'> Requests </a> </li>");
                            }
                        }
                        echo('<li><a onclick="logout()"> Logout </a></li>');
                    }
                ?>
                <li>
                    <a href="#statistic">
                        About
                    </a>
                </li>
                <li>
                    <a href="#news">
                        News
                    </a>
                </li>
                <li>
                    <a href="#contacts">
                        Contacts
                    </a>
                </li>
                <li>
                    <button class="side-menu-button1" id="smButton2" onclick="closeSideMenu()">
                        X
                    </button>
                </li>
            </ul>

            <div class="header">
                <img id="websiteLogo" src="pictures/maxwel_cover(2).jpg" width="100%"/>
                <img style="top: 0" class="side-menu-button2" id="smButton" onclick="openSideMenu()" src="pictures/menu.png" height="50px" width="100px"/>
            </div>
            <div class="spacer">
                <p> Programmer you can trust! </p>
            </div>
            <div class="content">
                <div class="main-page">
                    <div class="statistic" id="statistic">

                        <div id="6" onclick="newsBlockOpen(6)" onmouseleave="newsBlockClose(6)">
                            <h1 id="60"> About Us </h1>
                            <p id ="61"> 
                                Text
                            </p>
                        </div>
                        
                        <div id="7" onclick="newsBlockOpen(7)" onmouseleave="newsBlockClose(7)">
                            <h1 id="70"> Requests</h1>
                            <?php
                                $sqlGetAllRequests = $conn->query("SELECT COUNT(*) as total FROM `requests`");
                                $row = $sqlGetAllRequests -> fetch_assoc();
                                $number = $row['total'];
                                echo('<p id=71>' . $number . ' Requests</p>');
                            ?>
                        </div>

                        <div id="8" onclick="newsBlockOpen(8)" onmouseleave="newsBlockClose(8)">
                            <h1 id="80"> Rating </h1>
                            <?php

                                $sqlGetAllRequests = $conn->query("SELECT COUNT(*) as total FROM `requests` WHERE `Status` = 'DONE'");
                                $row = $sqlGetAllRequests -> fetch_assoc();
                                $number = $row['total'];
                                $sqlGetAllRequests = $conn->query("SELECT COUNT(*) as total FROM `requests` WHERE `Satisfied` = 'YES'");
                                $row = $sqlGetAllRequests -> fetch_assoc();
                                $numberYes = $row['total'];
                                if($number + $numberYes > 1) {
                                    $rating=(round(($numberYes / $number)*100));
                                    echo("<p id='81'>$rating%  satisfaction rate </p>");
                                }else{
                                    echo("<p id='81'> No satisfaction rate </p>");
                                }
                            ?>
                        </div>
                    </div>
                    <div class="spacer">
                        <p> What happend and What will happen </p>
                    </div>
                    <div class="news-overlay">
                        <div class="news-container">
                            <div class="news" id="1" onclick="newsBlockOpen(1)" onmouseleave="newsBlockClose(1)">
                                <div class="news-panel">
                                    <img id="10" src="pictures/logo_icon_inverted.png" height="100px" width="100px"/>
                                    <h1> First Post </h1>
                                    <p id="11"> Text </p>
                                </div>
                            </div>

                            <div class="news" id="2" onclick="newsBlockOpen(2)" onmouseleave="newsBlockClose(2)">
                                <div class="news-panel">
                                    <img id="20" src="pictures/logo_icon_inverted.png" height="100px" width="100px"/>
                                    <h1> Second Post </h1>
                                    <p id="21"> Text </p>
                                </div>
                            </div>

                            <div class="news" id="3" onclick="newsBlockOpen(3)" onmouseleave="newsBlockClose(3)">
                                <div class="news-panel">
                                    <img id="30" src="pictures/logo_icon_inverted.png" height="100px" width="100px"/>
                                    <h1> Third Post </h1>
                                    <p id="31"> Text </p>
                                </div>
                            </div>

                            <div class="news" id="4" onclick="newsBlockOpen(4)"onmouseleave="newsBlockClose(4)">
                                <div class="news-panel">
                                    <img id="40" src="pictures/logo_icon_inverted.png" height="100px" width="100px"/>
                                    <h1> Fourth Post </h1>
                                    <p id="41"> Text </p>
                                </div>
                            </div>

                            <div class="news" id="5" onclick="newsBlockOpen(5)" onmouseleave="newsBlockClose(5)">
                                <div class="news-panel">
                                    <img id="50" src="pictures/logo_icon_inverted.png" height="100px" width="100px"/>
                                    <h1> Fifth Post </h1>
                                    <p id="51"> Text </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="spacer">
                <p> How You can contact me </p>
            </div>
            <div class="footer">
                <img src="pictures/smaller_icon.png" width="200" height="200" />
                <div class="contacts" id="contacts">
                    <p> Copyright © Maxwels 2021 </p>
                    <p> maxwels-programming@gmail.com </p>
                    <p> Tel: 2365/424523542625 </p>
                </div>
            </div>
        </div>
    </body>
</html>