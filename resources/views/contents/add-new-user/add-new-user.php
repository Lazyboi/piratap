<?php

use App\UserManagement;
use LPU\Form;
use LPU\Route;

if (Form::validate(['username', 'password', 'confirm_password', 'first_name', 'last_name', 'email_addresses', 'departments', 'add_new_user'])) {
    UserManagement::addNewUser();
}

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">User Details </h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <!-- <div class="form-header">
        <?php Form::displayNotes(); ?>
      </div> -->
      <?php Form::displayMessage(); ?>
      <div class="form-group <?php Form::displayFieldState('username', 'state'); ?>">
        <label class="col-sm-2 control-label" for="username"><span class="text-danger">*</span> Username</label>
        <div class="col-sm-10">
          <input autocomplete="off" autofocus class="form-control" id="username" name="username" required type="text" value="<?php Form::loadFieldData('username'); ?>">
          <?php Form::displayFieldState('username', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('password', 'state'); ?>">
        <label class="col-sm-2 control-label" for="password"><span class="text-danger">*</span> Password</label>
        <div class="col-sm-10">
          <input autocomplete="off" class="form-control" id="password" name="password" required type="password" value="<?php Form::loadFieldData('password'); ?>">
          <?php Form::displayFieldState('password', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('confirm_password', 'state'); ?>">
        <label class="col-sm-2 control-label" for="confirm-password"><span class="text-danger">*</span> Confirm Password</label>
        <div class="col-sm-10">
          <input autocomplete="off" class="form-control" id="confirm-password" name="confirm_password" required type="password" value="<?php Form::loadFieldData('confirm_password'); ?>">
          <?php Form::displayFieldState('confirm_password', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('first_name', 'state'); ?>">
        <label class="col-sm-2 control-label" for="first-name"><span class="text-danger">*</span> First Name</label>
        <div class="col-sm-10">
          <input autocomplete="off" class="form-control" id="first-name" name="first_name" required type="text" value="<?php Form::loadFieldData('first_name'); ?>">
          <?php Form::displayFieldState('first_name', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('middle_name', 'state'); ?>">
        <label class="col-sm-2 control-label" for="middle-name">Middle Name</label>
        <div class="col-sm-10">
          <input autocomplete="off" class="form-control" id="middle-name" name="middle_name" type="text" value="<?php Form::loadFieldData('middle_name'); ?>">
          <?php Form::displayFieldState('middle_name', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('last_name', 'state'); ?>">
        <label class="col-sm-2 control-label" for="last-name"><span class="text-danger">*</span> Last Name</label>
        <div class="col-sm-10">
          <input autocomplete="off" class="form-control" id="last-name" name="last_name" required type="text" value="<?php Form::loadFieldData('last_name'); ?>">
          <?php Form::displayFieldState('last_name', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('birthdate', 'state'); ?>">
        <label class="col-sm-2 control-label" for="birthdate">Birthdate</label>
        <div class="col-sm-10">
          <input autocomplete="off" class="form-control" id="birthdate" name="birthdate" type="date" value="<?php Form::loadFieldData('birthdate'); ?>">
          <?php Form::displayFieldState('birthdate', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('gender', 'state'); ?>">
        <label class="col-sm-2 control-label">Gender</label>
        <div class="col-sm-10">
          <?php UserManagement::displayGenderRadio('gender', Form::getFieldData('gender')); ?>
          <?php Form::displayFieldState('gender', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('email_addresses', 'state'); ?>">
        <label class="col-sm-2 control-label" for="email-addresses">
          <span class="text-danger">*</span> Email Address(es)
          <div class="hint">(For multiple email addresses, separate each email address with a comma)</div>
        </label>
        <div class="col-sm-10">
          <input autocomplete="off" class="form-control" id="email-addresses" multiple name="email_addresses" placeholder="e.g. juan.delacruz@lpunetwork.edu.ph, juan.delacruz@gmail.com" required type="email" value="<?php Form::loadFieldData('email_addresses'); ?>">
          <?php Form::displayFieldState('email_addresses', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('departments', 'state'); ?>">
        <label class="col-sm-2 control-label">
          <span class="text-danger">*</span> Department(s)
          <div class="hint">(Multiple selection is allowed)</div>
        </label>
        <div class="col-sm-10">
          <select class="form-control" multiple="multiple" name="departments[]" required size="15">
            <?php UserManagement::displayDepartmentSelect(Form::getFieldData('departments')); ?>
          </select>
          <?php Form::displayFieldState('departments', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('roles', 'state'); ?>">
        <label class="col-sm-2 control-label">
          Role(s)
          <div class="hint">(Multiple selection is allowed)</div>
        </label>
        <div class="col-sm-10">
          <select class="form-control" multiple="multiple" name="roles[]" size="10">
            <?php UserManagement::displayRoleSelect(Form::getFieldData('roles')); ?>
          </select>
          <?php Form::displayFieldState('roles', 'message'); ?>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
        Go Back
      </a>
      <button class="btn bg-harvard-red pull-right" name="add_new_user" type="submit">Save New User</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
