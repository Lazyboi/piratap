function UserManagement(uri) {
  this.initManageMyAccount = function (Form) {
    $('#profile-change-picture').on('click', function () {
      $('#profile-change-picture-file').click();
    });

    $('#profile-change-picture-file').on('change', function () {
      $('#profile-change-picture-form').submit();
    });
  }
}
