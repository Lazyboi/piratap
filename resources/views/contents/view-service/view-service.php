<?php

use App\Ticketing;
use LPU\Route;

Ticketing::validateService();
Ticketing::loadServiceData();

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Service Details <span class="pull-right"><i class="fa fa-caret-down"></i></span></h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="detail">
        <div class="row detail-info">
          <div class="col-sm-12 detail-col">
            <div>
              <label>ID</label>
              <div><?php Ticketing::displayServiceData('id'); ?></div>
            </div>
            <hr>
            <div>
              <label>Name</label>
              <div><?php Ticketing::displayServiceData('name'); ?></div>
            </div>
            <hr>
            <div>
              <label>Description</label>
              <div><?php Ticketing::displayServiceData('description'); ?></div>
            </div>
            <hr>
            <div>
              <label>Created By</label>
              <div><?php Ticketing::displayServiceData('created_by'); ?></div>
            </div>
            <hr>
            <div>
              <label>Updated By</label>
              <div><?php Ticketing::displayServiceData('updated_by'); ?></div>
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
