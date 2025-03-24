<?php

function gettotal($total, $totalcompare, $tipe)
{
    $checkorder = $total - $totalcompare;
    if ($checkorder < 0) {
        $selisihorder = $checkorder * -1;
        if ($total == 0) {
            if ($tipe == 'orders') {
                $return['label'] = "-";
            } else if ($tipe == 'pickups') {
                $return['label'] = "-";
            } else if ($tipe == 'customers') {
                $return['label'] = "active";
            }
            $return['color'] = "success";
        } else {
            if ($tipe == 'orders') {
                $return['label'] = "decrease";
            } else if ($tipe == 'pickups') {
                $return['label'] = "decrease";
            } else if ($tipe == 'customers') {
                $return['label'] = "active";
            }
            $return['color'] = "danger";
        }
    } else {
        $selisihorder = $checkorder;
        if ($tipe == 'orders') {
            $return['label'] = "increase";
        } else if ($tipe == 'pickups') {
            $return['label'] = "increase";
        } else if ($tipe == 'customers') {
            $return['label'] = "active";
        }
        $return['color'] = "success";
    }
    if ($total == 0) {
        $return['percent'] = 0;
    } else {
        $val = ((($selisihorder) / $total) * 100);
        if (is_numeric($val) && floor($val) != $val) {
            $return['percent'] = number_format($val, 2, '.', '');
        } else {
            $return['percent'] =  $val;
        }
    }
    //die('((' . $selisihorder . ') / ' . $total . ') * 100');
    return $return;
}


