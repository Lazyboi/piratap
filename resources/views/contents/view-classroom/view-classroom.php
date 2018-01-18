<?php

use App\UserManagement;
use App\Academics;
use LPU\Route;

UserManagement::validatePermission();
Academics::loadClassData();

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Class Details <span class="pull-right"><i class="fa fa-caret-down"></i></span></h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="detail">
        <div class="row detail-info">
          <div class="col-sm-12 detail-col">
            <div>
              <label>ID</label>
              <div><?php Academics::displayClassData('id'); ?></div>
            </div>
            <hr>
            <div>
              <label>Professor Name</label>
              <div><?php Academics::displayClassData('professor_name'); ?></div>
            </div>
            <hr>
            <div>
              <label>Subject Code</label>
              <div><?php Academics::displayClassData('subject_code'); ?></div>
            </div>
            <hr>
            <div>
              <label>Subject Description</label>
              <div><?php Academics::displayClassData('subject_description'); ?></div>
            </div>
            <hr>
            <div>
              <label>Section</label>
              <div><?php Academics::displayClassData('section'); ?></div>
            </div>
            <hr>
            <div>
              <label>Time</label>
              <div><?php Academics::displayClassData('time'); ?></div>
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
