<?php
session_start();
require_once('connect.php');

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $login = mysqli_query($conn, "SELECT a.*,b.name `level` from users a left join levels b on a.level_id=b.id where a.email = '" . $email . "' and a.password = sha1('" . $password . "')");
    if ($login) {
        $numrow = mysqli_num_rows($login);
        if ($numrow > 0) {
            $rows = mysqli_fetch_assoc($login);
            $_SESSION['login'] = 1;
            $_SESSION['email'] = $email;
            $_SESSION['level_id'] = $rows['level_id'];
            $_SESSION['level'] = $rows['level'];
            $_SESSION['status'] = $rows['status'];
            $_SESSION['fullname'] = $rows['name'];
            // if (empty($rows['photoprofile']) || $rows['photoprofile'] == '' || $rows['photoprofile'] == null) {
            //     $_SESSION['photoprofile'] = '../uploads/profile/noprofile.png';
            // } else {
            //     $_SESSION['photoprofile'] =  $rows['photoprofile'];
            // }
            $_SESSION['userid'] = $rows['id'];
            $_SESSION['photoprofile'] = 'uploads/profile/noprofile.png';
            $json['login_status'] = 1;
        } else {
            $_SESSION['login'] = 0;
            $json['message'] = 'Email atau password salah!';
            $json['login_status'] = 0;
        }
    } else {
        $_SESSION['login'] = 0;
        $json['message'] = 'Email atau password salah!';
        $json['login_status'] = 0;
    }
} else {
    $_SESSION['login'] = 0;
    $json['message'] = 'Error, Undifined Email & Password';
    $json['login_status'] = 0;
}
echo json_encode($json);
