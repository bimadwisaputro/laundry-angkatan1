<?php
$getdata = mysqli_query($conn, "SELECT a.*,b.name levelname
                                        ,case a.status when '1' then 'Active' else 'Not Active' end as statuslabel 
                                        ,case a.status when '1' then 'success' else 'danger' end as statuscolor
                                         from users a left join levels b on a.level_id=b.id 
                                         where a.deleted_at is null 
                                         order by a.id desc"); //and a.id not in (1) administrator
$numdata = mysqli_num_rows($getdata);

?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Users</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <div class="card top-selling overflow-auto effectup">
                    <div class="card-body pb-0">
                        <?php if (!isset($_GET['form'])) { ?>
                            <div align="right">
                                <a class="btn btn-success mt-3 mb-3 float-right pull-right" href="<?= $links_path; ?>&form=add">Create</a>
                            </div>
                            <table class="table table-striped table-bordered datatable mt-3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>
                                            <b>N</b>ame
                                        </th>
                                        <th>Email</th>
                                        <th>Level</th>
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
                                                <td><?= $rows['name']; ?></td>
                                                <td><?= $rows['email']; ?></td>
                                                <td><?= $rows['levelname']; ?></td>
                                                <td class="text-center">
                                                    <span class="badge bg-<?= $rows['statuscolor']; ?>"><?= $rows['statuslabel']; ?></span>
                                                </td>
                                                <td class="text-center" style="width:20%;">
                                                    <a href="<?= $links_path; ?>&form=edit&tid=<?= base64_encode($rows['id']); ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                                    <a href="#" id="delete_<?= $rows['id']; ?>" tid="<?= $rows['id']; ?>" tipe="users" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="7">No Data Entry</td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>

                        <?php } else {
                            $getlevel = mysqli_query($conn, "SELECT * from levels");
                            $numlevel = mysqli_num_rows($getlevel);
                            $rowlevel = mysqli_fetch_all($getlevel, MYSQLI_ASSOC);
                            if (isset($_GET['tid'])) {
                                $label = 'Edit';
                                $labelbutton = 'Update';
                                $tid = base64_decode($_GET['tid']);
                                $getdata = mysqli_query($conn, "SELECT a.*,b.name levelname from users a left join levels b on a.level_id=b.id  where a.id = '$tid'");
                                $rows = mysqli_fetch_assoc($getdata);
                                $name = $rows['name'];
                                $email = $rows['email'];
                                $level_id = $rows['level_id'];
                                $levelname = $rows['levelname'];
                                $status = $rows['status'];
                            } else {
                                $label = 'Add';
                                $labelbutton = 'Save';
                                $tid = 0;
                                $name = '';
                                $email = '';
                                $level_id = '';
                                $levelname = '';
                                $status = 0;
                            }
                        ?>
                            <input type="hidden" id="tid" name="tid" class="usersform" value="<?= $tid; ?>">
                            <h5 class="card-title"><?= $label; ?> Form</h5>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="form-floating mb-2">
                                        <select class="form-control usersform" name="level_id" id="level_id">
                                            <option value="">Choose Level</option>
                                            <?php foreach ($rowlevel as $rowlev) { ?>
                                                <option value="<?= $rowlev['id']; ?>" <?php if ($rowlev['id'] == $level_id) echo 'selected'; ?>><?= $rowlev['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="level_id">Levels</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control usersform" name="name" id="name" value="<?= $name; ?>" placeholder="Name" required>
                                        <label for="name">Name</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control usersform" name="email" id="email" value="<?= $email; ?>" placeholder="Email" required>
                                        <label for="name">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mb-2">
                                        <select class="form-select usersform" id="status" aria-label="Status">
                                            <option value="1" <?php if ($status == 1) echo 'selected'; ?>>Active</option>
                                            <option value="0" <?php if ($status == 0) echo 'selected'; ?>>Non Active</option>
                                        </select>
                                        <label for="status">Status</label>
                                    </div>
                                </div>

                                <div class="text-center mb-3 mt-4">
                                    <a href="<?= $links_path; ?>" class="btn btn-danger">Cancel</a>
                                    <span name="simpan" id="simpan_" tipe="<?= $_GET['page']; ?>" class="btn btn-primary" mode="<?= $label; ?>"><?= $labelbutton; ?></span>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- End floating Labels Form -->
                    </div>
                </div>
            </div><!-- End Top Selling -->


        </div>
    </section>

</main><!-- End #main -->