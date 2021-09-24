<html>
    <?php
        date_default_timezone_set('Europe/Amsterdam');
        $servername = "db";
        $username = "maxim";
        $password = "maxim_password";
        $dbname ="6min";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    ?>
    <head>
        <link rel="stylesheet" href="style.css"/>
        <script src="script.js"></script>
        <meta charset="utf-8"/>
        <title> 6min </title>
    </head>
    <body>
        <div>
            <div class="cover" id="cover" onclick="decover('cover')">
                <script> createGreetingCover() </script>
            </div>
            <div class ="header">
                <div class="menu-button">
                    Menü
                </div>
                <div class="head">
                    <p id="greeting2"></p>
                    <script> setGreeting() </script>
                </div>
            </div>
            <div class="body">
                <div class="text-field">
                    <?php
                        $day = date("l");
                        $sqlGetWeekday = $conn->query("SELECT `Quote` as quote FROM `Quote_of_the_day` WHERE `Day_of_week` = '$day'");
                        $row = $sqlGetWeekday -> fetch_assoc();
                        $quote = $row['quote'];
                        echo("<h1>$quote</h1>");
                    ?>
                </div>
                <div class="counter-field">
                    <?php
                        echo("<h1>T W M J</h1>");
                    ?>
                </div>
                <div class="task-field">
                    <?php
                        echo("<h1>Spruch des Tages</h1>");
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>