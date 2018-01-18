<?php

use App\Academics;
use App\UserManagement;
use LPU\Form;
use LPU\Route;

if (Form::validate(['subject', 'section', 'professor', 'subject_type', 'days', 'started_at', 'ended_at', 'room', 'add_new_class'])) {
    Academics::addNewClass();
}

?>
<div class="box box-solid">
  <div class="box-header">
    <h2 class="box-title">Class Details</h2>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">

<?php Form::displayMessage(); ?>

      <!--Subject Name-->
      <div class="form-group <?php Form::displayFieldState('subject', 'state'); ?>">
        <label class="col-sm-2 control-label"><span class="text-danger">*</span> Subject</label>
        <div class="col-sm-10">
          <select class="form-control" name="subject" required size="10">
            <?php Academics::displaySubjectSelect(Form::getFieldData('subject')); ?>
          </select>
          <?php Form::displayFieldState('subject', 'message'); ?>
        </div>
      </div>

      <!--Section Name-->
      <div class="form-group <?php Form::displayFieldState('section', 'state'); ?>">
        <label class="col-sm-2 control-label"><span class="text-danger">*</span> Section</label>
        <div class="col-sm-10">
          <select class="form-control" name="section" required size="10">
            <?php Academics::displaySectionSelect(Form::getFieldData('section')); ?>
          </select>
          <?php Form::displayFieldState('section', 'message'); ?>
        </div>
      </div>

      <!--Professor Name-->
      <div class="form-group <?php Form::displayFieldState('professor', 'state'); ?>">
        <label class="col-sm-2 control-label"><span class="text-danger">*</span> Professor</label>
        <div class="col-sm-10">
          <select class="form-control" name="professor" required size="10">
            <?php UserManagement::displayFacultySelect(Form::getFieldData('professor')); ?>
          </select>
          <?php Form::displayFieldState('professor', 'message'); ?>
        </div>
      </div>

      <!--Subject Legend-->
      <div class="form-group <?php Form::displayFieldState('subject_type', 'state'); ?>">
        <label class="col-sm-2 control-label"><span class="text-danger">*</span> Subject Legend</label>
        <div class="col-sm-10">
          <select class="form-control" name="subject_type" required size="10">
            <?php Academics::displaySubjectLegendSelect(Form::getFieldData('subject_type')); ?>
          </select>
          <?php Form::displayFieldState('subject_type', 'message'); ?>
        </div>
      </div>

      <!--Days-->
      <div class="form-group <?php Form::displayFieldState('days', 'state'); ?>">
        <label class="col-sm-2 control-label"><span class="text-danger">*</span> Day(s)</label>
        <div class="col-sm-10">
          <select class="form-control" name="days" required size="10">
            <?php Academics::displayDaySelect(Form::getFieldData('days')); ?>
          </select>
          <?php Form::displayFieldState('days', 'message'); ?>
        </div>
      </div>

      <!--Time Start-->
  <div class="form-group <?php Form::displayFieldState('started_at', 'state'); ?>">
    <label class="col-sm-2 control-label">
      <span class="text-danger">*</span> Start Time
    </label>
    <div class="col-sm-10">
      <div class="input-group">
        <input autocomplete="off" class="form-control" timepicker id="started_at" name="started_at" required type="text" value="<?php Form::loadFieldData('started_at'); ?>">
        <span class="input-group-addon"><i class="fa fa-times"></i></span>
        </div>
        <?php Form::displayFieldState('started_at', 'message'); ?>
      </div>
    </div>

    <!--Time end-->
    <div class="form-group <?php Form::displayFieldState('ended_at', 'state'); ?>">
      <label class="col-sm-2 control-label">
        <span class="text-danger">*</span> End Time
      </label>
      <div class="col-sm-10">
        <div class="input-group">
          <input autocomplete="off" class="form-control" timepicker id="ended_at" name="ended_at" required type="text" value="<?php Form::loadFieldData('ended_at'); ?>">
          <span class="input-group-addon"><i class="fa fa-times"></i></span>
          </div>
          <?php Form::displayFieldState('ended_at', 'message'); ?>
        </div>
      </div>

      <!--Room-->
      <div class="form-group <?php Form::displayFieldState('room', 'state'); ?>">
        <label class="col-sm-2 control-label"><span class="text-danger">*</span> Room</label>
        <div class="col-sm-10">
          <select class="form-control" name="room" required size="10">
            <?php Academics::displayRoomSelect(Form::getFieldData('room')); ?>
          </select>
          <?php Form::displayFieldState('room', 'message'); ?>
        </div>
      </div>

    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
       Go Back
      </a>
      <button class="btn bg-harvard-red pull-right" name="add_new_class" type="submit">Save New Class</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
