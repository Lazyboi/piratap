<?php
namespace App;

use LPU\Authentication;
use LPU\Database;
use LPU\Datalist;
use LPU\Form;
use LPU\Placeholder;
use LPU\Route;
use LPU\Security;

class Preferences
{
    private static $system_preference_data = [];

    /**
     * Display the list of languages as select box.
     *
     * @param string || array $default_data
     */
    public static function displayLanguageSelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('prf_languages')
            ->select([
                'id',
                'name',
            ])
            ->fetchAll(), $default_data);
    }

    /**
     * Display the list of charsets as select box.
     *
     * @param string || array $default_data
     */
    public static function displayCharsetSelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('prf_charsets')
            ->select([
                'id',
                'name',
            ])
            ->fetchAll(), $default_data);
    }

    /**
     * Display the list of skin colors as palette box.
     *
     * @param string || array $default_data
     */
    public static function displaySkinColorPaletteBox($default_data = null)
    {
        Datalist::displayPaletteBox(['name'], 'skin_color', Database::table('prf_skin_colors')
            ->select([
                'id',
                'name',
                'code',
            ])
            ->fetchAll(), $default_data);
    }

    /**
     * Display the list of layouts as radio.
     *
     * @param string $name
     * @param string || array $default_data
     * @param bool $required
     * @param bool $disabled
     */
    public static function displayLayoutRadio($name, $default_data = null, $required = false, $disabled = false)
    {
        Datalist::displayRadio(['name'], $name, Database::table('prf_layouts')
            ->select([
                'id',
                'name',
            ])
            ->fetchAll(), $default_data, $required, $disabled);
    }

    /**
     * Display the list of academic years as select box.
     *
     * @param string || array $default_data
     */
    public static function displayAcademicYearSelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('prf_academic_years')
            ->select([
                'id',
                'name',
            ])
            ->fetchAll(), $default_data);
    }

    /**
     * Display the list of semesters as select box.
     *
     * @param string || array $default_data
     */
    public static function displaySemesterSelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('prf_semesters')
            ->select([
                'id',
                'name',
            ])
            ->fetchAll(), $default_data);
    }

    /**
     * Display the yes or no radio.
     *
     * @param string $name
     * @param string || array $default_data
     * @param bool $required
     * @param bool $disabled
     */
    public static function displayYesNoRadio($name, $default_data = null, $required = false, $disabled = false)
    {
        Datalist::displayRadio(['name'], $name, [
            [
                'id'   => 1,
                'name' => 'No',
            ],
            [
                'id'   => 2,
                'name' => 'Yes',
            ],
        ], $default_data, $required, $disabled);
    }

    /**
     * Load the system preference data.
     */
    public static function loadSystemPreferenceData()
    {
        foreach (Database::table('prf_system_preferences')
            ->select()
            ->fetchAll() as $system_preference) {
            $system_preference['raw_value'] = $system_preference['value'];

            if (in_array($system_preference['code'], ['html_content_language', 'meta_charset', 'skin_color', 'layout', 'academic_year', 'semester'])) {
                switch ($system_preference['code']) {
                    case 'html_content_language':
                        $table = 'prf_languages';
                        break;
                    case 'meta_charset':
                        $table = 'prf_charsets';
                        break;
                    case 'skin_color':
                        $table = 'prf_skin_colors';
                        break;
                    case 'layout':
                        $table = 'prf_layouts';
                        break;
                    case 'academic_year':
                        $table = 'prf_academic_years';
                        break;
                    case 'semester':
                        $table = 'prf_semesters';
                        break;
                    default:
                }

                if ($data = Database::table($table)
                    ->where([
                        ['id', '=', $system_preference['value']],
                    ])
                    ->select()
                    ->fetch()) {
                    $system_preference['raw_value'] = $data['name'];

                    if (!in_array($system_preference['code'], ['academic_year', 'semester'])) {
                        $system_preference['value'] = $data['code'];
                    }
                }
            }

            if ($system_preference['code'] == 'meta_keywords') {
                $system_preference['raw_value'] = '<span class=\'label label-success\'>' . implode('</span><span class=\'label label-success\'>', explode(',', $system_preference['value'])) . '</span>';
            }

            self::$system_preference_data[$system_preference['code']] = [
                'name'        => $system_preference['name'],
                'description' => $system_preference['description'],
                'raw_value'   => $system_preference['raw_value'],
                'value'       => $system_preference['value'],
            ];
        }
    }

    /**
     * Display the system preference data
     *
     * @param string $code
     * @param string $data
     */
    public static function displaySystemPreferenceData($code, $data)
    {
        echo self::$system_preference_data[$code][$data] ? self::$system_preference_data[$code][$data] : '<span class=\'text-muted\'>' . Placeholder::get('long') . '</span>' ;
    }

    /**
     * Get the system preference data
     *
     * @param string $code
     *
     * @return string
     */
    public static function getSystemPreferenceData($code)
    {
        return self::$system_preference_data[$code]['value'] ? self::$system_preference_data[$code]['value'] : null ;
    }

    /**
     * Load the system preference field data
     */
    public static function loadSystemPreferenceFieldData()
    {
        foreach (Database::table('prf_system_preferences')
            ->select()
            ->fetchAll() as $system_preference) {
            $data[$system_preference['code']] = [
                'name'        => $system_preference['name'],
                'description' => $system_preference['description'],
                'value'       => $system_preference['value'],
            ];
        }

        switch (Route::currentData()) {
            case 'general':
                Form::createFieldData('html_content_language', $data['html_content_language']['value']);
                Form::createFieldData('meta_charset', $data['meta_charset']['value']);
                Form::createFieldData('meta_application_name', $data['meta_application_name']['value']);
                Form::createFieldData('meta_description', $data['meta_description']['value']);
                Form::createFieldData('meta_keywords', $data['meta_keywords']['value']);
                Form::createFieldData('meta_author', $data['meta_author']['value']);
                Form::createFieldData('application_name', $data['application_name']['value']);
                Form::createFieldData('footer_copyright', $data['footer_copyright']['value']);
                break;
            case 'ui':
                Form::createFieldData('skin_color', $data['skin_color']['value']);
                Form::createFieldData('layout', $data['layout']['value']);
                break;
            case 'academic':
                Form::createFieldData('academic_year', $data['academic_year']['value']);
                Form::createFieldData('semester', $data['semester']['value']);
                break;
            default:
        }
    }

    /**
     * Edit the system preference.
     */
    public static function editSystemPreference()
    {
        if (!Security::verifyPassword(Form::getFieldData('password'), Database::table('umg_users')
            ->where([
                ['id', '=', Authentication::getAuthenticatedUser()],
            ])
            ->select()
            ->fetch()['password'])) {
            Form::setState('Cannot edit the system preference. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('password', 'Incorrect password.', Form::VALIDATION_ERROR);
            return;
        }

        switch (Route::currentData()) {
            case 'general':
                $system_preference_fields = ['html_content_language', 'meta_charset', 'meta_application_name', 'meta_description', 'meta_keywords', 'meta_author', 'application_name', 'footer_copyright'];
                break;
            case 'ui':
                $system_preference_fields = ['skin_color', 'layout'];
                break;
            case 'academic':
                $system_preference_fields = ['academic_year', 'semester'];
                break;
            default:
        }

        foreach ($system_preference_fields as $system_preference_field) {
            if (!Database::table('prf_system_preferences')
                ->set([
                    ['value', Form::getFieldData($system_preference_field)],
                ])
                ->where([
                    ['code', '=', $system_preference_field],
                ])
                ->update()) {
                Form::setState('Cannot edit the system preference. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                return;
                break;
            }
        }

        Form::setState('System preference has been successfully edited', 'The system preference will now be updated in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }
}
