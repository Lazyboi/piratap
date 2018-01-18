<?php

use App\UserManagement;
use LPU\Route;

UserManagement::validateDepartment();
UserManagement::loadDepartmentData();

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Department Details</h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="detail">
        <div class="row detail-info">
          <div class="col-sm-12 detail-col">
            <div>
              <label>ID</label>
              <div><?php UserManagement::displayDepartmentData('id'); ?></div>
            </div>
            <hr>
            <div>
              <label>Name</label>
              <div><?php UserManagement::displayDepartmentData('name'); ?></div>
            </div>
            <hr>
            <div>
              <label>Acronym</label>
              <div><?php UserManagement::displayDepartmentData('acronym'); ?></div>
            </div>
            <hr>
            <div>
              <label>Description</label>
              <div><?php UserManagement::displayDepartmentData('description'); ?></div>
            </div>
            <hr>
            <div>
              <label>Created By</label>
              <div><?php UserManagement::displayDepartmentData('created_by'); ?></div>
            </div>
            <hr>
            <div>
              <label>Updated By</label>
              <div><?php UserManagement::displayDepartmentData('updated_by'); ?></div>
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
