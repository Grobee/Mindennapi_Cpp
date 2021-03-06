<?php
/**
 * @author Birkás Tamás
 * @author Gulyás Róbert
 * Date: 10/26/2014
 * Time: 8:42 PM

 */

/* This login page returns the login request to itself */
require_once('dbconfig.php');

/* Check does the user already logged in */
session_start();
if (isset($_SESSION["session_use"]))
    if ($_SESSION["session_use"] == 1)
        header("Location:adminpanel.php");

/* This part gets the username and password from its form */
if (isset($_POST['username'])) {
    $username = $_POST['username'];
}
if (isset($_POST['pass'])) {
    $pass = $_POST['pass'];
}

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Bejelentkezés</title>
    <link rel="shortcut icon" href="images/logo_tab.png"/>
    <link rel="stylesheet" href="style/style.css"/>
    <link rel="stylesheet" href="style/login.css"/>
</head>
<body>
<form method="post" action="login.php">
    <div id="container">
        <!-- HEADER -->
        <div id="header">
            <div id="innerheader" class="sitecenter">
                <img src="images/logo_small.png" width="100" height="75" alt="logo"/>
            </div>
        </div>
        <table id="logintable" cellpadding="5" align="center">
            <tr>
                <td><label>Felhasználónév:</label></td>
                <td><input class="input_login_text" type="text" name="username" size="25" maxlength="30"></td>
            </tr>
            <tr>
                <td align="right"><label>Jelszó:</label></td>
                <td><input class="input_login_text" type="password" name="pass" size="25" maxlength="30"></td>
            </tr>
        </table>

        <div id="loginbutton">
            <input class="input_button" type="submit" name="login" value="Bejelentkezés">

        </div> <?php
        /* Check does the username password combo exist, and redirects to the adminpanel page */
        if (isset($username) && isset($pass)) {
            $salt = "vts";

            $username = $sql->escape_string($username);
            $pass = $sql->escape_string($pass);
            $result = $sql->query("SELECT passwd FROM members m INNER JOIN administrators a ON m.id_member = a.id_member WHERE m.username = '$username'");
            /* see if there is a match */
            if ($result->num_rows > 0) {
                $name = $result->fetch_assoc();
                if (md5($salt . $pass . $salt) == $name['passwd']) {

                    session_start();
                    $_SESSION['username'] = $username;

                    $_SESSION['pass'] = md5($salt . $pass . $salt);
                    $_SESSION['session_use'] = 1;

                    header("Location:adminpanel.php");

                } else {
                    echo "<div id='failure' class='fail'>Hibás felhasználónév vagy jelszó</div>\n";

                }
            } else {
                echo "<div id='failure' class='fail'>Hibás felhasználónév vagy jelszó</div>\n";

            }
        }

        ?>


    </div>
</form>
<!--SITE CONTENT END-->
<div id="footer">
    <div id="innerfooter">Copyright @ 2014<br/><i>Group 3 TEAM</i></div>
</div>
</body>
</html>
