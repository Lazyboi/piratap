function API() {
  this.init = function () {
    $.ajax({
        url: "/php/" + api,
        async: false,
        type: "POST",
        data: data
      })
      .done(function () {
        console.log("success");
      })
      .fail(function () {
        console.log("error");
      })
      .always(function () {
        console.log("complete");
      });
  };
}
