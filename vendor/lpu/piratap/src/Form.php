<?php
namespace LPU;

class Form
{
    const MESSAGE_DEFAULT = '';
    const MESSAGE_SUCCESS = 'msg-success';
    const MESSAGE_ERROR = 'msg-error';
    const MESSAGE_WARNING = 'msg-warning';

    const ALERT_SUCCESS = 'alert-success';
    const ALERT_ERROR = 'alert-danger';
    const ALERT_WARNING = 'alert-warning';

    const VALIDATION_SUCCESS = 'has-success';
    const VALIDATION_ERROR = 'has-error';
    const VALIDATION_WARNING = 'has-warning';

    private static $state = [
        'title'       => '',
        'description' => '',
        'state'       => ''
    ];

    private static $field_state = [];

    /**
     * Get the form data.
     *
     * @return array
     */
    private static function get()
    {
        return $_POST;
    }

    /**
     * Clear a form data.
     *
     * @param string $name
     */
    public static function clear($name)
    {
        unset($_POST[$name]);
    }

    /**
     * Validate if the form fields are submitted.
     *
     * @param array $fields
     * @param bool $session
     *
     * @return bool
     */
    public static function validate($fields, $session = false)
    {
        foreach ($fields as $field) {
            if ($session) {
                if (!self::getFieldData($field, true)) {
                    return false;
                    break;
                }
            } else {
                if (!isset(self::get()[$field])) {
                    return false;
                    break;
                }
            }
        }

        return true;
    }

    /**
     * Validate if the form files are submitted.
     *
     * @param array $fields
     * @param bool $session
     *
     * @return bool
     */
    public static function validateFile($fields, $session = false)
    {
        foreach ($fields as $field) {
            if ($session) {
                if (!self::getFieldData($field, true)) {
                    return false;
                    break;
                }
            } else {
                if (!isset(self::get()[$field])) {
                    return false;
                    break;
                }
            }
        }

        return true;
    }

    /**
     * Display the form note.
     */
    public static function displayNotes()
    {
        $notes = '';
        $notes .= '<span>Important Notes:</span>';
        $notes .= '<ul>';
        $notes .= '<li>Asterisk <span class=\'text-danger\'>*</span> indicates required fields, so make sure you filled it out.</li>';
        $notes .= '<li>It is highly recommended that you read all the hints <span class=\'hint\'>(small italicized text)</span> under each field\'s label.</li>';
        $notes .= '<li>Field labels with (s) or (es) on it means that it accepts more than one data.</li>';
        $notes .= '<li>Always double check your data before saving to avoid any corrections.</li>';
        $notes .= '</ul>';

        echo $notes;
    }

    /**
     * Display the form message.
     */
    public static function displayMessage()
    {
        $message = '';

        if (self::checkState(true)) {
            $message .= '<div class=\'alert ' . Form::getState('state', true) . ' alert-dismissible fade in\'>';
            $message .= '<button class=\'close\' data-dismiss=\'alert\' type=\'button\'>[Close]</button>';
            $message .= '<h4>' . Form::getState('title', true) . '</h4>';
            $message .= '<p>' . Form::getState('description', true) . '</p>';
            $message .= '</div>';
        }

        echo $message;
    }

    /**
     * Set the form state.
     *
     * @param string $title
     * @param string $description
     * @param string $state
     * @param bool $session
     */
    public static function setState($title, $description, $state, $session = false)
    {
        if ($session) {
            Session::create('title', $title);
            Session::create('description', $description);
            Session::create('state', $state);
        } else {
            self::$state['title'] = $title;
            self::$state['description'] = $description;
            self::$state['state'] = $state;
        }
    }

    /**
     * Set the form field state.
     *
     * @param string $name
     * @param string $message
     * @param string $state
     */
    public static function setFieldState($name, $message, $state)
    {
        self::$field_state[$name]['message'] = $message;
        self::$field_state[$name]['state'] = $state;
    }

    /**
     * Display the form state.
     *
     * @param string $type
     * @param bool $session
     */
    public static function displayState($state, $session = false)
    {
        echo $session ? Session::get($state) : self::$state[$state] ;
    }

    /**
     * Get the form state.
     *
     * @param string $type
     * @param bool $session
     */
    public static function getState($state, $session = false)
    {
        return $session ? Session::get($state) : self::$state[$state] ;
    }

    /**
     * Display the form field state.
     *
     * @param string $name
     * @param string $state
     * @param bool $session
     */
    public static function displayFieldState($name, $state)
    {
        if (!empty(self::$field_state[$name][$state])) {
            if ($state == 'message') {
                echo '<span class=\'help-block\'>' . self::$field_state[$name]['message'] . '</span>';
            } elseif ($state == 'state') {
                echo self::$field_state[$name]['state'];
            }
        }
    }

    /**
     * Load the form field data.
     *
     * @param string $name
     * @param bool $session
     */
    public static function loadFieldData($name, $session = false)
    {
        if ($session) {
            if (!empty(Session::get($name))) {
                echo Session::get($name);
            }
        } else {
            if (!empty(self::get()[$name])) {
                echo self::get()[$name];
            }
        }
    }

    /**
     * Check the current state of the form
     *
     * @param bool $session
     *
     * @return bool
     */
    public static function checkState($session = false)
    {
        return $session ? !empty(Session::get('state')) : !empty(self::$state['state']) ;
    }

    /**
     * Clear the current state of the form
     *
     * @param bool $session
     *
     * @return bool
     */
    public static function clearState($session = false)
    {
        if ($session) {
            Session::clear('title');
            Session::clear('description');
            Session::clear('state');
        } else {
            self::$state['title'] = '';
            self::$state['description'] = '';
            self::$state['state'] = '';
        }
    }

    /**
     * Get the form field data.
     *
     * @param string $name
     * @param bool $session
     *
     * @return object || bool
     */
    public static function getFieldData($name, $session = false)
    {
        if ($session) {
            return !empty(Session::get($name)) ? Session::get($name) : null ;
        } else {
            return !empty(self::get()[$name]) ? self::get()[$name] : null ;
        }
    }

    /**
     * Get the form field file.
     *
     * @param string $name
     * @param string $data
     *
     * @return object || bool
     */
    public static function getFieldFile($name, $data)
    {
        return !empty($_FILES[$name][$data]) ? $_FILES[$name][$data] : null ;
    }

    /**
     * Create a form field data.
     *
     * @param string $name
     * @param object $value
     * @param bool $session
     */
    public static function createFieldData($name, $value, $session = false)
    {
        if ($session) {
            Session::create($name, $value);
        } else {
            $_POST[$name] = $value;
        }
    }

    /**
     * Clear a form field data.
     *
     * @param string $name
     * @param bool $session
     */
    public static function clearFieldData($name, $session = false)
    {
        if ($session) {
            Session::clear($name);
        } else {
            self::clear($name);
        }
    }

    /**
     * Get a form data.
     *
     * @param string $name
     *
     * @return bool || array || object
     */
    public static function getData($name = '')
    {
        if (self::isSubmitted()) {
            if ($name == '') {
                return $_POST;
            } else {
                return $_POST[$name];
            }
        } else {
            return false;
        }
    }
}
