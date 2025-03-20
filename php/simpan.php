<?php
session_start();
include('connect.php');

if (isset($_POST)) {
    $mode = $_POST['mode'];
    if (in_array($_POST['tipe'], ['pickups'])) { //for transaction table
        $tipe = 'tx_' . $_POST['tipe'];
    } else {
        $tipe = $_POST['tipe'];
    }
    if ($mode == 'Add') {
        $field = '';
        $isi = '';
        $no = 1;
        // var_dump($_POST);
        // die();
        foreach ($_POST as $indexname => $rows) {
            if (!in_array($indexname, ['tid', 'mode', 'tipe'])) {
                if ($no == 1) {
                    $field .= "`" . $indexname . "`";
                    $isi .= "'" . $_POST[$indexname] . "'";
                } else {
                    // die($rows);
                    $field .= ",`" . $indexname . "`";
                    $isi .= ",'" . $_POST[$indexname] . "'";
                }
                $no++;
            }
        }
        $field_opt = "";
        $isi_opt = "";
        if ($tipe == 'users') {
            $field_opt = ",password";
            $isi_opt = ", sha1('" . $_POST['email'] . "')";
        }
        // var_dump("INSERT INTO " . $tipe . " (" . $field . " " . $field_opt . ") VALUES (" . $isi . " " . $isi_opt . ")");
        // die();

        $runsql = mysqli_query($conn, "INSERT INTO " . $tipe . " (" . $field . " " . $field_opt . ") VALUES (" . $isi . " " . $isi_opt . ")");
    }
    if ($mode == 'Edit') {
        $tid = $_POST['tid'];
        $set = '';
        $no = 1;
        foreach ($_POST as $indexname => $rows) {
            if (!in_array($indexname, ['tid', 'mode', 'tipe'])) {
                if ($no == 1) {
                    $set .= "`" . $indexname . "` = '" . $_POST[$indexname] . "'";
                } else {
                    $set .= ",`" . $indexname . "`  = '" . $_POST[$indexname] . "'";
                }
                $no++;
            }
        }
        $runsql = mysqli_query($conn, "UPDATE " . $tipe . "  SET " . $set . "  WHERE id='" . $tid . "'");
    }


    if ($runsql) {
        if ($_POST['tipe'] == 'pickups' && $mode == 'Add') {
            $oderupdate = mysqli_query($conn, "UPDATE tx_orders  SET status='1'  WHERE id='" . $_POST['orders_id'] . "'");
            $oderdetailupdate = mysqli_query($conn, "UPDATE tx_orders_d  SET status='1'  WHERE orders_id='" . $_POST['orders_id'] . "'");
        }
        $json['status'] = 1;
    } else {
        $json['status'] = 0;
    }

    echo json_encode($json);
}
