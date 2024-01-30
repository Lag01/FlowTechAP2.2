<?php
function login($user, $mdp)
{
    $ret = false;
    $cnx = connect_bd("nc231_flowtech");
    $st = $cnx->prepare("SELECT * FROM Utilisateur WHERE login=:user");
    $st->bindParam(":user", $user);
    $st->execute();
    $row = $st->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        if (password_verify($mdp, $row['pwd'])) {
            $_SESSION["user"] = $user;
            $ret = true;
        }
    }
    return $ret;
}

function logout()
{
    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("Location: ../connexion.php");
        exit();
    }
}

// function getMailLoggedOn()
// {
//     if (isLoggedOn()) {
//         $ret = $_SESSION["user"];
//     } else {
//         $ret = "";
//     }
//     return $ret;
// }