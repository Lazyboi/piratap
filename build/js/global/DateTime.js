function DateTime() {
  this.initDatePicker = function () {
    $('input[datepicker]').datetimepicker({
      format: 'F d, Y',
      datepicker: true,
      timepicker: false,
    });
  };

  this.initTimePicker = function () {
    $('input[timepicker]').datetimepicker({
      format: 'H:i',
      datepicker: false,
      timepicker: true,
      step: 15,
    });
  };

  this.initDateTimePicker = function () {
    $('input[datetimepicker]').datetimepicker({
      format: 'F d, Y h:i:s A',
      datepicker: true,
      timepicker: true,
      step: 15,
    });
  };
}
