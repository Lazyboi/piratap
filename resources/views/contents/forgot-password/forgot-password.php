<?php

use App\Authentication;
use App\Preferences;
use LPU\Form;
use LPU\Route;

Authentication::sendResetPasswordLink();

?>
<div class="forgot-password-box">
  <div class="forgot-password-box-body">
    <div class="forgot-password-logo">
      <!-- <a href="<?php Route::loadURL('forgot-password'); ?>">
        <img src="/img/logos/login-logo.png" alt="LPU Essentials Logo">
      </a> -->
    </div>
    <div class="forgot-password-box-msg <?php Form::displayState('state', Form::checkState('state', true)); ?>">
      <h4><?php Form::displayState('title', Form::checkState('title', true)); ?></h4>
      <p><?php Form::displayState('description', Form::checkState('description', true)); ?></p>
    </div>
    <form action="" method="post">
      <div class="form-group <?php Form::displayFieldState('email_address', 'state'); ?>">
        <input autocomplete="off" autofocus class="form-control" name="email_address" placeholder="Email Address" required type="email" value="<?php Form::loadFieldData('email_address'); ?>">
        <?php Form::displayFieldState('email_address', 'message'); ?>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button class="btn btn-block btn-submit" name="submit" type="submit">SUBMIT</button>
        </div>
      </div>
    </form>
    <div class="forgot-password-box-link">
      <a href="<?php Route::loadURL('login'); ?>"><i class="fa fa-arrow-circle-left fa-fw"></i> Return to login page</a>
    </div>
    <div class="forgot-password-box-footer">
      <p><?php Preferences::displaySystemPreferenceData('footer_copyright', 'value'); ?></p>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
