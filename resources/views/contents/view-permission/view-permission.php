<?php

use App\UserManagement;
use LPU\Route;

UserManagement::validatePermission();
UserManagement::loadPermissionData();

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Permission Details</h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="detail">
        <div class="row detail-info">
          <div class="col-sm-12 detail-col">
            <div>
              <label>ID</label>
              <div><?php UserManagement::displayPermissionData('id'); ?></div>
            </div>
            <hr>
            <div>
              <label>Name</label>
              <div><?php UserManagement::displayPermissionData('name'); ?></div>
            </div>
            <hr>
            <div>
              <label>Slug</label>
              <div><?php UserManagement::displayPermissionData('slug'); ?></div>
            </div>
            <hr>
            <div>
              <label>Category</label>
              <div><?php UserManagement::displayPermissionData('id'); ?></div>
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
