<?php

use App\ComputerLaboratory;
use LPU\Route;

ComputerLaboratory::validateLaboratory();
ComputerLaboratory::loadLaboratoryData();

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Laboratory Details <span class="pull-right"><i class="fa fa-caret-down"></i></span></h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="detail">
        <div class="row detail-info">
          <div class="col-sm-12 detail-col">
            <div>
              <label>ID</label>
              <div><?php ComputerLaboratory::displayLaboratoryData('id'); ?></div>
            </div>
            <hr>
            <div>
              <label>Name</label>
              <div><?php ComputerLaboratory::displayLaboratoryData('name'); ?></div>
            </div>
            <hr>
            <div>
              <label>Description</label>
              <div><?php ComputerLaboratory::displayLaboratoryData('description'); ?></div>
            </div>
            <hr>
            <div>
              <label>Computer(s)</label>
              <div><?php ComputerLaboratory::displayLaboratoryData('computers'); ?></div>
            </div>
            <hr>
            <div>
              <label>Created By</label>
              <div><?php ComputerLaboratory::displayLaboratoryData('created_by'); ?></div>
            </div>
            <hr>
            <div>
              <label>Updated By</label>
              <div><?php ComputerLaboratory::displayLaboratoryData('updated_by'); ?></div>
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
