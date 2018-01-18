<?php

use App\Academics;
use LPU\Route;

Academics::validateSection();
Academics::loadSectionData();

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Section Details</h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="detail">
        <div class="row detail-info">
          <div class="col-sm-12 detail-col">
            <div>
              <label>ID</label>
              <div><?php Academics::displaySectionData('id'); ?></div>
            </div>
            <hr>
            <div>
              <label>Name</label>
              <div><?php Academics::displaySectionData('name'); ?></div>
            </div>
            <hr>
            <div>
              <label>Description</label>
              <div><?php Academics::displaySectionData('description'); ?></div>
            </div>
            <hr>
            <div>
              <label>Created By</label>
              <div><?php Academics::displaySectionData('created_by'); ?></div>
            </div>
            <hr>
            <div>
              <label>Updated By</label>
              <div><?php Academics::displaySectionData('updated_by'); ?></div>
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
