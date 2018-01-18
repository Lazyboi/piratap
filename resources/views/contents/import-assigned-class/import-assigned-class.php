<?php

use App\ComputerLaboratory;
use LPU\Form;
use LPU\Route;

ComputerLaboratory::validateAssignedClass('import');

if (Form::validate(['import_class'])) {
    ComputerLaboratory::importAssignedClass();
}

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Class Details <span class="pull-right"><i class="fa fa-caret-down"></i></span></h3>
  </div>
  <form class="form-horizontal" enctype="multipart/form-data" method="POST">
    <div class="box-body">
      <div class="form-header">
        <?php Form::displayNotes(); ?>
      </div>
      <?php Form::displayMessage(); ?>
      <div class="form-group <?php Form::displayFieldState('official_class_list', 'state'); ?>">
        <label class="col-sm-2 control-label">
          <span class="text-danger">*</span> Official Class List
          <div class="hint">(Only excel files downloaded from AIMS are allowed)</div>
        </label>
        <div class="col-sm-10">
          <input accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,.xls,.xlsx" name="official_class_list" required type="file">
          <?php Form::displayFieldState('official_class_list', 'message'); ?>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
        <i class="fa fa-angle-double-left"></i> Back
      </a>
      <button class="btn bg-olive pull-right" name="import_class" type="submit">Import Class</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
