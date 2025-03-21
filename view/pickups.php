<?php
$getdata = mysqli_query($conn, "SELECT c.*,b.name customername,DATE_FORMAT(c.date, '%W , %d %M %Y') dates
                                        ,DATE_FORMAT(a.date, '%W , %d %M %Y') pickupdate
                                        ,DATE_FORMAT(c.end_date, '%W , %d %M %Y') end_dates 
                                        ,a.notes pickupnote ,a.date pickdate,a.id pickupid
                                         from tx_pickups a 
                                         left join customers b on a.customers_id=b.id 
                                         left join tx_orders c on a.orders_id=c.id 
                                         where a.deleted_at is null 
                                         order by a.id desc");
$numdata = mysqli_num_rows($getdata);

?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Pickups</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Transaction</a></li>
                <li class="breadcrumb-item active">Pickups</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <?php if (!isset($_GET['form'])) { ?>
                <div class="col-12">
                    <div class="card top-selling overflow-auto effectup">
                        <div class="card-body pb-0">
                            <table class="table table-striped table-bordered datatable mt-3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer</th>
                                        <th>Code</th>
                                        <th>Order Date</th>
                                        <th>Pay</th>
                                        <th>Changes</th>
                                        <th>Total</th>
                                        <th>Pickup Date</th>
                                        <th>Notes</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($numdata > 0) {
                                        $i = 1;
                                    ?>
                                        <?php while ($rows = mysqli_fetch_assoc($getdata)) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $rows['customername']; ?></td>
                                                <td><?= $rows['code']; ?></td>
                                                <td><?= $rows['dates']; ?> - <?= $rows['end_dates']; ?></td>
                                                <td><?= number_format($rows['pay']); ?></td>
                                                <td><?= number_format($rows['changes']); ?></td>
                                                <td><?= number_format($rows['total']); ?></td>
                                                <td><?= $rows['pickupdate']; ?></td>
                                                <td><?= $rows['pickupnote']; ?></td>
                                                <td class="text-center" style="width:20%;">
                                                    <a href="<?= $links_path; ?>&form=edit&tid=<?= base64_encode($rows['pickupid']); ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                                    <a href="#" id="delete_<?= $rows['pickupid']; ?>" tid="<?= $rows['pickupid']; ?>" tipe="tx_pickups" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="6">No Data Entry</td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- End Top Selling -->
            <?php } else {
                if (isset($_GET['tid'])) {
                    $tid = base64_decode($_GET['tid']);
                    $label = 'Edit';
                    $labelbutton = 'Update';
                    $getdata = mysqli_query($conn, "
                        SELECT c.*,b.name customername,DATE_FORMAT(c.date, '%W , %d %M %Y') dates
                                        ,DATE_FORMAT(a.date, '%W , %d %M %Y') pickupdate
                                        ,DATE_FORMAT(c.end_date, '%W , %d %M %Y') end_dates 
                                        ,a.notes pickupnote ,a.date pickdate
                                         from tx_pickups a 
                                         left join customers b on a.customers_id=b.id 
                                         left join tx_orders c on a.orders_id=c.id 
                                         where a.id = '$tid'");
                    $rows = mysqli_fetch_assoc($getdata);
                    $customername = $rows['customername'];
                    $dates = $rows['dates'];
                    $end_dates = $rows['end_dates'];
                    $pickdate = $rows['pickdate'];
                    $end_date = $rows['end_date'];
                    $pay = $rows['pay'];
                    $changes = $rows['changes'];
                    $total = $rows['total'];
                    $notes = $rows['pickupnote'];
                } else {
                    $label = 'Add';
                    $labelbutton = 'Save';
                    $tid = 0;
                    $customers_id = 0;
                    $date = date('Y-m-d');
                    $end_date = date('Y-m-d');
                    $pay = '';
                    $changes = '';
                    $total = '';
                    $status = 0;
                    $checkdetail = 0;
                }
            ?>
                <style>
                    .select2-selection__rendered {
                        line-height: 51px !important;
                    }

                    .select2-container .select2-selection--single {
                        height: 55px !important;
                    }

                    .select2-selection__arrow {
                        height: 54px !important;
                    }
                </style>
                <div class="col-12">
                    <div class="card top-selling overflow-auto effectup">
                        <div class="card-body pb-0">
                            <input type="hidden" id="tid" name="tid" class="pickupsform" value="<?= $tid; ?>">
                            <h5 class="card-title"><?= $label; ?> Orders Form</h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label for="date">Date</label>
                                    <input type="text" class="form-control" value="<?= $dates; ?>" readonly disabled>
                                </div>
                                <div class="col-6">
                                    <label for="enddate">End Date</label>
                                    <input type="text" class="form-control" value="<?= $end_dates; ?>" readonly disabled>
                                </div>
                                <div class="col-4 mt-3">
                                    <label for="pay">Pay</label>
                                    <input type="text" class="form-control" value="<?= $pay; ?>" readonly disabled>
                                </div>
                                <div class="col-4 mt-3">
                                    <label for="changes">Changes</label>
                                    <input type="text" class="form-control" value="<?= $changes; ?>" readonly disabled>
                                </div>
                                <div class="col-4 mt-3">
                                    <label for="total">Total</label>
                                    <input type="text" class="form-control" value="<?= $total; ?>" readonly disabled>
                                </div>
                            </div>
                            <div class="row g-3 mt-4">
                                <div class="col-md-12 mb-2">
                                    <h5 class="card-title">Pickup Details</h5>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="form-floating">
                                        <input type="date" class="form-control pickupsform" name="date" id="date" value="<?= $pickdate; ?>" placeholder="Date Pickup" required>
                                        <label for="name">Date Pickup</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="form-floating">
                                        <textarea type="text" class="form-control pickupsform" name="notes" style="height:100px;" id="notes" placeholder="Notes"><?= $notes; ?></textarea>
                                        <label for="notes">Notes</label>
                                    </div>
                                </div>
                                <div class="text-center mb-3 mt-4">
                                    <a href="<?= $links_path; ?>" class="btn btn-danger">Back to Pickup List</a>
                                    <span name="simpan" id="simpan_" tipe="<?= $_GET['page']; ?>" class="btn btn-primary" mode="<?= $label; ?>"><?= $labelbutton; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Top Selling -->
            <?php } ?>
            <!-- End floating Labels Form -->
        </div>
        </div>
        </div><!-- End Top Selling -->


        </div>
    </section>

</main><!-- End #main -->