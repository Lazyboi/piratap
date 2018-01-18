<?php

use App\UserManagement;
use App\Academics;
use LPU\Route;

UserManagement::validatePermission();
Academics::loadClassListData();

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Class List Details </h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="detail">
        <div class="row detail-info">
          <div class="col-sm-12 detail-col">
            <div>
              <label>ID</label>
              <div><?php Academics::displayClassListData('id'); ?></div>
            </div>
            <hr>
            <div>
              <label>Subject</label>
              <div><?php Academics::displayClassListData('subject'); ?></div>
            </div>
            <hr>
            <div>
              <label>Student(s)</label>
              <div><?php Academics::displayClassListData('students'); ?></div>
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