function getdetailorder($id, $conn)
{
    $getdata = mysqli_query($conn, "SELECT  a.*,b.name sername
                                    FROM tx_orders_d a 
                                    left join services b on a.services_id=b.id 
                                    where orders_id='" . $id . "'
                            ");
    $numdata = mysqli_num_rows($getdata);
    $rows = mysqli_fetch_all($getdata, MYSQLI_ASSOC);
    return $rows;
}

$getdata = mysqli_query($conn, " SELECT 
                                (SELECT count(*) from tx_orders where date(created_at) = curdate() and deleted_at is null) as totalorders,
                                (SELECT count(*) from tx_orders where date(created_at) = SUBDATE(CURDATE(), INTERVAL 1 DAY) and deleted_at is null) as totalorderstomorow,
                                (SELECT ifnull(sum(total),0) from tx_orders where date(created_at) = curdate() and deleted_at is null) as totalearns,
                                (SELECT ifnull(sum(total),0) from tx_orders where date(created_at) = SUBDATE(CURDATE(), INTERVAL 1 DAY) and deleted_at is null) as totalearnstomorow,
                                (SELECT count(*) from customers where  deleted_at is null) as totalcustomers,
                                (SELECT count(*) from customers where  status='0' and deleted_at is null) as totalcustomersnotactive 
                                
                        ");
$numdata = mysqli_num_rows($getdata);
$rows = mysqli_fetch_all($getdata, MYSQLI_ASSOC);

$getdata_last10order = mysqli_query($conn, "SELECT  a.*,b.name cusname,DATE_FORMAT(a.created_at, '%H:%i:%s') timeorder
                                             FROM tx_orders a 
                                             left join customers b on a.customers_id=b.id 
                                             where date(a.created_at) = curdate() and a.deleted_at is null 
                                             order by a.id desc limit 10");
$numdata_last10order = mysqli_num_rows($getdata_last10order);
$rows_last10order = mysqli_fetch_all($getdata_last10order, MYSQLI_ASSOC);


$getdata_last10pickup = mysqli_query($conn, "SELECT  a.*,b.name cusname,DATE_FORMAT(a.created_at, '%H:%i') timepickup
                                             FROM tx_pickups a 
                                             left join customers b on a.customers_id=b.id 
                                             where date(a.created_at) = curdate() and a.deleted_at is null 
                                             order by a.id desc limit 10");
$numdata_last10pickup = mysqli_num_rows($getdata_last10pickup);
$rows_last10pickup = mysqli_fetch_all($getdata_last10pickup, MYSQLI_ASSOC);

$getdata_top5service = mysqli_query($conn, "SELECT  a.*,(a.price * b.totalqty ) total ,b.totalsell,b.totalqty
                                             FROM services a 
                                             left join 
                                             (
                                                select count(id) totalsell,sum(qty) totalqty,services_id 
                                                from tx_orders_d 
                                                where date(created_at) = curdate() and deleted_at is null group by services_id 
                                              )
                                              b on b.services_id=a.id  
                                             where a.deleted_at is null 
                                             order by (a.price * b.totalqty ) desc limit 5");
$numdata_top5service = mysqli_num_rows($getdata_top5service);
$rows_top5service = mysqli_fetch_all($getdata_top5service, MYSQLI_ASSOC);
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Orders <span>| Today</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $rows[0]['totalorders']; ?></h6>
                                        <span class="text-<?= gettotal($rows[0]['totalorders'], $rows[0]['totalorderstomorow'], 'orders')['color']; ?> small pt-1 fw-bold"><?= gettotal($rows[0]['totalorders'], $rows[0]['totalorderstomorow'], 'orders')['percent']; ?>%</span> <span class="text-muted small pt-2 ps-1"><?= gettotal($rows[0]['totalorders'], $rows[0]['totalorderstomorow'], 'orders')['label']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->
                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Revenue <span>| Today</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= number_format($rows[0]['totalearns']); ?></h6>
                                        <span class="text-<?= gettotal($rows[0]['totalearns'], $rows[0]['totalearnstomorow'], 'pickups')['color']; ?> small pt-1 fw-bold"><?= gettotal($rows[0]['totalearns'], $rows[0]['totalearnstomorow'], 'pickups')['percent']; ?>%</span> <span class="text-muted small pt-2 ps-1"><?= gettotal($rows[0]['totalearns'], $rows[0]['totalearnstomorow'], 'pickups')['label']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Revenue Card -->
                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">
                        <div class="card info-card customers-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Customers <span>| All</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $rows[0]['totalcustomers']; ?></h6>
                                        <span class="text-<?= gettotal($rows[0]['totalcustomers'], $rows[0]['totalcustomersnotactive'], 'customers')['color']; ?> small pt-1 fw-bold"><?= gettotal($rows[0]['totalcustomers'], $rows[0]['totalcustomersnotactive'], 'customers')['percent']; ?>%</span> <span class="text-muted small pt-2 ps-1"><?= gettotal($rows[0]['totalcustomers'], $rows[0]['totalcustomersnotactive'], 'customers')['label']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Customers Card -->
                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Last 10 Orders <span>| Today</span></h5>
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Service</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Time Order</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $n = 1;
                                        foreach ($rows_last10order as $row10order) { ?>
                                            <tr>
                                                <th scope="row"><a href="#">#<?= $n++; ?></a></th>
                                                <td><?= $row10order['cusname']; ?></td>
                                                <td>
                                                    <?php
                                                    foreach (getdetailorder($row10order['id'], $conn) as $rowd) {
                                                    ?>
                                                        <span class="badge bg-primary"><?= $rowd['sername']; ?></span>
                                                    <?php } ?>
                                                </td>
                                                <td>Rp. <?= number_format($row10order['total']); ?></td>
                                                <td><?= $row10order['timeorder']; ?></td>
                                                <td>
                                                    <?php if ($row10order['status'] > 0) { ?>
                                                        <span class="badge bg-success">Pickup</span>
                                                    <?php } else { ?>
                                                        <span class="badge bg-warning">Pending</span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- End Recent Sales -->

                    <!-- Top Selling -->
                </div>
            </div><!-- End Left side columns -->
            <!-- Right side columns -->
            <div class="col-lg-4">
                <!-- Recent Activity -->
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Last 10 Pickups <span>| Today</span></h5>
                        <div class="activity">
                            <?php
                            $n = 1;
                            foreach ($rows_last10pickup as $row10pickup) { ?>
                                <div class="activity-item d-flex">
                                    <div class="activite-label fw-bold"><?= $row10pickup['timepickup']; ?></div>
                                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                    <div class="activity-content ">
                                        <span class="fw-bold text-primary"><?= $row10pickup['cusname']; ?></span> - note : <?= $row10pickup['notes']; ?>
                                    </div>
                                </div><!-- End activity item-->
                            <?php } ?>
                        </div>
                    </div>
                </div><!-- End Recent Activity -->
                <!-- Budget Report -->
                <div class="col-12">
                    <div class="card top-selling overflow-auto">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>
                        <div class="card-body pb-0">
                            <h5 class="card-title">Top 5 Services <span>| Today</span></h5>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Service</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Orders</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $n = 1;
                                    foreach ($rows_top5service as $rowtop5service) { ?>
                                        <tr>
                                            <td><a href="#" class="text-primary fw-bold"><?= $rowtop5service['name']; ?></a></td>
                                            <td>Rp. <?= number_format($rowtop5service['price']); ?></td>
                                            <td class="fw-bold text-center"><?= number_format($rowtop5service['totalsell']); ?></td>
                                            <td class="fw-bold text-center"><?= number_format($rowtop5service['totalqty']); ?></td>
                                            <td>Rp. <?= number_format($rowtop5service['total']); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- End Top Selling -->
            </div><!-- End Right side columns -->

        </div>
    </section>

</main><!-- End #main -->