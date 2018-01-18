<?php

use App\Ticketing;
use LPU\Route;

Ticketing::validatePriority();
Ticketing::loadPriorityData();

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Priority Details <span class="pull-right"><i class="fa fa-caret-down"></i></span></h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="detail">
        <div class="row detail-info">
          <div class="col-sm-12 detail-col">
            <div>
              <label>ID</label>
              <div><?php Ticketing::displayPriorityData('id'); ?></div>
            </div>
            <hr>
            <div>
              <label>Name</label>
              <div><?php Ticketing::displayPriorityData('name'); ?></div>
            </div>
            <hr>
            <div>
              <label>Response Time</label>
              <div><?php Ticketing::displayPriorityData('response_time'); ?></div>
            </div>
            <hr>
            <div>
              <label>Color</label>
              <div><?php Ticketing::displayPriorityData('color'); ?></div>
            </div>
            <hr>
            <div>
              <label>Created By</label>
              <div><?php Ticketing::displayPriorityData('created_by'); ?></div>
            </div>
            <hr>
            <div>
              <label>Updated By</label>
              <div><?php Ticketing::displayPriorityData('updated_by'); ?></div>
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
