<?php

use LPU\Route;
use LPU\Form;
use App\UserManagement;

UserManagement::validateUser();

if (Form::validate(['new_password', 'confirm_new_password', 'reset_user_password'])) {
    UserManagement::resetUserPassword();
}

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">User Details</h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <!-- <div class="form-header">
        <?php Form::displayNotes(); ?>
      </div> -->
      <?php Form::displayMessage(); ?>
      <div class="form-group <?php Form::displayFieldState('new_password', 'state'); ?>">
        <label class="col-sm-2 control-label" for="new-password"><span class="text-danger">*</span> New Password</label>
        <div class="col-sm-10">
          <input autocomplete="off" autofocus class="form-control" id="new-password" name="new_password" type="password" required value="<?php Form::loadFieldData('new_password'); ?>">
          <?php Form::displayFieldState('new_password', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('confirm_new_password', 'state'); ?>">
        <label class="col-sm-2 control-label" for="confirm-new-password"><span class="text-danger">*</span> Confirm New Password</label>
        <div class="col-sm-10">
          <input autocomplete="off" class="form-control" id="confirm-new-password" name="confirm_new_password" type="password" required value="<?php Form::loadFieldData('confirm_new_password'); ?>">
          <?php Form::displayFieldState('confirm_new_password', 'message'); ?>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
        Go Back
      </a>
      <button class="btn bg-harvard-red pull-right" name="reset_user_password" type="submit">Reset User Password</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
