$(document).on("click", "[id^=pickups_]", function (e) {
  e.preventDefault();
  var tid = $(this).attr("tid");
  var customername = $(this).attr("customername");
  var code = $(this).attr("code");
  var dates = $(this).attr("dates");
  var end_dates = $(this).attr("end_dates");
  var customers_id = $(this).attr("customers_id");
  var pay = $(this).attr("pay");
  var changes = $(this).attr("changes");
  var total = $(this).attr("total");
  $(".pickupsform#customers_id").val(customers_id);
  $(".pickupsform#orders_id").val(tid);
  var insidediv = `
        <div class="row">
                        <div class="col-6">
                        <label for="date">Date</label>
                            <input type="text" class="form-control" value="${dates}" readonly disabled>
                        </div>
                        <div class="col-6">
                        <label for="enddate">End Date</label>
                            <input type="text" class="form-control" value="${end_dates}" readonly disabled>
                        </div>
                        <div class="col-4 mt-3">
                        <label for="pay">Pay</label>
                            <input type="text" class="form-control" value="${pay}" readonly disabled>
                        </div>
                        <div class="col-4 mt-3">
                        <label for="changes">Changes</label>
                            <input type="text" class="form-control" value="${changes}" readonly disabled>
                        </div>
                        <div class="col-4 mt-3">
                        <label for="total">Total</label>
                            <input type="text" class="form-control"  value="${total}" readonly disabled>
                        </div>
                    </div>
  `;
  $("#titlecardpickups").html(customername + " - " + code);
  $("#showdatapickups").html(insidediv);
  $("#showdatapickups").html(insidediv);
});
$(document).on("click", "[id^=delete_]", function (e) {
  e.preventDefault();
  if (confirm("Are you sure want to delete?")) {
    dataMap = {};
    dataMap["tid"] = $(this).attr("tid");
    dataMap["tipe"] = $(this).attr("tipe");
    $.post("php/delete.php", dataMap, function (response) {
      // Log the response to the consol
      console.log(response);
      var res = JSON.parse(response);
      if (res.status == 1) {
        iziToast.success({
          timeout: 5000,
          icon: "fa fa-check",
          title: "Delete Success",
          message: "Thank You.. !",
        });
        setTimeout(function () {
          location.reload(0);
        }, 2000);
      } else {
        iziToast.error({
          timeout: 5000,
          icon: "fa fa-close",
          title: "Delete Failed",
          message: "Error",
        });
      }
    });
  } else {
    iziToast.error({
      timeout: 5000,
      icon: "fa fa-close",
      title: "Cancel",
      message: "Process Cancel",
    });
  }
  // alert("test");
  // return false;
});

//untuk form insert & update
$(document).on("click", "[id^=simpandetail_]", function (e) {
  // untuk form transaksi / master yang ada table detail/anak/child nya
  e.preventDefault();
  var tipe = $(this).attr("tipe");
  var mode = $(this).attr("mode");

  dataMap = {};
  let formData = new FormData();
  $.each($("." + tipe + "form"), function (index, value) {
    var idx = $(value).attr("id");
    var value = $(value).val();
    dataMap["" + idx + ""] = "" + value + "";
  });

  mapnum = 0;
  mapping = [[]];
  $('[name="services_id[]"]').each(function () {
    counter = $(this).attr("counter");
    dataDetail = {};
    // dataDetail["counter"] = counter;
    $.each($("." + tipe + "formdetail" + counter), function (index, value) {
      var idx = $(this).attr("id");
      // alert(idx);
      var valueisi = $("#" + idx + "").val();
      dataDetail["" + idx + ""] = "" + valueisi + "";
    });
    mapping[mapnum] = [counter, dataDetail];
    mapnum++;
  });
  var lempardata = JSON.stringify(mapping);
  // console.log(lempardata);
  // return false;

  dataMap["dataDetail"] = lempardata;
  dataMap["tipe"] = tipe;
  dataMap["mode"] = mode;
  $.post("php/simpan_order.php", dataMap, function (response) {
    // Log the response to the consol
    console.log(response);
    var res = JSON.parse(response);
    if (res.status == 1) {
      iziToast.success({
        timeout: 5000,
        icon: "fa fa-check",
        title: "Save Data Success",
        message: "Thank You.. !",
      });
      setTimeout(function () {
        location.reload(0);
      }, 2000);
    } else {
      iziToast.error({
        timeout: 5000,
        icon: "fa fa-close",
        title: "Save Data Failed",
        message: "Error",
      });
    }
  });
});

$(document).on("click", "[id^=simpan_]", function (e) {
  e.preventDefault();
  var tipecheck = $(this).attr("tipe");
  var rescheck = tipecheck.split("-");
  if (rescheck[1] == "modal" && rescheck[0] != undefined) {
    var tipe = rescheck[0];
  } else {
    var tipe = $(this).attr("tipe");
  }
  var mode = $(this).attr("mode");
  dataMap = {};
  let formData = new FormData();
  $.each($("." + tipe + "form"), function (index, value) {
    var idx = $(value).attr("id");
    var value = $(value).val();
    dataMap["" + idx + ""] = "" + value + "";
    formData.append("" + idx + "", "" + value + "");
  });

  // if (tipe == "blogs") {
  //   formData.append("description", tinyMCE.get("description").getContent());
  // }

  // if (tipe == "contacts") {
  //   var links = "php/simpan.php";
  // } else if (tipe == "resumes" || tipe == "skills" || tipe == "categories") {
  //   var links = "php/simpan.php";
  // } else {
  //   if (document.getElementById("foto").files.length == 0) {
  //     var foto = "";
  //   } else {
  //     var foto = $("#foto")[0].files[0];
  //   }
  //   formData.append("foto", foto);
  //   var links = "php/simpan.php";
  // }
  var links = "php/simpan.php";
  formData.append("tipe", tipe);
  formData.append("mode", mode);
  // console.log(formData);
  // return false;
  $.ajax({
    url: links,
    method: "POST",
    contentType: false,
    processData: false,
    data: formData,
    success: function (response) {
      console.log(response);
      var res = JSON.parse(response);
      if (res.status == 1) {
        iziToast.success({
          timeout: 5000,
          icon: "fa fa-check",
          title: "Add Data Success",
          message: "Thank You.. !",
        });
        setTimeout(function () {
          // if (tipe != "contacts") {
          if (rescheck[1] == "modal" && rescheck[0] != undefined) {
            $("#closemodal" + rescheck[0] + "").click();
            location.reload(0);
          } else {
            window.location.href = "home.php?page=" + tipe + ""; //Will take you to Google.
          }
          // } else {
          //   location.reload(0);
          // }
        }, 2000);
      } else {
        iziToast.error({
          timeout: 5000,
          icon: "fa fa-close",
          title: "Add Data Failed",
          message: "Error",
        });
      }
    },
    error: function () {
      iziToast.error({
        timeout: 5000,
        icon: "fa fa-close",
        title: "Cancel",
        message: "Process Cancel",
      });
    },
  });
});
