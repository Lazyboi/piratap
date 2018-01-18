<?php

use App\Ticketing;
use App\UserManagement;
use LPU\Form;
use LPU\Route;

Ticketing::validateUnit();

if (Form::validate(['name', 'edit_unit'])) {
    Ticketing::editUnit();
} else {
    Ticketing::loadUnitFieldData();
}

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Unit Details <span class="pull-right"><i class="fa fa-caret-down"></i></span></h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="form-header">
        <?php Form::displayNotes(); ?>
      </div>
      <?php Form::displayMessage(); ?>
      <div class="form-group <?php Form::displayFieldState('name', 'state'); ?>">
        <label class="col-sm-2 control-label" for="name"><span class="text-danger">*</span> Name</label>
        <div class="col-sm-10">
          <input autocomplete="off" autofocus class="form-control" id="name" name="name" required type="text" value="<?php Form::loadFieldData('name'); ?>">
          <?php Form::displayFieldState('name', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('description', 'state'); ?>">
        <label class="col-sm-2 control-label" for="description">Description</label>
        <div class="col-sm-10">
          <textarea class="form-control" id="description" name="description"><?php Form::loadFieldData('description'); ?></textarea>
          <?php Form::displayFieldState('description', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('services', 'state'); ?>">
        <label class="col-sm-2 control-label">
          Service(s)
          <div class="hint">(Multiple selection is allowed)</div>
        </label>
        <div class="col-sm-10">
          <select class="form-control" multiple="multiple" name="services[]" size="15">
            <?php Ticketing::displayServiceSelect(Form::getFieldData('services')); ?>
          </select>
          <?php Form::displayFieldState('services', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('members', 'state'); ?>">
        <label class="col-sm-2 control-label">
          Member(s)
          <div class="hint">(Multiple selection is allowed)</div>
        </label>
        <div class="col-sm-10">
          <select class="form-control" multiple="multiple" name="members[]" size="15">
            <?php UserManagement::displayUserSelect(Form::getFieldData('members')); ?>
          </select>
          <?php Form::displayFieldState('members', 'message'); ?>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
        <i class="fa fa-angle-double-left"></i> Back
      </a>
      <button class="btn bg-olive pull-right" name="edit_unit" type="submit">Save Unit Changes</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
