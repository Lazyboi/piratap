function Table() {
  var toggleItemCheckbox = $('.toggle-item-checkbox');
  var itemCheckbox = $('.item-checkbox');

  this.initItemCheckbox = function () {
    if (toggleItemCheckbox.length) {
      toggleItemCheckbox.click(function () {
        var selectedItemCheckbox = $(this);

        if (itemCheckbox.length) {
          toggleItemCheckbox.each(function () {
            $(this).prop('checked', selectedItemCheckbox.prop('checked'));
          });

          itemCheckbox.each(function () {
            $(this).prop('checked', selectedItemCheckbox.prop('checked'));
          });
        }
      });
    }
  };
}
