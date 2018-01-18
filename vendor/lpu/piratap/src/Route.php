<?php
namespace LPU;

use App\Preferences;

class Route
{
    private static $routes = [];

    /**
     * Set up the route configuration.
     */
    public static function setup()
    {
        self::$routes = include Config::get('path')['base_path'] . '/app/routes.php';
    }

    /**
     * Get the application routes.
     *
     * @return array
     */
    public static function get()
    {
        return self::$routes;
    }

    /**
     * Get the current route.
     *
     * @return string
     */
    public static function current()
    {
        return !empty($_GET['8b04d5e3775d298e78455efc5ca404d5']) ? $_GET['8b04d5e3775d298e78455efc5ca404d5'] : null ;
    }

    /**
     * Get the current route data.
     *
     * @param int $index
     *
     * @return string
     */
    public static function currentData($index = 0)
    {
        switch ($index) {
            case 0:
                $data = 'a9f0e61a137d86aa9db53465e0801612';
                break;
            case 1:
                $data = 'dd5c8bf51558ffcbe5007071908e9524';
                break;
            default:
        }

        if (empty($_GET[$data])) {
            return null;
        }

        return $_GET[$data];
    }

    /**
     * Load the route url.
     *
     * @param string $route
     * @param string $data
     */
    public static function loadURL($route, $data = null)
    {
        echo self::get()[$route]['url'] . ($data ? "/{$data}" : '');
    }

    /**
     * Get the route url.
     *
     * @param string $route
     * @param int $id
     *
     * @return string
     */
    public static function getURL($route, $id = null)
    {
        $url = self::get()[$route]['url'];

        if (!empty($id)) {
            eval("\$url = \"{$url}\";");
            return $url;
        } else {
            return $url;
        }
    }

    /**
     * Proceed to another route.
     *
     * @param string $route
     * @param string $data_one
     * @param string $data_two
     */
    public static function go($route, $data_one = null, $data_two = null)
    {
        header('Location: ' . self::getURL($route) . ($data_one ? "/{$data_one}" : '') . ($data_two ? "/{$data_two}" : ''));
        exit();
    }

    /**
     * Reload the route.
     */
    public static function reload()
    {
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    }

    /**
     * Validate if the current route exist.
     */
    public static function validate()
    {
        if (!array_key_exists(self::current(), self::get())) {
            self::go('login');
        }
    }

    /**
     * Validate if the route needs an authentication to proceed.
     */
    public static function validateAuthentication()
    {
        if (!self::get()[self::current()]['data']['no_auth']) {
            if (!Authentication::authenticateUser(self::current())) {
                self::go('login');
            }
        } else {
            if (Authentication::authenticateUser(self::current())) {
                self::go('dashboard');
            }
        }
    }

    /**
     * Validate if the route needs a permission to proceed.
     */
    public static function validatePermission()
    {
        if (!Permission::can(self::current())) {
            if (empty(self::getParent(self::current()))) {
                self::go('dashboard');
            } else {
                self::go(self::getParent(self::current()));
            }
        }
    }

    /**
     * Get the route name.
     *
     * @param string $route
     *
     * @return string
     */
    public static function getName($route)
    {
        return self::get()[$route]['name'];
    }

    /**
     * Get the route icon.
     *
     * @param string $route
     *
     * @return string
     */
    public static function getIcon($route)
    {
        return self::get()[$route]['icon'];
    }

    /**
     * Get the route parent.
     *
     * @param string $route
     *
     * @return string
     */
    public static function getParent($route)
    {
        return self::get()[$route]['parent'];
    }

    /**
     * Get the route tabs.
     *
     * @param string $route
     *
     * @return string
     */
    public static function getTabs($route)
    {
        return self::get()[$route]['data']['tabs'];
    }

    /**
     * Get the route prerequisite.
     *
     * @param string $route
     *
     * @return string
     */
    public static function getPrerequisite($route)
    {
        return self::get()[$route]['data']['prerequisite'];
    }

    /**
     * Validate if the current route tab exist.
     *
     * @param int $index
     */
    public static function validateTabs($index = 0)
    {
        if (empty(self::getTabs(Route::current())[self::currentData($index)])) {
            switch ($index) {
                case 0:
                    self::go(Route::current(), Route::getTabs(Route::current())[array_keys(self::getTabs(Route::current()))[0]]['url']);
                    break;
                case 1:
                    self::go(Route::current(), Route::currentData(), Route::getTabs(Route::current())[array_keys(self::getTabs(Route::current()))[0]]['url']);
                    break;
                default:
            }
        }
    }

