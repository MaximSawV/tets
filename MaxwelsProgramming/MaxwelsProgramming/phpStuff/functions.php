<?php

function login () {
    if (isset($_SESSION['user']) && isset($_SESSION['login-password'])) {
        $_POST['user'] = $_SESSION['user'];
        $_POST['login-password'] = $_SESSION['login-password'];

        for ($i = 0; $i < count($allUsers); $i++) {
            $id = $allUsers[$i]->getId();
            $user = $allUsers[$i]->getUsername();
            $email = $allUsers[$i]->getEmail();
            $password2 = $allUsers[$i]->getPassword();

            if ($name == $user && $password == $password2) {
                echo('<script>loginOut()</script>');
                $loggedIn = $id;
                $test = 2;
            }
        }

        if ($test == 2 ) {
            return $loggedIn;
        } else {
            echo('<script/>logout()</script>');
            http_response_code(400);
        }
    } else {
        $loggedIn = 0;
        return $loggedIn;
    }
}

?>