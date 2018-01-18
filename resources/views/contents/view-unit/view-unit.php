<?php

use App\Ticketing;
use LPU\Route;

Ticketing::validateUnit();
Ticketing::loadUnitData();

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Unit Details <span class="pull-right"><i class="fa fa-caret-down"></i></span></h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="detail">
        <div class="row detail-info">
          <div class="col-sm-12 detail-col">
            <div>
              <label>ID</label>
              <div><?php Ticketing::displayUnitData('id'); ?></div>
            </div>
            <hr>
            <div>
              <label>Name</label>
              <div><?php Ticketing::displayUnitData('name'); ?></div>
            </div>
            <hr>
            <div>
              <label>Description</label>
              <div><?php Ticketing::displayUnitData('description'); ?></div>
            </div>
            <hr>
            <div>
              <label>Service(s)</label>
              <div><?php Ticketing::displayUnitData('services'); ?></div>
            </div>
            <hr>
            <div>
              <label>Member(s)</label>
              <div><?php Ticketing::displayUnitData('members'); ?></div>
            </div>
            <hr>
            <div>
              <label>Created By</label>
              <div><?php Ticketing::displayUnitData('created_by'); ?></div>
            </div>
            <hr>
            <div>
              <label>Updated By</label>
              <div><?php Ticketing::displayUnitData('updated_by'); ?></div>
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