    /**
     * Display the route tabs.
     */
    public static function displayTabs()
    {
        $tabs = '';

        foreach (self::get()[self::current()]['data']['tabs'] as $key => $value) {
            $tabs .= '<li class=\'' . ($key == self::currentData() ? 'active' : '') . '\'>';
            $tabs .= "<a href='{$value['url']}'>{$value['name']}</a>";
            $tabs .= '</li>';
        }

        echo $tabs;
    }

    /**
     * Display the route name.
     *
     * @param string $route
     */
    public static function displayName($route)
    {
        echo self::get()[$route]['name'];
    }

    /**
     * Display  the route description.
     *
     * @param string $route
     */
    public static function displayDescription($route)
    {
        echo self::get()[$route]['description'];
    }

    /**
     * Display the route icon.
     *
     * @param string $route
     */
    public static function displayIcon($route)
    {
        echo self::get()[$route]['icon'];
    }

    /**
     * Display the route title.
     */
    public static function displayTitle()
    {
        echo self::get()[self::current()]['name'];
        echo ' - ';
        echo self::get()[self::current()]['description'];
        echo ' - ';
        Preferences::displaySystemPreferenceData('application_name', 'value');
    }

    /**
     * Display the route class.
     */
    public static function displayClass()
    {
        Preferences::displaySystemPreferenceData('skin_color', 'value');
        echo ' ';
        Preferences::displaySystemPreferenceData('layout', 'value');
        echo ' sidebar-mini ';
        echo self::get()[self::current()]['data']['class'];
    }

    /**
     * Display route layout.
     */
    public static function displayLayout()
    {
        $layouts = include Config::get('path')['base_path'] . '/app/layouts.php';

        foreach ($layouts as $key => $values) {
            if (in_array(self::current(), $values['routes'])) {
                include $values['layout'];
                break;
            }
        }
    }

    /**
     * Display the menu.
     */
    public static function displayMenu()
    {
        $categories = include Config::get('path')['base_path'] . '/app/categories.php';

        $menu = '';

        foreach ($categories as $key => $values) {
            $active = '';
            $menu_open = '';

            foreach ($values as $value) {
                if (in_array(self::current(), $values['routes']) || in_array(self::getParent(self::current()), $values['routes'])) {
                    $active = 'active';
                    $menu_open = 'menu-open';
                    break;
                }
            }

            $has_permission = false;

            foreach ($values['routes'] as $value) {
                if (Permission::can(self::getPrerequisite($value))) {
                    $has_permission = true;
                    break;
                }
            }

            if ($has_permission) {
                $menu .= "<li class='treeview {$active}'>";
                $menu .= '<a class=\'treeview-header\'>';
                $menu .= "{$categories[$key]['icon']} <span>{$categories[$key]['name']}</span>";
                $menu .= '<span class=\'pull-right-container\'>';
                $menu .= '<i class=\'fa fa-angle-left pull-right\'></i>';
                $menu .= '</span>';
                $menu .= '</a>';
                $menu .= "<ul class='treeview-menu {$menu_open}'>";

                foreach ($values['routes'] as $value) {
                    if (Permission::can(self::getPrerequisite($value))) {
                        $menu .= '<li class=\'' . ($value == self::current() || $value == self::getParent(self::current()) ? 'active' : '') . '\'>';
                        $menu .= '<a href=\'' . self::getURL($value) . '\'>';
                        $menu .= self::getIcon($value) . ' <span>' . self::getName($value) . '</span>';
                        $menu .= '</a>';
                        $menu .= '</li>';
                    }
                }

                $menu .= '</ul>';
                $menu .= '</li>';
            }
        }

        echo $menu;
    }

    /**
     * Display route breadcrumb.
     */
    public static function displayBreadcrumb()
    {
        foreach (self::get()[self::current()]['data']['breadcrumb'] as $breadcrumb) {
            echo "<li>{$breadcrumb}</li>";
        }
    }

    /**
     * Display route content.
     */
    public static function displayContent()
    {
        include self::get()[self::current()]['content'];
    }
}
