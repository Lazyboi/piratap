<?php

use LPU\Authentication;
use App\Preferences;
use App\UserManagement;
use LPU\DateTime;
use LPU\Path;
use LPU\Permission;
use LPU\Route;
use LPU\Url;

?>

<div class="wrapper">
  <header class="main-header">
    <a class="logo" href="<?php Route::loadURL('dashboard'); ?>">
      <span class="logo-mini">
        <img src="/img/logos/piratap-logo.png" alt="Piratap Logo">
      </span>
      <span class="logo-lg">
        <img src="/img/logos/header-logo.png" alt="Piratap Logo">
      </span>
    </a>
    <nav class="navbar navbar-static-top">
      <a class="sidebar-toggle" data-toggle="offcanvas" title="Toggle Sidebar" role="button"></a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav nav">
          <!-- <li class="dropdown notifications-menu" title="Notifications">
            <a class="dropdown-toggle" data-toggle="dropdown">
              <i class="glyphicon glyphicon-bell"></i>
              <span class="label label-danger">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 0 notifications</li>
              <li>
                <ul class="menu"></ul>
              </li>
              <li class="footer"><a href="#">View All Notifications</a></li>
            </ul>
          </li> -->

            <li class="">
              <a class
                <span class=""><?php UserManagement::displayUserProfileData('name'); ?></span>
              </a>
            </li>

            <li class="" title="Manage Account ">
              <a href="<?php Route::loadURL("manage-my-account"); ?>">
                <i class="glyphicon glyphicon-user"></i>
              </a>
            </li>


            <li class="" title="Sign Out ">
              <a href="<?php Route::loadURL("logout"); ?>">
                <i class="glyphicon glyphicon-log-out"></i>
              </a>
            </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="info-panel">

      </div>
      <ul class="sidebar-menu">
        <?php Route::displayMenu();?>
      </ul>
    </section>
  </aside>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><?php Route::displayName(Route::current()); ?></h1>
    </section>
    <section class="content">
      <?php Route::displayContent(); ?>
    </section>
  </div>

  <footer class="main-footer">
    <div>
      <ul>
        <li>
          <a href="">About PiraTAP</a>
        </li>
        <li>
          <a href="">Terms and Conditions</a>
        </li>
        <li>
          <a href="">Privacy Policy</a>
        </li>
        <li>
          <a href="" target="_blank">TeamOctago</a>
        </li>
      </ul>
      <?php Preferences::displaySystemPreferenceData('footer_copyright', 'value'); ?>
    </div>
  </footer>
</div>
