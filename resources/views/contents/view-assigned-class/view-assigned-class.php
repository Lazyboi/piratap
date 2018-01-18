<?php

use App\ComputerLaboratory;
use LPU\Route;

ComputerLaboratory::validateAssignedClass('view');
ComputerLaboratory::loadAssignedClassData();

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
              <div><?php ComputerLaboratory::displayAssignedClassData('id'); ?></div>
            </div>
            <hr>
            <div>
              <label>Laboratory</label>
              <div><?php ComputerLaboratory::displayAssignedClassData('laboratory'); ?></div>
            </div>
            <hr>
            <div>
              <label>Section</label>
              <div><?php ComputerLaboratory::displayAssignedClassData('section'); ?></div>
            </div>
            <hr>
            <div>
              <label>Subject</label>
              <div><?php ComputerLaboratory::displayAssignedClassData('subject'); ?></div>
            </div>
            <hr>
            <div>
              <label>Schedule(s)</label>
              <div><?php ComputerLaboratory::displayAssignedClassData('schedules'); ?></div>
            </div>
            <hr>
            <div>
              <label>Imported By</label>
              <div><?php ComputerLaboratory::displayAssignedClassData('imported_by'); ?></div>
            </div>
            <hr>
            <div>
              <label>Finalized By</label>
              <div><?php ComputerLaboratory::displayAssignedClassData('finalized_by'); ?></div>
            </div>
            <hr>
            <div>
              <label>Created By</label>
              <div><?php ComputerLaboratory::displayAssignedClassData('created_by'); ?></div>
            </div>
            <hr>
            <div>
              <label>Updated By</label>
              <div><?php ComputerLaboratory::displayAssignedClassData('updated_by'); ?></div>
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
