<?php

use App\UserManagement;
use LPU\Form;
use LPU\Route;

//ComputerLaboratory::validateAssignedClass('import');

if (Form::validate(['import_class'])) {
    UserManagement::importUser();
}

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Import User</h3>
  </div>
  <form class="form-horizontal" enctype="multipart/form-data" method="POST">
    <div class="box-body">

      <?php Form::displayMessage(); ?>
      <div class="form-group <?php Form::displayFieldState('class_list', 'state'); ?>">
        <label class="col-sm-2 control-label">
          <span class="text-danger">*</span> Class List
        </label>
        <div class="col-sm-10">
          <input accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,.xls,.xlsx" name="class_list" required type="file">
          <?php Form::displayFieldState('class_list', 'message'); ?>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
Go Back
      </a>
      <button class="btn bg-harvard-red pull-right" name="import_class" type="submit">Import User</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
