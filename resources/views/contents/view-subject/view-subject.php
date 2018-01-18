<?php

use App\Academics;
use LPU\Route;

Academics::validateSubject();
Academics::loadSubjectData();

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Subject Details</h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="detail">
        <div class="row detail-info">
          <div class="col-sm-12 detail-col">
            <div>
              <label>ID</label>
              <div><?php Academics::displaySubjectData('id'); ?></div>
            </div>
            <hr>
            <div>
              <label>Name</label>
              <div><?php Academics::displaySubjectData('name'); ?></div>
            </div>
            <hr>
            <div>
              <label>Description</label>
              <div><?php Academics::displaySubjectData('description'); ?></div>
            </div>
            <hr>
            <div>
              <label>Created By</label>
              <div><?php Academics::displaySubjectData('created_by'); ?></div>
            </div>
            <hr>
            <div>
              <label>Updated By</label>
              <div><?php Academics::displaySubjectData('updated_by'); ?></div>
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
