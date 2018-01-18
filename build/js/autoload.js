$(function () {
  var uri = new URI();

  SweetAlert = new SweetAlert();
  DateTime = new DateTime();
  Form = new Form();
  Table = new Table();

  (new Kinetic()).init();

  if ($('table').length) {
    Table.initItemCheckbox();
  }

  if ($.inArray(uri.segment()[0], ['login', 'forgot-password', 'reset-password']) == -1 && $('form').length) {
    Form.overrideSubmit(SweetAlert);
  }

  if ($('form').length && $('input[datepicker]').length) {
    DateTime.initDatePicker();
  }

  if ($('form').length && $('input[timepicker]').length) {
    DateTime.initTimePicker();
  }

  if ($('form').length && $('input[datetimepicker]').length) {
    DateTime.initDateTimePicker();
  }

  if ($('form').length && $('div[type=draggable-box]').length) {
    Form.initDraggable();
  }

  if ($('form').length && $('input[type=file]').length) {
    if (uri.segment()[0] == 'manage-my-account') {
      Form.initFilePicker({
        required: true,
        showCaption: false,
        showPreview: false,
        showUpload: true,
        allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        browseLabel: 'Change Profile Picture',
        browseIcon: '<i class=\'fa fa-picture-o\'></i>',
        browseClass: 'btn btn-default',
        uploadLabel: 'Save Changes',
        uploadIcon: '<i class=\'fa fa-save\'></i>',
      });
    } else {
      Form.initFilePicker({
        required: true,
        showCaption: true,
        showPreview: true,
        showUpload: false,
        allowedFileExtensions: ['xls', 'xlsx'],
        browseLabel: 'Browse Class List',
        browseIcon: '<i class=\'fa fa-file-excel-o\'></i>',
        browseClass: 'btn btn-default',
      });
    }
  }

  if (uri.segment()[0] == 'manage-my-account') {
    (new UserManagement(uri)).initManageMyAccount(DateTime, Form);
  }
});
