<?php

use App\Authentication;
use App\Preferences;
use LPU\Form;
use LPU\Route;

Authentication::signIn();

?>
<div class="login-box" background="/img/backgrounds/1.png" alt="Piratap Background">
  <div class="login-box-body">
    <div class="login-logo">
      <a href="<?php Route::loadURL('login'); ?>">
        <img src="/img/users/user-login-default.png" alt="Piratap Login">
      </a>
    </div>

    <div class="login-box-msg <?php Form::displayState('state'); ?>">
      <h4><?php Form::displayState('title'); ?></h4>
      <p><?php Form::displayState('description'); ?></p>
    </div>
    <form action="" method="post">
      <div class="form-group <?php Form::displayFieldState('username', 'state'); ?>">
        <input autocomplete="off" autofocus class="form-control" name="username" placeholder="Username" required type="text" value="<?php Form::loadFieldData('username'); ?>">
        <?php Form::displayFieldState('username', 'message'); ?>
      </div>
      <div class="form-group <?php Form::displayFieldState('password', 'state'); ?>">
        <input autocomplete="off" class="form-control" name="password" placeholder="Password" required type="password" value="<?php Form::loadFieldData('password'); ?>">
        <?php Form::displayFieldState('password', 'message'); ?>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button class="btn btn-sign-in" name="sign_in" type="submit">SIGN IN</button>
        </div>
      </div>
    </form>
    <div class="login-box-link">
      <a href="<?php Route::loadURL('forgot-password'); ?>">Forgot your password?</a>
    </div>
    <div class="login-box-footer">
      <p><?php Preferences::displaySystemPreferenceData('footer_copyright', 'value'); ?></p>
    </div>
  </div>
</div>
