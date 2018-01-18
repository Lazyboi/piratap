<?php
/* Require the autoloader for the app to work properly. */
require __DIR__ . '/../vendor/autoload.php';

use App\Preferences;
use App\UserManagement;
use LPU\Application;
use LPU\Config;
use LPU\Database;
use LPU\Permission;
use LPU\Placeholder;
use LPU\Route;
use LPU\Session;

// echo password_hash('test', PASSWORD_DEFAULT);

/* Setup the configuration */
Config::setup();

/* Start the application. */
Application::start();

/* Start the application session. */
Session::start();

/* Start the database connection before the page is loaded to globalize the connection. */
/* This would prevent reinitialization of database when needed during the loading. */
Database::startConnection();

/* Load all permissions of the current authenticated user. */
Permission::load();

/* Setup the route configuration */
Route::setup();

/* Validate the route. */
Route::validate();

/* Validate the route authentication. */
Route::validateAuthentication();

/* Validate the route permission. */
Route::validatePermission();

/* Setup the placeholder */
Placeholder::setup();

/* Load the system preference data. */
Preferences::loadSystemPreferenceData();

/* Load the user profile data of the current authenticated user. */
UserManagement::loadUserProfileData();

/*
echo '<div>';
foreach (Route::get() as $key => $value) {
    if ($value['data']['permission']) {
        echo "INSERT INTO `umg_permissions` (`name`, `slug`) VALUES ('{$value['name']}', '{$key}');";
    }
}
echo '</div>';
for ($a = 1; $a <= 100; $a++) {
    echo "INSERT INTO `umg_roles_permissions` (`permission_id`, `role_id`) VALUES ('{$a}', '1');";
}

for ($a = 101; $a <= 141; $a++) {
    echo "INSERT INTO `umg_roles_permissions` (`permission_id`, `role_id`) VALUES ('{$a}', '1');";
}

for ($a = 141; $a <= 200; $a++) {
    echo "INSERT INTO `umg_roles_permissions` (`permission_id`, `role_id`) VALUES ('{$a}', '1');";
}
*/
?>
<!DOCTYPE html>
<html lang="<?php Preferences::displaySystemPreferenceData('html_content_language', 'value'); ?>">

<head>
  <!-- Meta Settings (SEO) -->
  <meta charset="<?php Preferences::displaySystemPreferenceData('meta_charset', 'value'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE-edge">
  <meta name="application-name" content="<?php Preferences::displaySystemPreferenceData('meta_application_name', 'value'); ?>">
  <meta name="description" content="<?php Preferences::displaySystemPreferenceData('meta_description', 'value'); ?>">
  <meta name="keywords" content="<?php Preferences::displaySystemPreferenceData('meta_keywords', 'value'); ?>">
  <meta name="author" content="<?php Preferences::displaySystemPreferenceData('meta_author', 'value'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <!-- Browser Title -->
  <title><?php Route::displayTitle(); ?></title>

  <!-- Browser Icon -->
  <link rel="icon" type="image/icon" href="/favicon.ico">

  <!-- Load Required Styles -->
  <link rel="stylesheet" href="/css/bjTKDTjDRVbgy6nQ.css">

  <!-- IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="/js/U7VuDNHHWzU8x6FX.js"></script>
  <![endif]-->
</head>

<body background="~/public/img/backgrounds/1.png" class="hold-transition <?php Route::displayClass(); ?>">
  <div class="layout">
    <?php Route::displayLayout();?>
  </div>

  <!-- Load Required Scripts -->
  <script src="/js/3EeG8zeF69hbJNUL.js"></script>
</body>

</html>
<?php
/* End the database connection after the page was loaded. */
Database::endConnection();
?>
