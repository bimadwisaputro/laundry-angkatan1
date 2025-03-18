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
$(document).on("click", "[id^=simpan_]", function (e) {
  e.preventDefault();
  var tipe = $(this).attr("tipe");
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
          window.location.href = "home.php?page=" + tipe + ""; //Will take you to Google.
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
