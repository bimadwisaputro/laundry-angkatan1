<?php
$getdata = mysqli_query($conn, "SELECT a.*,case a.status when '1' then 'Puckup Done' else 'Waiting Pickup' end as statuslabel 
                                        ,case a.status when '1' then 'success' else 'danger' end as statuscolor 
                                        ,b.name customername,DATE_FORMAT(a.date, '%W , %d %M %Y') dates
                                        ,DATE_FORMAT(a.end_date, '%W , %d %M %Y') end_dates 
                                         from tx_orders a 
                                         left join customers b on a.customers_id=b.id 
                                         where a.deleted_at is null 
                                         order by a.id desc");
$numdata = mysqli_num_rows($getdata);

?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Orders</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Transaction</a></li>
                <li class="breadcrumb-item active">Orders</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <?php if (!isset($_GET['form'])) { ?>
                <div class="col-12">
                    <div class="card top-selling overflow-auto effectup">
                        <div class="card-body pb-0">
                            <div align="right">
                                <a class="btn btn-success mt-3 mb-3 float-right pull-right" href="<?= $links_path; ?>&form=add">Create</a>
                            </div>
                            <table class="table table-striped table-bordered datatable mt-3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer</th>
                                        <th>Code</th>
                                        <th>Date</th>
                                        <th>End Date</th>
                                        <th>Pay</th>
                                        <th>Changes</th>
                                        <th>Total</th>
                                        <th>Status</th>
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
                                                <td><?= $rows['dates']; ?></td>
                                                <td><?= $rows['end_dates']; ?></td>
                                                <td><?= number_format($rows['pay']); ?></td>
                                                <td><?= number_format($rows['changes']); ?></td>
                                                <td><?= number_format($rows['total']); ?></td>
                                                <td class="text-center">
                                                    <span class="badge bg-<?= $rows['statuscolor']; ?>"><?= $rows['statuslabel']; ?></span>
                                                </td>
                                                <td class="text-center" style="width:20%;">
                                                    <a href="<?= $links_path; ?>&form=edit&tid=<?= base64_encode($rows['id']); ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                                    <a href="#" id="delete_<?= $rows['id']; ?>" tid="<?= $rows['id']; ?>" tipe="tx_orders" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                                    <?php if ($rows['status'] == '0') { ?>
                                                        <a href="#" id="pickups_<?= $rows['id']; ?>"
                                                            data-bs-toggle="modal" data-bs-target="#modalDialogPickups"
                                                            tid="<?= $rows['id']; ?>"
                                                            customername="<?= $rows['customername']; ?>"
                                                            code="<?= $rows['code']; ?>"
                                                            dates="<?= $rows['dates']; ?>"
                                                            end_dates="<?= $rows['end_dates']; ?>"
                                                            customers_id="<?= $rows['customers_id']; ?>"
                                                            pay="<?= number_format($rows['pay']); ?>"
                                                            changes="<?= number_format($rows['changes']); ?>"
                                                            total="<?= number_format($rows['total']); ?>"
                                                            tipe="orders" class="btn btn-warning">Pickup</a>
                                                    <?php } ?>
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
                $getcustomers = mysqli_query($conn, "SELECT * from customers where status= '1' and  deleted_at is null");
                $cekcustomers = mysqli_num_rows($getcustomers);
                $rowscustomers = mysqli_fetch_all($getcustomers, MYSQLI_ASSOC);
                $getservices = mysqli_query($conn, "SELECT * from services where status= '1' and  deleted_at is null");
                $cekservices = mysqli_num_rows($getservices);
                $rowsservices = mysqli_fetch_all($getservices, MYSQLI_ASSOC);
                if (isset($_GET['tid'])) {
                    $label = 'Edit';
                    $labelbutton = 'Update';
                    $tid = base64_decode($_GET['tid']);

                    $getdata = mysqli_query($conn, "SELECT a.*,b.name customersname from tx_orders a left join customers b on a.customers_id=b.id where a.id = '$tid'");
                    $rows = mysqli_fetch_assoc($getdata);

                    $getdata_detail = mysqli_query($conn, "SELECT * from tx_orders_d where orders_id = '$tid'");
                    $checkdetail = mysqli_num_rows($getdata_detail);
                    $rowsdetail = mysqli_fetch_all($getdata_detail, MYSQLI_ASSOC);

                    $customers_id = $rows['customers_id'];
                    $code = $rows['code'];
                    $date = $rows['date'];
                    $end_date = $rows['end_date'];
                    $pay = $rows['pay'];
                    $changes = $rows['changes'];
                    $total = $rows['total'];
                    $status = $rows['status'];
                } else {
                    $getdata = mysqli_query($conn, "SELECT max(right(code,4)) + 1 as nextnumber from tx_orders where left(code,8) = '" . date('dmY') . "' ");
                    $checknum = mysqli_num_rows($getdata);
                    if ($checknum > 0) {
                        $rows = mysqli_fetch_assoc($getdata);
                        if ($rows['nextnumber'] != null) {
                            if (strlen($rows['nextnumber']) == 4) {
                                $nextnum = $rows['nextnumber'];
                            } else if (strlen($rows['nextnumber']) == 3) {
                                $nextnum = '0' . $rows['nextnumber'];
                            } else if (strlen($rows['nextnumber']) == 2) {
                                $nextnum = '00' . $rows['nextnumber'];
                            } else if (strlen($rows['nextnumber']) == 1) {
                                $nextnum = '000' . $rows['nextnumber'];
                            }
                        } else {
                            $nextnum = '0001';
                        }
                    } else {
                        $nextnum = '0001';
                    }
                    $code = date('dmY') . $nextnum;
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
                            <input type="hidden" id="tid" name="tid" class="ordersform" value="<?= $tid; ?>">
                            <h5 class="card-title"><?= $label; ?> Orders Form</h5>
                            <div class="row g-3">

                                <div class="col-md-4 mb-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control ordersform" name="code" id="code" value="<?= $code; ?>" placeholder="Code" readonly>
                                        <label for="code">Code</label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-floating">
                                        <input type="date" class="form-control ordersform" name="date" id="date" value="<?= $date; ?>" placeholder="Date" required>
                                        <label for="date">Date</label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-floating">
                                        <input type="date" class="form-control ordersform" name="end_date" id="end_date" value="<?= $end_date; ?>" placeholder="Finish Date" required>
                                        <label for="end_date">Finish Date</label>
                                    </div>
                                </div>
                                <div class="col-md-10 mb-2">
                                    <label for="customers_id">Customers</label>
                                    <select class="select2tags form-control ordersform" name="customers_id" id="customers_id" required>
                                        <option value="">Find Customers</option>
                                        <?php if ($cekcustomers > 0) { ?>
                                            <?php foreach ($rowscustomers as  $rowcus) { ?>
                                                <option value="<?= $rowcus['id']; ?>" <?php if ($rowcus['id'] == $customers_id) echo 'selected'; ?>><?= $rowcus['name']; ?> - <?= $rowcus['phone']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3" style="margin:auto" align="right">
                                    <button id="addcustomers" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalDialogScrollable"><i class="bi bi-plus"></i> Customers</button>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-floating">
                                        <input type="number" class="form-control ordersform" name="pay" id="pay" value="<?= $pay; ?>" placeholder="Pay" required>
                                        <label for="pay">Pay</label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control ordersform" name="changes" id="changes" value="<?= $changes; ?>" placeholder="Changes" disabled readonly>
                                        <label for="changes">Changes</label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control ordersform" name="total" id="total" value="<?= $total; ?>" placeholder="Total" disabled readonly>
                                        <label for="total">Total</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Top Selling -->
                <div class="col-12">
                    <div class="card top-selling overflow-auto effectup">
                        <div class="card-body pb-0">
                            <h5 class="card-title"><?= $label; ?> Orders Details</h5>
                            <div class="card-header  ">
                                <div class="card-options  ">
                                    <button class="btn btn-primary">
                                        <a class="icon text-white" href="#" id="add_item"><i class="fe fe-plus"></i> Add Services</a>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table mb-0" id="item_list">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Qty</th>
                                            <th>SubTotal</th>
                                            <th>Notes</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $item_counter = 0;
                                    $grand_total = 0;
                                    ?>
                                    <tbody id="t">
                                        <?php if ($checkdetail > 0) { ?>
                                            <?php foreach ($rowsdetail as $rowd) { ?>
                                                <tr id="sub_row<?php echo $item_counter; ?>">
                                                    <td class="pl-0">
                                                        <select class="custom-select services_id form-control ordersformdetail<?php echo $item_counter; ?>" id="services_id<?php echo $item_counter; ?>" name="services_id[]" counter="<?php echo $item_counter; ?>">
                                                            <option value="">Choose Service</option>
                                                            <?php if ($cekservices > 0) { ?>
                                                                <?php foreach ($rowsservices as  $rowser) { ?>
                                                                    <option value="<?= $rowser['id']; ?>-<?= $rowser['price']; ?>" <?php if ($rowser['id'] == $rowd['services_id']) echo 'selected'; ?>><?= $rowser['name']; ?> - Rp.<?= $rowser['price']; ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" id="qty<?php echo $item_counter; ?>" class="form-control allow_decimal text-right totalqty ordersformdetail<?php echo $item_counter; ?>" value="<?= $rowd['qty']; ?>" name="qty[]" counter="<?php echo $item_counter; ?>"></td>
                                                    <td>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend">
                                                                <span class="input-group-text">Rp.</span>
                                                            </span>
                                                            <input type="text" class="form-control text-right ordersformdetail<?php echo $item_counter; ?>" id="subtotal<?php echo $item_counter; ?>" value="<?= $rowd['subtotal']; ?>" name="subtotal[]" readonly counter="<?php echo $item_counter; ?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <textarea class="form-control text-right ordersformdetail<?php echo $item_counter; ?>" id="notes<?php echo $item_counter; ?>" counter="<?php echo $item_counter; ?>" name="notes[]"><?= $rowd['notes']; ?></textarea>
                                                        </div>
                                                    </td>
                                                    <td class="pr-0" class="align-middle">
                                                        <a href="#" class="icon fe-md" onclick="removesdetail(<?php echo $item_counter; ?>)">
                                                            <i class="bi bi-x-square "></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php $item_counter++;
                                            } ?>
                                        <?php } else { ?>
                                            <tr id="sub_row<?php echo $item_counter; ?>">
                                                <td class="pl-0">
                                                    <select class="custom-select services_id form-control ordersformdetail<?php echo $item_counter; ?>" id="services_id<?php echo $item_counter; ?>" name="services_id[]" counter="<?php echo $item_counter; ?>">
                                                        <option value="">Choose Service</option>
                                                        <?php if ($cekservices > 0) { ?>
                                                            <?php foreach ($rowsservices as  $rowser) { ?>
                                                                <option value="<?= $rowser['id']; ?>-<?= $rowser['price']; ?>"><?= $rowser['name']; ?> - Rp.<?= $rowser['price']; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td><input type="text" id="qty<?php echo $item_counter; ?>" class="form-control allow_decimal text-right totalqty ordersformdetail<?php echo $item_counter; ?>" name="qty[]" counter="<?php echo $item_counter; ?>"></td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </span>
                                                        <input type="text" class="form-control text-right ordersformdetail<?php echo $item_counter; ?>" id="subtotal<?php echo $item_counter; ?>" name="subtotal[]" readonly counter="<?php echo $item_counter; ?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <textarea class="form-control text-right ordersformdetail<?php echo $item_counter; ?>" id="notes<?php echo $item_counter; ?>" counter="<?php echo $item_counter; ?>" name="notes[]"></textarea>
                                                    </div>
                                                </td>
                                                <td class="pr-0" class="align-middle">
                                                    <a href="#" class="icon fe-md" onclick="removesdetail(<?php echo $item_counter; ?>)">
                                                        <i class="bi bi-x-square "></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php $item_counter++;
                                        } ?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center mb-3 mt-4">
                                <a href="<?= $links_path; ?>" class="btn btn-danger">Back to Order List</a>
                                <span name="simpan" id="simpandetail_" tipe="<?= $_GET['page']; ?>" class="btn btn-primary" mode="<?= $label; ?>"><?= $labelbutton; ?></span>
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

<div class="modal fade" id="modalDialogPickups" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title page-title"><span id="titlecardpickups"></span></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="showdatapickups"></div>
                <input type="hidden" id="tid" name="tid" class="pickupsform" value="0">
                <input type="hidden" id="status" name="status" class="pickupsform" value="1">
                <input type="hidden" id="orders_id" name="orders_id" class="pickupsform" value="0">
                <input type="hidden" id="customers_id" name="customers_id" class="pickupsform" value="0">
                <div class="row g-3 mt-4">
                    <div class="col-md-12 mb-2">
                        <h5 class="card-title">Pickup Details</h5>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="form-floating">
                            <input type="date" class="form-control pickupsform" name="date" id="date" value="<?= date('Y-m-d'); ?>" placeholder="Date Pickup" required>
                            <label for="name">Date Pickup</label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="form-floating">
                            <textarea type="text" class="form-control pickupsform" name="notes" style="height:100px;" id="notes" placeholder="Notes"></textarea>
                            <label for="notes">Notes</label>
                        </div>
                    </div>
                    <div class="text-center mb-3 mt-4">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closemodalpickups" data-bs-dismiss="modal">Close</button>
                <span name="simpan" id="simpan_" tipe="pickups-modal" class="btn btn-primary" mode="Add">Save Pickup</span>
            </div>
        </div>
    </div>
</div><!-- End Modal Dialog Scrollable-->



<div class="modal fade" id="modalDialogScrollable" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title card-title">Add Customers Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="tid" name="tid" class="customersform" value="0">
                <div class="row g-3">
                    <div class="col-md-12 mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control customersform" name="name" id="name" placeholder="Name" required>
                            <label for="name">Name</label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control customersform" name="phone" id="phone" placeholder="Phone" required>
                            <label for="name">Phone</label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="form-floating">
                            <textarea type="text" class="form-control customersform" name="address" id="address" placeholder="Address"></textarea>
                            <label for="address">Address</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating mb-2">
                            <select class="form-select customersform" id="status" aria-label="Status">
                                <option value="1">Active</option>
                                <option value="0">Non Active</option>
                            </select>
                            <label for="status">Status</label>
                        </div>
                    </div>

                    <div class="text-center mb-3 mt-4">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closemodalcustomers" data-bs-dismiss="modal">Close</button>
                <span name="simpan" id="simpan_" tipe="customers-modal" class="btn btn-primary" mode="Add">Save Customers</span>
            </div>
        </div>
    </div>
</div><!-- End Modal Dialog Scrollable-->