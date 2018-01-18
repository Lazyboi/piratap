<?php

use App\ComputerLaboratory;
use LPU\Form;
use LPU\Route;

ComputerLaboratory::validateLaboratory();

if (Form::validate(['laboratory_layouts', 'edit_laboratory_layout'])) {
    ComputerLaboratory::editLaboratoryLayout();
}

ComputerLaboratory::loadLaboratoryFieldData();

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Laboratory Details <span class="pull-right"><i class="fa fa-caret-down"></i></span></h3>
  </div>
  <form method="POST">
    <div class="box-body">
      <div class="form-header">
        <?php Form::displayNotes(); ?>
      </div>
      <?php Form::displayMessage(); ?>
      <div class="form-group">
        <label>Name:</label>
        <div>S201</div>
      </div>
      <div class="form-group">
        <label>Description: </label>
        <div>S201</div>
      </div>
      <div class="form-group <?php Form::displayFieldState('name', 'state'); ?>">
        <label for="name">
          <span class="text-danger">*</span> Current Layout
          <div class="hint">(Drag the boxes to change position)</div>
        </label>
        <div class="draggable-box-layout">
          <?php ComputerLaboratory::displayComputerDraggableBox(); ?>
        </div>
        <?php Form::displayFieldState('name', 'message'); ?>
      </div>
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
        <i class="fa fa-angle-double-left"></i> Back
      </a>
      <button class="btn bg-olive pull-right" name="edit_laboratory_layout" type="submit">Save Laboratory Layout</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
