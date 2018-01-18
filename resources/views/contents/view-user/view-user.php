<?php

use App\UserManagement;
use LPU\Route;

UserManagement::validateUser();
UserManagement::loadUserData();

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">User Details</h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="detail">
        <div class="row detail-info">
          <div class="col-sm-12 detail-col">
            <div>
              <label>ID</label>
              <div><?php UserManagement::displayUserData('id'); ?></div>
            </div>
            <hr>
            <div>
              <label>Username</label>
              <div><?php UserManagement::displayUserData('username'); ?></div>
            </div>
            <hr>
            <div>
              <label>First Name</label>
              <div><?php UserManagement::displayUserData('first_name'); ?></div>
            </div>
            <hr>
            <div>
              <label>Middle Name</label>
              <div><?php UserManagement::displayUserData('middle_name'); ?></div>
            </div>
            <hr>
            <div>
              <label>Last Name</label>
              <div><?php UserManagement::displayUserData('last_name'); ?></div>
            </div>
            <hr>
            <div>
              <label>Birthdate</label>
              <div><?php UserManagement::displayUserData('birthdate'); ?></div>
            </div>
            <hr>
            <div>
              <label>Gender</label>
              <div><?php UserManagement::displayUserData('gender'); ?></div>
            </div>
            <hr>
            <div>
              <label>Email Address(es)</label>
              <div><?php UserManagement::displayUserData('email_addresses'); ?></div>
            </div>
            <hr>
            <div>
              <label>Department(s)</label>
              <div><?php UserManagement::displayUserData('departments'); ?></div>
            </div>
            <hr>
            <div>
              <label>Role(s)</label>
              <div><?php UserManagement::displayUserData('roles'); ?></div>
            </div>
            <hr>
            <div>
              <label>Created By</label>
              <div><?php UserManagement::displayUserData('created_by'); ?></div>
            </div>
            <hr>
            <div>
              <label>Updated By</label>
              <div><?php UserManagement::displayUserData('updated_by'); ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
        <i class="fa fa-angle-double-left"></i> Back
      </a>
    </div>
  </form>
</div>
