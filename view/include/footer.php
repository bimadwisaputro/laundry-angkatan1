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


<<<<<<< HEAD
    <?php if ($getpage == 'orders' && isset($_GET['form'])) { ?>
=======
    <?php if ($_GET['page'] == 'orders' && isset($_GET['form'])) { ?>
>>>>>>> 73a3255a736110316658f8be2efd3a64d4fde25e

        function removesdetail(counter) {
            $("#sub_row" + counter).remove();
            setTimeout(function() {
                var pay = $("#pay").val();
                grand_total = 0;
                changes = 0;
                $('[name="subtotal[]"]').each(function() {
                    var total = $(this).val();
<<<<<<< HEAD
                    if (total != '' && parseFloat(total) > 0)
                        grand_total += parseFloat(total);
                });

                if (grand_total > 0) {
                    // console.log(parseFloat(pay) + ' - ' + parseFloat(grand_total));
                    // return false;
                    changes = parseFloat(pay) - parseFloat(grand_total);
=======
                    if (total != '' && parseInt(total) > 0)
                        grand_total += parseInt(total);
                });

                if (grand_total > 0) {
                    // console.log(parseInt(pay) + ' - ' + parseInt(grand_total));
                    // return false;
                    changes = parseInt(pay) - parseInt(grand_total);
>>>>>>> 73a3255a736110316658f8be2efd3a64d4fde25e
                    $('#changes').val(changes);
                    $("#total").val(grand_total);
                }
            }, 1000);

        }
<<<<<<< HEAD
        $(document).ready(function() {
            var item_counter = <?php echo $item_counter; ?>;
=======
        //require(['input-mask']);
        $(document).ready(function() {
            var item_counter = <?php echo $item_counter; ?>;
            // $(".datepicker").datepicker({
            //     dateFormat: 'dd/mm/yy'
            // });

>>>>>>> 73a3255a736110316658f8be2efd3a64d4fde25e
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
<<<<<<< HEAD
                changes = parseFloat(pay) - parseFloat(total);
=======
                changes = parseInt(pay) - parseInt(total);
>>>>>>> 73a3255a736110316658f8be2efd3a64d4fde25e
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
<<<<<<< HEAD
                if (price != '' && qty != '' && parseFloat(price) > 0 && parseFloat(qty) > 0) {

                    subtotal = parseFloat(price) * parseFloat(qty);
=======
                if (price != '' && qty != '' && parseInt(price) > 0 && parseInt(qty) > 0) {

                    subtotal = parseInt(price) * parseInt(qty);
>>>>>>> 73a3255a736110316658f8be2efd3a64d4fde25e
                    $('#subtotal' + counter).val(subtotal);
                    var grand_total = 0;
                    $('[name="subtotal[]"]').each(function() {
                        var total = $(this).val();
<<<<<<< HEAD
                        if (total != '' && parseFloat(total) > 0)
                            grand_total += parseFloat(total);
=======
                        if (total != '' && parseInt(total) > 0)
                            grand_total += parseInt(total);
>>>>>>> 73a3255a736110316658f8be2efd3a64d4fde25e
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
<<<<<<< HEAD
                if (price != '' && qty != '' && parseFloat(price) > 0 && parseFloat(qty) > 0) {

                    subtotal = parseFloat(price) * parseFloat(qty);
=======
                if (price != '' && qty != '' && parseInt(price) > 0 && parseInt(qty) > 0) {

                    subtotal = parseInt(price) * parseInt(qty);
>>>>>>> 73a3255a736110316658f8be2efd3a64d4fde25e
                    $('#subtotal' + counter).val(subtotal);
                    var grand_total = 0;
                    $('[name="subtotal[]"]').each(function() {
                        var total = $(this).val();
<<<<<<< HEAD
                        if (total != '' && parseFloat(total) > 0)
                            grand_total += parseFloat(total);
=======
                        if (total != '' && parseInt(total) > 0)
                            grand_total += parseInt(total);
>>>>>>> 73a3255a736110316658f8be2efd3a64d4fde25e
                    });

                    if (grand_total > 0)
                        $("#total").val(grand_total);
                }
            });

<<<<<<< HEAD
=======
            // $("#transaction-form").submit(function() {
            //     var customer_contact_id = $('#customer_contact_id').val();
            //     var sales_contact_id = $('#sales_contact_id').val();
            //     var start_date = $('#start_date').val();
            //     var due_date = $('#due_date').val();
            //     var valid = true;

            //     $('#customer_contact_id').removeClass('is-invalid');
            //     $('#sales_contact_id').removeClass('is-invalid');
            //     $('#start_date').removeClass('is-invalid');
            //     $('#due_date').removeClass('is-invalid');

            //     if ($.trim(customer_contact_id) == '') {
            //         $('#customer_contact_id').addClass('is-invalid');
            //         valid = false;
            //     }

            //     if ($.trim(sales_contact_id) == '') {
            //         $('#sales_contact_id').addClass('is-invalid');
            //         valid = false;
            //     }

            //     if ($.trim(start_date) == '') {
            //         $('#start_date').addClass('is-invalid');
            //         valid = false;
            //     }

            //     if ($.trim(due_date) == '') {
            //         $('#due_date').addClass('is-invalid');
            //         valid = false;
            //     }

            //     if (valid) {
            //         $('#invalid-feedback_due_date').html('* Harus diisi');

            //         var d1 = start_date.split(/\D/);
            //         var date1 = d1[1] + '/' + d1[0] + '/' + d1[2];

            //         var d2 = due_date.split(/\D/);
            //         var date2 = d2[1] + '/' + d2[0] + '/' + d2[2];

            //         if (new Date(Date.parse(date1)) > new Date(Date.parse(date2))) {
            //             $('#due_date').addClass('is-invalid');
            //             $('#invalid-feedback_due_date').html('* Tanggal harus lebih besar');

            //             valid = false;
            //         }
            //     }

            //     $('[name="item_id[]"]').each(function() {
            //         var rel_id = $(this).attr('rel');
            //         var item_id = $(this).val();
            //         var item_price = $('#item_price' + rel_id).val();
            //         var item_price_retail = $('#item_price_retail' + rel_id).val();
            //         var item_qty = $('#item_qty' + rel_id).val();

            //         $(this).removeClass('is-invalid');
            //         $('#item_price_retail' + rel_id).removeClass('is-invalid');
            //         $('#item_qty' + rel_id).removeClass('is-invalid');

            //         if ($.trim(item_id) == '') {
            //             $(this).addClass('is-invalid');
            //             valid = false;
            //         }

            //         if ($.trim(item_price_retail) == '') {
            //             $('#item_price_retail' + rel_id).addClass('is-invalid');
            //             valid = false;
            //         } else if (item_price_retail < item_price) {
            //             $('#item_price_retail' + rel_id).addClass('is-invalid');
            //             valid = false;
            //         }

            //         if ($.trim(item_qty) == '' || item_qty < 1) {
            //             $('#item_qty' + rel_id).addClass('is-invalid');
            //             valid = false;
            //         }
            //     });

            //     return valid;
            // });

            // $("#customer_contact_id").change(function() {
            //     var contact_id = $(this).val();
            //     var jatuhtempo = $('#config_jatuhtempo_' + contact_id).val();
            //     var start_date = $('#start_date').val();
            //     var due_date = $('#due_date').val();

            //     if (start_date != '' && due_date == '' && !isNaN(jatuhtempo) && jatuhtempo > 0) {
            //         var d1 = start_date.split(/\D/);
            //         var date1 = d1[1] + '/' + d1[0] + '/' + d1[2];
            //         date = new Date(Date.parse(date1));
            //         days = parseInt(jatuhtempo, 10);

            //         if (!isNaN(date.getTime())) {
            //             date.setDate(date.getDate() + days);
            //             $("#due_date").val(date.toInputFormat());
            //         }
            //     }
            // });

            // $("#due_date").on("click", function(evt) {
            //     var contact_id = $('#customer_contact_id').val();
            //     var jatuhtempo = $('#config_jatuhtempo_' + contact_id).val();
            //     var start_date = $('#start_date').val();
            //     var due_date = $(this).val();

            //     if (start_date != '' && due_date == '' && !isNaN(jatuhtempo) && jatuhtempo > 0) {
            //         var d1 = start_date.split(/\D/);
            //         var date1 = d1[1] + '/' + d1[0] + '/' + d1[2];
            //         date = new Date(Date.parse(date1));
            //         days = parseInt(jatuhtempo, 10);

            //         if (!isNaN(date.getTime())) {
            //             date.setDate(date.getDate() + days);
            //             $("#due_date").val(date.toInputFormat());
            //         }
            //     }
            // });

            // Date.prototype.toInputFormat = function() {
            //     var yyyy = this.getFullYear().toString();
            //     var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
            //     var dd = this.getDate().toString();
            //     return (dd[1] ? dd : "0" + dd[0]) + '/' + (mm[1] ? mm : "0" + mm[0]) + '/' + yyyy;
            // };

            // $(document).on('input', '.item-price-count', function() {
            //     var counter = $(this).attr('counter');
            //     var item_price_retail = $('#subtotal' + counter).val();
            //     var item_qty = $('#qty' + counter).val();

            //     if (item_price_retail != '' && item_qty != '' && parseInt(item_price_retail) > 0 && parseInt(item_qty) > 0) {
            //         total = item_price_retail * item_qty;
            //         $('#price' + counter).val(total);

            //         var grand_total = 0;
            //         $('[name="item_price_total[]"]').each(function() {
            //             var total = $(this).val();
            //             if (total != '' && parseInt(total) > 0)
            //                 grand_total += parseInt(total);
            //         });

            //         if (grand_total > 0)
            //             $("#item_price_grand_total").val(grand_total);
            //     }
            // });

>>>>>>> 73a3255a736110316658f8be2efd3a64d4fde25e
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