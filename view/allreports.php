 <?php
    if (isset($_POST)) {
        if (isset($_POST['reporttype']) && $_POST['reporttype'] != '') {
            $reporttype = $_POST['reporttype'];
            $datefrom = $_POST['datefrom'];
            $dateto = $_POST['dateto'];

            if ($reporttype == '1') { //Orders
                $getdata = mysqli_query($conn, "SELECT a.*,case a.status when '1' then 'Puckup Done' else 'Waiting Pickup' end as statuslabel  
                                        ,b.name customername,DATE_FORMAT(a.date, '%W , %d %M %Y') dates
                                        ,DATE_FORMAT(a.end_date, '%W , %d %M %Y') end_dates 
                                         from tx_orders a 
                                         left join customers b on a.customers_id=b.id 
                                         where a.deleted_at is null and date(a.created_at) >= '" . $datefrom . "' and date(a.created_at) <= '" . $dateto . "'
                                         order by a.id desc");
            } else if ($reporttype == '2') { //Services
                $getdata = mysqli_query($conn, "SELECT  a.*,(a.price * b.totalqty ) total ,b.totalsell,b.totalqty
                                             FROM services a 
                                             left join 
                                             (
                                                select count(id) totalsell,sum(qty) totalqty,services_id 
                                                from tx_orders_d 
                                                where deleted_at is null and date(created_at) >= '" . $datefrom . "' and date(created_at) <= '" . $dateto . "' group by services_id 
                                              )
                                              b on b.services_id=a.id  
                                             where a.deleted_at is null 
                                             order by (a.price * b.totalqty ) desc  ");
            } else if ($reporttype == '3') { //Customers
                $getdata = mysqli_query($conn, "SELECT  a.*,b.total,b.totalorder 
                                             FROM customers a 
                                             left join 
                                             (
                                                select count(id) totalorder,sum(total) total,customers_id 
                                                from tx_orders
                                                where deleted_at is null and date(created_at) >= '" . $datefrom . "' and date(created_at) <= '" . $dateto . "' group by customers_id 
                                              )
                                              b on b.customers_id=a.id  
                                             where a.deleted_at is null 
                                             order by b.total desc  ");
            } else if ($reporttype == '4') { //Pickups
                $getdata = mysqli_query($conn, "SELECT c.*,b.name customername,DATE_FORMAT(c.date, '%W , %d %M %Y') dates
                                        ,DATE_FORMAT(a.date, '%W , %d %M %Y') pickupdate
                                        ,DATE_FORMAT(c.end_date, '%W , %d %M %Y') end_dates 
                                        ,a.notes pickupnote ,a.date pickdate
                                         from tx_pickups a 
                                         left join customers b on a.customers_id=b.id 
                                         left join tx_orders c on a.orders_id=c.id 
                                         where a.deleted_at is null and date(a.created_at) >= '" . $datefrom . "' and date(a.created_at) <= '" . $dateto . "'
                                         order by a.id desc  ");
            }

            $numdata = mysqli_num_rows($getdata);
            $alerts = '';
        } else {
            $alerts = '
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>
                Please Choose Report Type !
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            ';
            $reporttype = '';
            $datefrom = date('Y-m-d');
            $dateto = date('Y-m-d');
        }
    } else {
        $alerts = '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="alert-heading"><i class="bi bi-info-circle me-1"></i> Information Report Menu</h4>
                <p>Please choose <b>Report Type</b>. and you can filter date range. Please check again your date from & date to !</p>
                <hr>
                <p class="mb-0">Thank You !</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
        ';
        $reporttype = '';
        $datefrom = date('Y-m-d');
        $dateto = date('Y-m-d');
    }
    ?>

 <main id="main" class="main">
     <div class="pagetitle">
         <h1>Order Reports</h1>
         <nav>
             <ol class="breadcrumb">
                 <li class="breadcrumb-item"><a href="home.php">Reports</a></li>
                 <li class="breadcrumb-item active">Order Reports</li>
             </ol>
         </nav>
     </div><!-- End Page Title -->

     <section class="section dashboard">
         <div class="row">
             <div class="col-lg-12">
                 <div class="card top-selling overflow-auto effectup">
                     <div class="card-body pb-0">
                         <h5 class="card-title">Filters</h5>
                         <form action="" method="post">
                             <div class="row mb-4">
                                 <div class="col-5">
                                     <label for="reporttype">Report Type</label>
                                     <select name="reporttype" class="form-control" id="reporttype">
                                         <option value="">Choose Report Type</option>
                                         <option value="1" <?php if ($reporttype == '1') echo 'selected'; ?>>Orders Report</option>
                                         <option value="2" <?php if ($reporttype == '2') echo 'selected'; ?>>Services Report</option>
                                         <option value="3" <?php if ($reporttype == '3') echo 'selected'; ?>>Customers Report</option>
                                         <option value="4" <?php if ($reporttype == '4') echo 'selected'; ?>>Pickups Report</option>
                                     </select>
                                 </div>
                                 <div class="col-3">
                                     <label for="datefrom">Date From</label>
                                     <input type="date" class="form-control" value="<?= $datefrom; ?>" name="datefrom" id="datefrom">
                                 </div>
                                 <div class="col-3">
                                     <label for="datefrom">Date To</label>
                                     <input type="date" class="form-control" value="<?= $dateto; ?>" name="dateto" id="dateto">
                                 </div>
                                 <div class="col-1">
                                     <br>
                                     <button type="submit" class="btn btn-primary" id="submitreport" name="submitreport"> <i class="bi bi-search"></i> Search</button>
                                 </div>
                             </div>
                         </form>
                     </div>
                 </div>
                 <div class="col-lg-12">
                     <div class="card top-selling overflow-auto effectup">
                         <div class="card-body pb-0">
                             <h5 class="card-title">View Reports</h5>
                             <?php
                                if (isset($_POST)) {
                                    if (isset($_POST['reporttype']) && $_POST['reporttype'] != '') {
                                ?>
                                     <table class="table table-borderless datatable">
                                         <?php
                                            if ($_POST['reporttype'] == '1') {
                                            ?>
                                             <thead>
                                                 <tr class="text-center">
                                                     <th>No</th>
                                                     <th>Customer</th>
                                                     <th>Code</th>
                                                     <th>Date</th>
                                                     <th>End Date</th>
                                                     <th>Pay</th>
                                                     <th>Changes</th>
                                                     <th>Total</th>
                                                     <th>Status</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <?php if ($numdata > 0) {
                                                        $i = 1;
                                                    ?>
                                                     <?php while ($rows = mysqli_fetch_assoc($getdata)) { ?>
                                                         <tr class="text-center">
                                                             <td><?= $i++; ?></td>
                                                             <td><?= $rows['customername']; ?></td>
                                                             <td><?= $rows['code']; ?></td>
                                                             <td><?= $rows['dates']; ?></td>
                                                             <td><?= $rows['end_dates']; ?></td>
                                                             <td><?= number_format($rows['pay']); ?></td>
                                                             <td><?= number_format($rows['changes']); ?></td>
                                                             <td><?= number_format($rows['total']); ?></td>
                                                             <td><?= $rows['statuslabel']; ?></td>
                                                         </tr>
                                                     <?php } ?>
                                                 <?php } ?>
                                             </tbody>
                                         <?php } ?>

                                         <?php
                                            if ($_POST['reporttype'] == '2') {
                                            ?>
                                             <thead>
                                                 <tr class="text-center">
                                                     <th>No</th>
                                                     <th>Service</th>
                                                     <th>Price</th>
                                                     <th>Total Order</th>
                                                     <th>Revenue</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <?php if ($numdata > 0) {
                                                        $i = 1;
                                                    ?>
                                                     <?php while ($rows = mysqli_fetch_assoc($getdata)) { ?>
                                                         <tr class="text-center">
                                                             <td><?= $i++; ?></td>
                                                             <td><a href="#" class="text-primary fw-bold"><?= $rows['name']; ?></a></td>
                                                             <td>Rp. <?= number_format($rows['price']); ?></td>
                                                             <td class="fw-bold"><?= number_format($rows['totalsell']); ?> Times</td>
                                                             <td>Rp. <?= number_format($rows['total']); ?></td>
                                                         </tr>
                                                     <?php } ?>
                                                 <?php } ?>
                                             </tbody>
                                         <?php } ?>
                                         <?php
                                            if ($_POST['reporttype'] == '3') {
                                            ?>
                                             <thead>
                                                 <tr class="text-center">
                                                     <th>No</th>
                                                     <th>Customer</th>
                                                     <th>Total Order</th>
                                                     <th>Revenue</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <?php if ($numdata > 0) {
                                                        $i = 1;
                                                    ?>
                                                     <?php while ($rows = mysqli_fetch_assoc($getdata)) { ?>
                                                         <tr class="text-center">
                                                             <td><?= $i++; ?></td>
                                                             <td><a href="#" class="text-primary fw-bold"><?= $rows['name']; ?></a></td>
                                                             <td class="fw-bold"><?= number_format($rows['totalorder']); ?> Times</td>
                                                             <td>Rp. <?= number_format($rows['total']); ?></td>
                                                         </tr>
                                                     <?php } ?>
                                                 <?php } ?>
                                             </tbody>
                                         <?php } ?>
                                         <?php
                                            if ($_POST['reporttype'] == '4') {
                                            ?>
                                             <thead>
                                                 <tr class="text-center">
                                                     <th>No</th>
                                                     <th>Customer</th>
                                                     <th>Code</th>
                                                     <th>Order Date</th>
                                                     <th>Pay</th>
                                                     <th>Changes</th>
                                                     <th>Total</th>
                                                     <th>Pickup Date</th>
                                                     <th>Notes</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <?php if ($numdata > 0) {
                                                        $i = 1;
                                                    ?>
                                                     <?php while ($rows = mysqli_fetch_assoc($getdata)) { ?>
                                                         <tr class="text-center">
                                                             <td><?= $i++; ?></td>
                                                             <td><?= $rows['customername']; ?></td>
                                                             <td><?= $rows['code']; ?></td>
                                                             <td><?= $rows['dates']; ?> - <?= $rows['end_dates']; ?></td>
                                                             <td><?= number_format($rows['pay']); ?></td>
                                                             <td><?= number_format($rows['changes']); ?></td>
                                                             <td><?= number_format($rows['total']); ?></td>
                                                             <td><?= $rows['pickupdate']; ?></td>
                                                             <td><?= $rows['pickupnote']; ?></td>
                                                         </tr>
                                                     <?php } ?>
                                                 <?php } ?>
                                             </tbody>
                                         <?php } ?>
                                     </table>
                             <?php }
                                } ?>
                         </div>
                     </div>
                 </div>
             </div>
     </section>

 </main><!-- End #main -->