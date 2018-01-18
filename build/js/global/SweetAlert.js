function SweetAlert() {
  swal.setDefaults({
    allowEscapeKey: false,
    confirmButtonColor: '#a62d38'
  });

  this.alert = function (title, text) {
    swal(title, text);
  };

  this.error = function (title, text) {
    swal(title, text, "error");
  };

  this.confirm = function (title, text, callback) {
    swal({
        title: title,
        text: text,
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, I'm Sure",
        closeOnConfirm: false
      },
      function () {
        callback();
      });
  };

  this.success = function (title, text) {
    swal(title, text, "success");
  };
}
