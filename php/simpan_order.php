<?php
session_start();
include('connect.php');

if (isset($_POST)) {
    $mode = $_POST['mode'];
    $tipe = $_POST['tipe'];
    if ($mode == 'Add') {
        $field = '';
        $isi = '';
        $no = 1;
        // var_dump($_POST);
        // die();
        foreach ($_POST as $indexname => $rows) {
            if (!in_array($indexname, ['tid', 'mode', 'tipe', 'dataDetail'])) {
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

        // var_dump("INSERT INTO tx_orders (" . $field . " " . $field_opt . ") VALUES (" . $isi . " " . $isi_opt . ")");
        // die();

        $runsql = mysqli_query($conn, "INSERT INTO tx_orders (" . $field . " " . $field_opt . ") VALUES (" . $isi . " " . $isi_opt . ")");
    }
    if ($mode == 'Edit') {
        $tid = $_POST['tid'];
        $set = '';
        $no = 1;
        foreach ($_POST as $indexname => $rows) {
            if (!in_array($indexname, ['tid', 'mode', 'tipe', 'dataDetail'])) {
                if ($no == 1) {
                    $set .= "`" . $indexname . "` = '" . $_POST[$indexname] . "'";
                } else {
                    $set .= ",`" . $indexname . "`  = '" . $_POST[$indexname] . "'";
                }
                $no++;
            }
        }
        $runsql = mysqli_query($conn, "UPDATE tx_orders  SET " . $set . "  WHERE id='" . $tid . "'");
    }


    if ($runsql) {

        if ($mode == 'Add') {
            $last_id = $conn->insert_id;
        }
        if ($mode == 'Edit') {
            $last_id = $tid;
        }
        $dataDetail = $_POST['dataDetail'];
        $detaillist = json_decode($dataDetail);
        if (count($detaillist) > 0) {
            $getdata = mysqli_query($conn, "SELECT * FROM tx_orders_d WHERE orders_id='" . $last_id . "'"); //and a.id not in (1) administrator
            $checknum = mysqli_num_rows($getdata);
            if ($checknum > 0) {
                $delete =  mysqli_query($conn, "DELETE FROM tx_orders_d WHERE orders_id='" . $last_id . "'");
            }
            $noc = 1;
            $valuesins = '';
            foreach ($detaillist as $indexname => $rows) {
                $field2[$noc] = '';
                $isi2[$noc] = '';
                // mysqli_close($conn);
                $no = 1;
                foreach ($rows[0] as $index => $row) {
                    if (str_replace('' . $indexname . '', '', $index) == 'services_id') {
                        $res = explode("-", $row);
                        $row = $res[0];
                    }

                    if ($no == 1) {
                        $field2[$noc] .= "`" . str_replace('' . $indexname . '', '', $index) . "`";
                        $isi2[$noc] .= "'" . $row . "'";
                    } else {
                        // die($rows);
                        $field2[$noc] .= ",`" . str_replace('' . $indexname . '', '', $index) . "`";
                        $isi2[$noc] .= ",'" . $row . "'";
                    }
                    $no++;
                }

                // $valuesins  .= "('" . $last_id . "'," . $isi2[$noc] . ") ";

                // var_dump("INSERT INTO tx_orders_d 
                // (`orders_id`, " . $field2[$noc] . ") 
                //   VALUES 
                // ('" . $last_id . "'," . $isi2[$noc] . ")
                // ");

                $runsql_details = mysqli_query($conn, "INSERT INTO tx_orders_d  (`orders_id`, " . $field2[$noc] . ")  VALUES ('" . $last_id . "'," . $isi2[$noc] . ")");

                // $noc++;
            }
            // die();
        }
        $json['status'] = 1;
    } else {
        $json['status'] = 0;
    }

    echo json_encode($json);
}
