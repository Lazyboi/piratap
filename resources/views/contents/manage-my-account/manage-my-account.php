<?php

use App\UserManagement;
use LPU\Authentication;
use LPU\Form;
use LPU\Path;
use LPU\Route;
use LPU\Url;

Route::validateTabs();

if (Form::validate(['first_name', 'last_name', 'edit_profile'])) {
    UserManagement::editProfile();
}

if (Route::currentData() == 'edit-profile') {
    if (Form::validate(['first_name', 'last_name', 'edit_profile'])) {
        UserManagement::editProfile();
    } else {
        UserManagement::getUserProfileFieldData();
    }
}

if (Route::currentData() == 'change-password') {
    if (Form::validate(['new_password', 'confirm_new_password', 'change_password'])) {
        UserManagement::changePassword();
    }
}

?>
<div class="row">
  <div class="col-md-8">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <?php Route::displayTabs(); ?>
      </ul>
      <div class="tab-content">
        <div class="active tab-pane">

          <?php if (Route::currentData() == 'edit-profile'): ?>
            <form class="form-horizontal" method="POST">

              <?php Form::displayMessage(); ?>
              <div class="form-group <?php Form::displayFieldState('first_name', 'state'); ?>">
                <label class="col-sm-2 control-label" for="first_name"><span class="text-danger">*</span> First Name</label>
                <div class="col-sm-10">
                  <input autocomplete="off" autofocus class="form-control" id="first_name" name="first_name" required type="text" value="<?php Form::loadFieldData('first_name'); ?>">
                  <?php Form::displayFieldState('first_name', 'message'); ?>
                </div>
              </div>
              <div class="form-group <?php Form::displayFieldState('middle_name', 'state'); ?>">
                <label class="col-sm-2 control-label" for="middle_name">Middle Name</label>
                <div class="col-sm-10">
                  <input autocomplete="off" class="form-control" id="middle_name" name="middle_name" type="text" value="<?php Form::loadFieldData('middle_name'); ?>">
                  <?php Form::displayFieldState('middle_name', 'message'); ?>
                </div>
              </div>
              <div class="form-group <?php Form::displayFieldState('last_name', 'state'); ?>">
                <label class="col-sm-2 control-label" for="last_name"><span class="text-danger">*</span> Last Name</label>
                <div class="col-sm-10">
                  <input autocomplete="off" class="form-control" id="last_name" name="last_name" required type="text" value="<?php Form::loadFieldData('last_name'); ?>">
                  <?php Form::displayFieldState('last_name', 'message'); ?>
                </div>
              </div>
              <div class="form-group <?php Form::displayFieldState('birthdate', 'state'); ?>">
                <label class="col-sm-2 control-label" for="birthdate">
                  Birthdate
                </label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <input autocomplete="off" class="form-control" datepicker id="birthdate" name="birthdate" type="text" value="<?php Form::loadFieldData('birthdate'); ?>">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
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
                  <!-- <div class="hint">(Multiple email address is allowed)</div> -->
                </label>
                <div class="col-sm-10">
                  <input autocomplete="off" class="form-control" data-role="" id="email-addresses" multiple name="email_addresses" required type="email" value="<?php Form::loadFieldData('email_addresses'); ?>">
                  <?php Form::displayFieldState('email_addresses', 'message'); ?>
                </div>
              </div>
              <div class="form-group <?php Form::displayFieldState('password', 'state'); ?>">
                <label class="col-sm-2 control-label" for="password">
                  <span class="text-danger">*</span> Password
                  <div class="hint">(For security purposes)</div>
                </label>
                <div class="col-sm-10">
                  <input autocomplete="off" class="form-control" id="password" name="password" required type="password" value="<?php Form::loadFieldData('password'); ?>">
                  <?php Form::displayFieldState('password', 'message'); ?>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button class="btn bg-harvard-red" name='edit_profile' type="submit">Save Changes</button>
                </div>
              </div>
            </form>
            <?php Form::clearState(true);?>
          <?php endif; ?>
          <?php if (Route::currentData() == 'change-password'): ?>
            <form class="form-horizontal" method="POST">

              <?php Form::displayMessage(); ?>
              <div class="form-group <?php Form::displayFieldState('current_password', 'state'); ?>">
                <label class="col-sm-2 control-label" for="current-password"><span class="text-danger">*</span> Current Password</label>
                <div class="col-sm-10">
                  <input autocomplete="off" autofocus class="form-control" id="current-password" name="current_password" required type="password" value="<?php Form::loadFieldData('current_password'); ?>">
                  <?php Form::displayFieldState('current_password', 'message'); ?>
                </div>
              </div>
              <div class="form-group <?php Form::displayFieldState('new_password', 'state'); ?>">
                <label class="col-sm-2 control-label" for="new-password"><span class="text-danger">*</span> New Password</label>
                <div class="col-sm-10">
                  <input autocomplete="off" class="form-control" id="new-password" name="new_password" required type="password" value="<?php Form::loadFieldData('new_password'); ?>">
                  <?php Form::displayFieldState('new_password', 'message'); ?>
                </div>
              </div>
              <div class="form-group <?php Form::displayFieldState('confirm_new_password', 'state'); ?>">
                <label class="col-sm-2 control-label" for="confirm-new-password"><span class="text-danger">*</span> Confirm New Password</label>
                <div class="col-sm-10">
                  <input autocomplete="off" class="form-control" id="confirm-new-password" name="confirm_new_password" required type="password" value="<?php Form::loadFieldData('confirm_new_password'); ?>">
                  <?php Form::displayFieldState('confirm_new_password', 'message'); ?>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button class="btn bg-harvard-red" name='change_password' type="submit">Change Password</button>
                </div>
              </div>
            </form>
            <?php Form::clearState(true);?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box box-solid">
      <div class="box-header">
        <h3 class="box-title">User Information <span class="pull-right"></h3>
      </div>
      <div class="box-body box-profile">
        <!-- <?php if (file_exists(Path::getUserImage(Authentication::getAuthenticatedUser()))): ?>
          <img alt="User Profile Picture" class="profile-user-img img-responsive img-circle" src="<?php echo Url::getUserImage(Authentication::getAuthenticatedUser()); ?>">
        <?php else: ?>
          <img alt="User Profile Picture" class="profile-user-img img-responsive img-circle" src="<?php echo Url::getUserImage('default_1'); ?>">
        <?php endif; ?> -->
        <!-- <div class="profile-upload">
          <form enctype="multipart/form-data" method="POST">
            <input accept=".jpg,.jpeg,.png,.gif" name="profile_picture" type="file">
          </form>
        </div> -->
        <h3 class="text-center profile-username"><b><?php UserManagement::displayUserProfileData('name'); ?></b></h3>
        <hr>
        <label>Student Number</label>
        <div><?php UserManagement::displayUserProfileData('username'); ?></div>
        <hr>
        <label>First Name</label>
        <div><?php UserManagement::displayUserProfileData('first_name'); ?></div>
        <hr>
        <label>Middle Name</label>
        <div><?php UserManagement::displayUserProfileData('middle_name'); ?></div>
        <hr>
        <label>Last Name</label>
        <div><?php UserManagement::displayUserProfileData('last_name'); ?></div>
        <hr>
        <label>Birthdate</label>
        <div><?php UserManagement::displayUserProfileData('birthdate'); ?></div>
        <hr>
        <label>Gender</label>
        <div><?php UserManagement::displayUserProfileData('gender'); ?></div>
        <hr>
        <label>Department(s)</label>
        <div class="box-list"><?php UserManagement::displayUserProfileData('departments'); ?></div>
      </div>
    </div>
    <div class="box box-solid">
      <div class="box-header">
        <h3 class="box-title">Account Details</h3>
      </div>
      <div class="box-body">
        <hr>
        <label>Created At</label>
        <div><?php UserManagement::displayUserProfileData('created_at'); ?></div>
        <hr>
        <label>Last Update</label>
        <div><?php UserManagement::displayUserProfileData('updated_at'); ?></div>
      </div>
    </div>
  </div>
</div>
