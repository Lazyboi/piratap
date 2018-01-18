<?php

use App\Academics;
use LPU\Route;

Academics::validateCourse();
Academics::loadCourseData();

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Course Details <span class="pull-right"><i class="fa fa-caret-down"></i></span></h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="detail">
        <div class="row detail-info">
          <div class="col-sm-12 detail-col">
            <div>
              <label>ID</label>
              <div><?php Academics::displayCourseData('id'); ?></div>
            </div>
            <hr>
            <div>
              <label>Name</label>
              <div><?php Academics::displayCourseData('name'); ?></div>
            </div>
            <hr>
            <div>
              <label>Description</label>
              <div><?php Academics::displayCourseData('description'); ?></div>
            </div>
            <hr>
            <div>
              <label>Department</label>
              <div><?php Academics::displayCourseData('department'); ?></div>
            </div>
            <hr>
            <div>
              <label>Created By</label>
              <div><?php Academics::displayCourseData('created_by'); ?></div>
            </div>
            <hr>
            <div>
              <label>Updated By</label>
              <div><?php Academics::displayCourseData('updated_by'); ?></div>
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
