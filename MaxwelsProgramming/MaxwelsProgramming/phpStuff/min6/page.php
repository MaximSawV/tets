<html>
    <?php
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
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
                        echo("<h1>Spruch des Tages</h1>");
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
    </div>
    </body>
</html>