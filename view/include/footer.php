<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<script src=" https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="assets/bootstrap-tags/bootstrap-tagsinput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Vendor JS Files -->
<script src="assets/adminlte/assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/adminlte/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/adminlte/assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/adminlte/assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/adminlte/assets/vendor/quill/quill.js"></script>
<script src="assets/adminlte/assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/adminlte/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/adminlte/assets/vendor/php-email-form/validate.js"></script>
<!-- gsap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<!-- Template Main JS File -->
<script src="assets/adminlte/assets/js/main.js"></script>

<!-- izitoast -->
<script src="assets/iziToast/dist/js/iziToast.js"></script>
<script>
    $('.select2tags').select2();
    // var url = window.location.href;
    // var res = url.split('/');
    // countres = res.length - 1;
    // var filename = res[countres].split('.');
    // console.log(filename[0]);

    //sidebarleft
    $.each($(".sidebarleft"), function(index, value) {
        var id = $(this).attr('id');
        var parentid = $(this).attr('parentid');
        if (id == '<?= $getpage; ?>') {
            if (parentid == '') {
                $("#" + id).removeClass('collapsed');
            } else {
                $("#" + id).addClass('active');
                $("#" + parentid + "-nav").addClass('show');
                $("#" + parentid + "").removeClass('collapsed');
            }
        }

    })

    setTimeout(function() {
        $('#loading').hide();
    }, 2000);

    iziToast.settings({
        timeout: 3000, // default timeout
        resetOnHover: true,
        transitionIn: 'flipInX',
        transitionOut: 'flipOutX',
        position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
        onOpen: function() {
            console.log('callback abriu!');
        },
        onClose: function() {
            console.log("callback fechou!");
        }
    });

    function callsuccesstoast(title, description, type) {

        if (type == 'danger') {
            iziToast.danger({
                timeout: 5000,
                icon: 'fa fa-close',
                title: '' + title + '',
                message: '' + description + ''
            });
        } else if (type == 'success') {
            iziToast.success({
                timeout: 5000,
                icon: 'fa fa-check',
                title: '' + title + '',
                message: '' + description + ''
            });
        }


    }
    gsap.from(".effectup", {
        y: 50,
        duration: 3,
        ease: "power3.out",
    });


    <?php if ($getpage == 'orders' && isset($_GET['form'])) { ?>

        function removesdetail(counter) {
            $("#sub_row" + counter).remove();
            setTimeout(function() {
                var pay = $("#pay").val();
                grand_total = 0;
                changes = 0;
                $('[name="subtotal[]"]').each(function() {
                    var total = $(this).val();
                    if (total != '' && parseFloat(total) > 0)
                        grand_total += parseFloat(total);
                });

                if (grand_total > 0) {
                    // console.log(parseFloat(pay) + ' - ' + parseFloat(grand_total));
                    // return false;
                    changes = parseFloat(pay) - parseFloat(grand_total);
                    $('#changes').val(changes);
                    $("#total").val(grand_total);
                }
            }, 1000);

        }
        $(document).ready(function() {
            var item_counter = <?php echo $item_counter; ?>;
            $("#add_item").click(function() {

                counter = 1;
                $('[name="services_id[]"]').each(function() {
                    counter++;
                })

                if (counter > 26) {
                    alert('Maksimum 26 item');
                    return false;
                }
                var listservices = '';
                <?php if ($cekservices > 0) { ?>
                    <?php foreach ($rowsservices as  $rowser) { ?>
                        listservices += '<option value = "<?= $rowser['id']; ?>-<?= $rowser['price']; ?>" ><?= $rowser['name']; ?> - Rp.<?= $rowser['price']; ?></option>';
                    <?php } ?>
                <?php } ?>

                $("#item_list tbody#t").append(`
                  <tr id="sub_row${item_counter}">
                <td class="pl-0">
                    <select class="custom-select services_id form-control ordersformdetail${item_counter}" counter="${item_counter}" name="services_id[]" id="services_id${item_counter}">
                        <option value="">Choose Service</option>
                        ${listservices}
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control allow_decimal text-right totalqty ordersformdetail${item_counter}" id="qty${item_counter}" name="qty[]" counter="${item_counter}">
                </td> 
                <td>
                    <div class="input-group">
                        <span class="input-group-prepend">
                         <span class="input-group-text">Rp.</span>
                        </span>
                        <input type="text" class="form-control text-right ordersformdetail${item_counter}" id="subtotal${item_counter}" counter="${item_counter}" name="subtotal[]" readonly>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <textarea class="form-control text-right ordersformdetail${item_counter}" id="notes${item_counter}" counter="${item_counter}" name="notes[]"></textarea>
                    </div>
                </td> 
                <td class="pr-0" class="align-middle">
                    <a href="#" class="icon fe-md" onclick="removesdetail(${item_counter})">
                        <i class="bi bi-x-square "></i>
                    </a>
                </td>
            </tr>`);
                item_counter++;
                return false;
            });

            $(document).on('keyup', '[id=pay]', function() {
                var pay = $(this).val();
                var total = $("#total").val();
                changes = parseFloat(pay) - parseFloat(total);
                $('#changes').val(changes);
            })

            $(document).on('keyup', '.totalqty', function() {
                var qty = $(this).val();
                var counter = $(this).attr('counter');
                var res_service = $("#services_id" + counter).val();
                // console.log(res_service);
                // return false;
                var resserv = res_service.split("-");
                var id_service = resserv[0];
                var price = resserv[1];
                if (price != '' && qty != '' && parseFloat(price) > 0 && parseFloat(qty) > 0) {

                    subtotal = parseFloat(price) * parseFloat(qty);
                    $('#subtotal' + counter).val(subtotal);
                    var grand_total = 0;
                    $('[name="subtotal[]"]').each(function() {
                        var total = $(this).val();
                        if (total != '' && parseFloat(total) > 0)
                            grand_total += parseFloat(total);
                    });

                    if (grand_total > 0)
                        $("#total").val(grand_total);
                }
            });

            $(document).on('change', 'select', '.services_id', function() {
                var counter = $(this).attr('counter');
                var res_service = $(this).val();
                var resserv = res_service.split("-");
                var id_service = resserv[0];
                var price = resserv[1];
                var qty = $("#qty" + counter).val();
                if (price != '' && qty != '' && parseFloat(price) > 0 && parseFloat(qty) > 0) {

                    subtotal = parseFloat(price) * parseFloat(qty);
                    $('#subtotal' + counter).val(subtotal);
                    var grand_total = 0;
                    $('[name="subtotal[]"]').each(function() {
                        var total = $(this).val();
                        if (total != '' && parseFloat(total) > 0)
                            grand_total += parseFloat(total);
                    });

                    if (grand_total > 0)
                        $("#total").val(grand_total);
                }
            });


            $(document).on('input', '.allow_decimal', function(evt) {
                var self = $(this);
                self.val(self.val().replace(/[^0-9\.]/g, ''));
                if ((evt.key != 46 || self.val().indexOf('.') != -1) && (evt.key < 48 || evt.key > 57)) {
                    evt.preventDefault();
                }
            });


            $(document).on('input', '.allow_integer', function(evt) {
                var self = $(this);
                self.val(self.val().replace(/[^0-9\.]/g, ''));
                if ((evt.key != 46 || self.val().indexOf('.') != -1) && (evt.key < 48 || evt.key > 57)) {
                    evt.preventDefault();
                }
            });

        });
    <?php } ?>
</script>
<script src="js/custom.js?v=<?= time(); ?>"></script>
<div class="modal fade" id="logoutmodal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confimation Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are You Sure Wants To Logout ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a type="button" class="btn btn-danger" href="php/logout.php">Logout</a>
            </div>
        </div>
    </div>
</div><!-- End Small Modal-->

</body>

</html>