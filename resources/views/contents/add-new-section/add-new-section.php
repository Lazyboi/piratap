<?php

use App\Academics;
use LPU\Form;
use LPU\Route;

if (Form::validate(['name', 'add_new_section'])) {
    Academics::addNewSection();
}

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Section Details</h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <!-- <div class="form-header">
        <?php Form::displayNotes(); ?>
      </div> -->
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
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
        Go Back
      </a>
      <button class="btn bg-harvard-red pull-right" name="add_new_section" type="submit">Save New Section</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
