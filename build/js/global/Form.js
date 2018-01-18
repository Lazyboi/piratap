function Form() {
  var form = $('form');

  this.overrideSubmit = function (SweetAlert) {
    if (form.length) {
      form.on('submit', function (event) {
        if (event.preventDefault) {
          event.preventDefault();
        } else {
          event.returnValue = false;
        }

        var selectedForm = $(this);

        SweetAlert.confirm('Confirm Action', 'Are you sure with this action?', function () {
          $(selectedForm).off('submit').find('button[type=submit]').click();
        });
      });
    }
  };

  this.initDraggable = function () {
    $('div[type=draggable-box]').draggable({
      containment: '.draggable-box-layout',
      stop: function (event, ui) {
        $(this).find('input[id=draggable-box-position]').val('left: ' + $(this).css('left') + '; top: ' + $(this).css('top'));
      }
    });
  }

  this.initFilePicker = function (options) {
    $('input[type=file]').fileinput(options);
  };
}
