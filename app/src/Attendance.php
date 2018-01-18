<?php
namespace App;

use LPU\Authentication;
use LPU\Database;
use LPU\Datalist;
use LPU\DateTime;
use LPU\Form;
use LPU\Path;
use LPU\Permission;
use LPU\Placeholder;
use LPU\Route;
use LPU\Security;
use LPU\Url;

class Attendance
{
    private static $account_data = [];
    private static $permission_data = [];
    private static $role_data = [];
    private static $department_data = [];
    private static $user_data = [];
    private static $attendance_data = [];
    private static $time_in = [];


    /**
     * Display the list of departments as select box.
     *
     * @param string || array $default_data
     */
    public static function displayDepartmentSelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('umg_departments')
            ->where([
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->select([
                'id',
                'name',
                'disabled_at',
                'disabled_by',
            ])
            ->fetchAll(), $default_data);
    }

    /**
     * Display the list of departments as table.
     */
    public static function displayDepartmentTable()
    {
        switch (Route::currentData()) {
            case 'created':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'acronym'     => 'ACRONYM',
                    'description' => 'DESCRIPTION',
                ], Database::table('umg_departments a')
                    ->where([
                        ['a.disabled_at', 'IS NULL'],
                        ['a.disabled_by', 'IS NULL'],
                        ['a.deleted_at', 'IS NULL'],
                        ['a.deleted_by', 'IS NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.acronym',
                        'a.description',
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('view-department')) {
                            $action .= "<form>
                                          <a class='btn btn-warning btn-xs' href='" . Route::getURL('view-department', $id) . "' title='" . Route::getName('view-department')  . "'>" . Route::getIcon('view-department')  . "</a>
                                        </form>";
                        }

                        if (Permission::can('edit-department')) {
                            $action .= "<form method='POST'>
                                          <a class='btn btn-success btn-xs' href='" . Route::getURL('edit-department', $id) . "' title='" . Route::getName('edit-department')  . "'>" . Route::getIcon('edit-department')  . "</a>
                                        </form>";
                        }

                        if (Permission::can('disable-department')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='disable_department' title='" . Route::getName('disable-department')  . "' type='submit' value='{$id}'>" . Route::getIcon('disable-department')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('delete-department')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-danger btn-xs' name='delete_department' title='" . Route::getName('delete-department')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-department')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'disabled':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'acronym'     => 'ACRONYM',
                    'description' => 'DESCRIPTION',
                    'disabled_by' => 'DISABLED BY',
                ], Database::table('umg_departments a')
                    ->where([
                        ['a.disabled_at', 'IS NOT NULL'],
                        ['a.disabled_by', 'IS NOT NULL'],
                        ['a.deleted_at', 'IS NULL'],
                        ['a.deleted_by', 'IS NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.acronym',
                        'a.description',
                        Database::getDisabler('a.disabled_at', 'a.disabled_by', 'disabled_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('enable-department')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='enable_department' title='" . Route::getName('enable-department')  . "' type='submit' value='{$id}'>" . Route::getIcon('enable-department')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('delete-department')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='delete_department' title='" . Route::getName('delete-department')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-department')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'deleted':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'acronym'     => 'ACRONYM',
                    'description' => 'DESCRIPTION',
                    'deleted_by'  => 'DELETED BY',
                ], Database::table('umg_departments a')
                    ->where([
                        ['a.deleted_at', 'IS NOT NULL'],
                        ['a.deleted_by', 'IS NOT NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.acronym',
                        'a.description',
                        Database::getDeleter('a.deleted_at', 'a.deleted_by', 'deleted_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('restore-department')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='restore_department' title='" . Route::getName('restore-department')  . "' type='submit' value='{$id}'>" . Route::getIcon('restore-department')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('purge-department')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='purge_department' title='" . Route::getName('purge-department')  . "' type='submit' value='{$id}'>" . Route::getIcon('purge-department')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            default:
        }
    }

    /**
     * Validate the department.
     */
    public static function validateDepartment()
    {
        if (!Database::table('umg_departments')
            ->where([
                ['id', '=', Route::currentData()],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->select()
            ->fetch()) {
            Route::go(Route::getParent(Route::current()));
        }
    }

    /**
     * Load the department data.
     */
    public static function loadDepartmentData()
    {
        self::$department_data = Database::table('umg_departments a')
            ->where([
                ['a.id', '=', Route::currentData()],
            ])
            ->select([
                'a.id',
                'a.name',
                'a.acronym',
                'a.description',
                Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
                Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),
            ])
            ->fetch();
    }

    /**
     * Display the department data.
     *
     * @param string $data
     */
    public static function displayDepartmentData($data)
    {
        echo self::$department_data[$data] ? self::$department_data[$data] : '<span class=\'text-muted\'>' . Placeholder::get('long') . '</span>' ;
    }

    /**
     * Load the department field data.
     */
    public static function loadDepartmentFieldData()
    {
        if ($data = Database::table('umg_departments')
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->select()
            ->fetch()) {
            Form::createFieldData('name', $data['name']);
            Form::createFieldData('acronym', $data['acronym']);
            Form::createFieldData('description', $data['description']);
        }
    }

    /**
     * Add a new department.
     */
    public static function addNewDepartment()
    {
        if (!Permission::can('add-new-department')) {
            Form::setState('Cannot add a new department. Please try again later', 'You are not authorized to add new department.', Form::ALERT_ERROR, true);
            return;
        }

        if (Database::table('umg_departments')
            ->where([
                ['name', '=', Form::getFieldData('name')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot add a new department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('name', 'Name has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (Database::table('umg_departments')
            ->where([
                ['acronym', '=', Form::getFieldData('acronym')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot add a new department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('acronym', 'Acronym has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('umg_departments')
            ->values([
                ['name', Form::getFieldData('name')],
                ['acronym', Form::getFieldData('acronym')],
                ['description', Form::getFieldData('description')],
            ])
            ->insert()) {
            Form::setState('Cannot add a new department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Department has been successfully added.', 'The department will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Edit the department.
     */
    public static function editDepartment()
    {
        if (!Permission::can('edit-department')) {
            Form::setState('Cannot edit the department. Please try again later', 'You are not authorized to edit the department.', Form::ALERT_ERROR, true);
            return;
        }

        if (Database::table('umg_departments')
            ->where([
                ['id', '!=', Route::currentData()],
                ['name', '=', Form::getFieldData('name')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot edit the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('name', 'Name has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (Database::table('umg_departments')
            ->where([
                ['id', '!=', Route::currentData()],
                ['acronym', '=', Form::getFieldData('acronym')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot edit the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('acronym', 'Acronym has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('umg_departments')
            ->set([
                ['name', Form::getFieldData('name')],
                ['acronym', Form::getFieldData('description')],
                ['description', Form::getFieldData('description')],
            ])
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->update()) {
            Form::setState('Cannot edit the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Department has been successfully edited', 'The department will now be updated in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Disable the department.
     */
    public static function disableDepartment()
    {
        if (!Permission::can('disable-department')) {
            Form::setState('Cannot disable the department. Please try again later', 'You are not authorized to disable the department.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_departments')
            ->where([
                ['id', '=', Form::getFieldData('disable_department')],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->disable()) {
            Form::setState('Cannot disable the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Department has been successfully disabled', 'The department will no longer be available but will still appear in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Delete the department.
     */
    public static function deleteDepartment()
    {
        if (!Permission::can('delete-department')) {
            Form::setState('Cannot delete the department. Please try again later', 'You are not authorized to delete the department.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_departments')
            ->where([
                ['id', '=', Form::getFieldData('delete_department')],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->delete()) {
            Form::setState('Cannot delete the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Department has been successfully deleted', 'The department will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Enable the department.
     */
    public static function enableDepartment()
    {
        if (!Permission::can('enable-department')) {
            Form::setState('Cannot enable the department. Please try again later', 'You are not authorized to enable the department.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_departments')
            ->where([
                ['id', '=', Form::getFieldData('enable_department')],
                ['disabled_at', 'IS NOT NULL'],
                ['disabled_by', 'IS NOT NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->enable()) {
            Form::setState('Cannot enable the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Department has been successfully enabled', 'The department will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Restore the department.
     */
    public static function restoreDepartment()
    {
        if (!Permission::can('restore-department')) {
            Form::setState('Cannot restore the department. Please try again later', 'You are not authorized to restore the department.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_departments')
            ->where([
                ['id', '=', Form::getFieldData('restore_department')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->restore()) {
            Form::setState('Cannot restore the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Department has been successfully restored', 'The department will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Purge the department.
     */
    public static function purgeDepartment()
    {
        if (!Permission::can('purge-department')) {
            Form::setState('Cannot purge the department. Please try again later', 'You are not authorized to purge the department.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_departments')
            ->where([
                ['id', '=', Form::getFieldData('purge_department')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->purge()) {
            Form::setState('Cannot purge the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Department has been successfully purged', 'The department will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Display the list of genders as radio.
     *
     * @param string $name
     * @param string || array $default_data
     * @param bool $required
     * @param bool $disabled
     */
    public static function displayGenderRadio($name, $default_data = null, $required = false, $disabled = false)
    {
        Datalist::displayRadio(['name'], $name, Database::table('umg_genders')
            ->select([
                'id',
                'name',
            ])
            ->fetchAll(), $default_data, $required, $disabled);
    }

    /**
     * Display the list of users as select box.
     *
     * @param string || array $default_data
     */
    public static function displayUserSelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('umg_users')
            ->where([
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->select([
                'id',
                Database::concat([
                    'first_name',
                    "' '",
                    'last_name',
                ], 'name'),
                'disabled_at',
                'disabled_by',
            ])
            ->fetchAll(), $default_data);
    }


    public static function addNewAttendance()
    {
        if (!Permission::can('add-new-attendance')) {
            Form::setState('Cannot add a new attendance. Please try again later', 'You are not authorized to add new attendance.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('atd_users_attendance')
            ->values([

                ['user_id', Form::getFieldData('user')],
                ['class_id', Form::getFieldData('class')],
                ['time_in', Form::getFieldData('time_in')],
                ['time_out', Form::getFieldData('time_out')],
            ])
            ->insert()) {
            Form::setState('Cannot add a new attendance. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        // $class_id = Database::lastInsertId();

        // if (!Database::table('atd_users_attendance') //lahat ng column ni table
        //     ->values([
        //         ['class_id', $class_id],
        //         ['subject_legend_id', Form::getFieldData('subject_type')],
        //         ['day_id', Form::getFieldData('days')],
        //         ['started_at', Form::getFieldData('started_at')],
        //         ['ended_at', Form::getFieldData('ended_at')],
        //         ['room_id', Form::getFieldData('room')],
        //     ])
        //     ->insert()) {
        //     Form::setState('Cannot add a new class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
        //     return;
        // }

        Form::setState('Attendance has been successfully added.', 'The attendance will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    // public static function validateTimeIn()
    // {
    //   // Database::beginTransaction();
    //     $time_in = Database::table('atd_users_attendance')
    //     // ->where([
    //     //     // ['atd_users_attendance.user_id', '=', Authentication::getAuthenticatedUser()],
    //     // ])
    //     ->select([
    //       // 'id',
    //       Database::dateFormat('time_in', '\'%l:%i %p\'', "time_in"), //Time in ng student
    //     ])
    //     ->fetch()['time_in'];
    //
    //     // $schedule = Database::table('clm_classes_schedules a')
    //     // -leftJoin([
    //     //   'atd_users_attendance b' => [
    //     //     'b.id = '
    //     //   ]
    //     // ])
    //     // ->where([
    //     //     ['']
    //     // ])
    //
    //     //Check if student is late or absent
    //     // if (true == true)
    //     if (strtotime($time_in) < 1)
    //     {
    //       //display
    //       echo var_dump($time_in);
    //     }
    //
    //     else
    //     {
    //       echo var_dump($time_in);
    //       echo "false";
    //     }
    // }

    public static function exportAttendance()
    {
      // require_once "C:/xampp/htdocs/piratap/vendor/phpoffice/phpexcel/Classes/PHPExcel.php";
      //
      // $excel = new \PHPExcel();
      //
      // $excel -> setActiveSheetIndex(0)
      //       ->setCellValue('A1', 'Hello')
      //       ->setCellValue('B1', 'World');
      //
      // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      // header('Content-Disposition: attachment; filename="test.xlsx"');
      // header('Cache-Control: max-age=0');
      //
      // $file = \PHPExcel_IOFactory::createWriter($excel, 'Excel5');
      // $file->save('php://output');
    }

    /**
     * Display the list of users as table.
     */
     public static function displayAttendanceTable()
     {
         switch (Route::currentData()) {
             case 'created':
             Datalist::displayTable([
                 'id'          => 'ID',
                 'student_number'    => 'STUDENT NUMBER',
                 'student_name'    => 'STUDENT NAME',
                 'subject'     => 'SUBJECT',
                 'section'     => 'SECTION',
                 'assigned_professor' => 'PROFESSOR',
                 'lab_schedule'    => 'LABORATORY SCHEDULE',
                 'lec_schedule'    => 'LECTURE SCHEDULE',
                 'date_log'    => 'DATE',
                 'time_in'     => 'TIME IN',
                 'time_out'    => 'TIME OUT',
                 'remarks'     => 'REMARKS',
             ], Database::table('atd_users_attendance a')
                 ->leftJoin([
                     'umg_users b' => [
                         'a.user_id = b.id'
                     ],
                     'clm_classes c' => [
                         'a.class_id = c.id'
                     ],
                     'acd_subjects d' => [
                         'c.subject_id = d.id'
                     ],
                     'acd_sections f' => [
                         'c.section_id = f.id'
                     ],
                 ])

                 //PROF NAME
                 ->select([
                     'a.id',
                     'b.username AS student_number',
                     Database::concat([
                         'b.first_name',
                         "' '",
                         'b.last_name',
                     ], 'student_name'),
                     'd.description AS subject',
                     'f.name AS section',
                     Database::plain(0)
                     ->table('umg_users', 0)
                     ->where([
                         ['umg_users.id', '=', 'c.assigned_professor'],

                     ], 0)

                     ->select([
                       Database::concat([
                           'umg_users.first_name',
                           "' '",
                           'umg_users.last_name',
                       ], 'assigned_professor'),
                     ], 0, 'assigned_professor'),
                     Database::plain(0)
                     ->table('clm_classes_schedules', 0)
                     ->leftJoin([
                         'clm_days' => [
                             'clm_classes_schedules.day_id = clm_days.id'
                         ],
                     ], 0)
                     ->where([ //LECTURE
                         ['clm_classes_schedules.class_id', '=', 'a.class_id'],
                         ['clm_classes_schedules.subject_legend_id', '=', '1'],
                     ], 0)
                     ->select([
                       Database::groupConcat([
                           'clm_days.name',
                           '" <br> "',
                           Database::dateFormat('clm_classes_schedules.started_at', '\'%l:%i %p\''),
                           '\' - \'',
                           Database::dateFormat('clm_classes_schedules.ended_at', '\'%l:%i %p\''),
                       ], '" "'), //separator
                     ], 0, 'lec_schedule'),

                     Database::plain(0)
                     ->table('clm_classes_schedules', 0)
                     ->leftJoin([
                         'clm_days' => [
                             'clm_classes_schedules.day_id = clm_days.id'
                         ],
                     ], 0)
                     ->where([ //LABORATORY
                         ['clm_classes_schedules.class_id', '=', 'a.class_id'],
                         ['clm_classes_schedules.subject_legend_id', '=', '2'],
                     ], 0)
                     ->select([
                       Database::groupConcat([
                           'clm_days.name',
                           '" <br> "',
                           Database::dateFormat('clm_classes_schedules.started_at', '\'%l:%i %p\''),
                           '\' - \'',
                           Database::dateFormat('clm_classes_schedules.ended_at', '\'%l:%i %p\''),
                       ], '" "'), //separator
                     ], 0, 'lab_schedule'),
                     Database::dateFormat('a.time_in', '\'%M/%d/%Y\'', 'date_log'),
                     Database::dateFormat('a.time_in', '\'%l:%i %p\'', 'time_in'),
                     Database::dateFormat('a.time_out', '\'%l:%i %p\'', 'time_out'),
                     // 'a.is_late AS remarks',
                     // 'a.is_absent AS remarks',
                     // 'a.is_cutting AS r'emarks',
                     // Database::condition("" + Database::dateFormat('a.time_in', '\'%l:%i %p\'')+ ""+ Database::dateFormat('clm_classes_schedules', '\'%l:%i %p\'') +"", Database::condition('true', '\'Present\'', '\'Late\''), '\'Absent\'', 'remarks'),
                     Database::condition(

                       Database::concat([
                           Database::dateFormat('a.time_in', '\'%H:%i\''),
                            "'BETWEEN'",
                            "'DATE_FORMAT(clm_classes_schedules.started_at, %H:%i)'",
                            "'AND'",
                            "'DATE_FORMAT(clm_classes_schedules.ended_at, %H:%i)'"
                       ])


                       , Database::condition('true', '\'Present\'', '\'Late\''), '\'Absent\'', 'remarks'),
                   ])

                 ->fetchAll(), function ($id) {
                   $action = '';

                   if (Permission::can('view-attendance')) {
                       $action .= "<form>
                                     <a class='btn btn-warning btn-xs' href='" . Route::getURL('view-attendance', $id) . "' title='" . Route::getName('view-attendance')  . "'>" . Route::getIcon('view-attendance')  . "</a>
                                   </form>";
                   }

                   if (Permission::can('edit-attendance')) {
                       $action .= "<form method='POST'>
                                     <a class='btn btn-success btn-xs' href='" . Route::getURL('edit-attendance', $id) . "' title='" . Route::getName('edit-attendance')  . "'>" . Route::getIcon('edit-attendance')  . "</a>
                                   </form>";
                   }

                  //  if (Permission::can('disable-class')) {
                  //      $action .= "<form method='POST'>
                  //                    <button class='btn btn-default btn-xs' name='disable_class' title='" . Route::getName('disable-class')  . "' type='submit' value='{$id}'>" . Route::getIcon('disable-class')  . "</button>
                  //                  </form>";
                  //  }

                   if (Permission::can('delete-attendance')) {
                       $action .= "<form method='POST'>
                                     <button class='btn btn-danger btn-xs' name='delete_attendance' title='" . Route::getName('delete-attendance')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-attendance')  . "</button>
                                   </form>";
                   }

                   return $action;
               });
           break;
            //  case 'disabled':
            //  Datalist::displayTable([
            //      'id'          => 'ID',
            //      'faculty'     => 'FACULTY',
            //      'name'        => 'COURSE CODE',
            //      'description' => 'DESCRIPTION',
            //  ], Database::table('clm_classes a')
            //      ->leftJoin([
            //          'umg_users b' => [
            //              'a.assigned_professor = b.id'
            //          ],
            //          'acd_subjects c' => [
            //              'a.subject_id = c.id'
            //          ],
            //      ])
            //      ->where([
            //          ['a.deleted_at', 'IS NOT NULL'],
            //          ['a.deleted_by', 'IS NOT NULL'],
            //          ['a.disabled_at', 'IS NOT NULL'],
            //          ['a.disabled_by', 'IS NOT NULL'],
            //      ])
            //      ->select([
            //          'a.id',
            //          Database::concat([
            //              'b.first_name',
            //              "' '",
            //              'b.last_name',
            //          ], 'faculty'),
            //          'c.name',
            //          'c.description',
            //        ])
            //          ->fetchAll(), function ($id) {
            //              $action = '';
             //
            //              if (Permission::can('enable-class')) {
            //                  $action .= "<form method='POST'>
            //                                <button class='btn btn-default btn-xs' name='enable_class' title='" . Route::getName('enable-class')  . "' type='submit' value='{$id}'>" . Route::getIcon('enable-class')  . "</button>
            //                              </form>";
            //              }
             //
            //              if (Permission::can('delete-class')) {
            //                  $action .= "<form method='POST'>
            //                                <button class='btn btn-default btn-xs' name='delete_class' title='" . Route::getName('delete-class')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-class')  . "</button>
            //                              </form>";
            //              }
             //
            //              return $action;
            //          });

  }
  }

    /**
     * Validate the user.
     */
    public static function validateUser()
    {
        if (!Database::table('umg_users')
            ->where([
                ['id', '=', Route::currentData()],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->select()
            ->fetch()) {
            Route::go(Route::getParent(Route::current()));
        }
    }



    /**
     * Load the user data.
     */
    public static function loadUserData()
    {
        self::$role_data = Database::table('umg_users a')
            ->where([
                ['a.id', '=', Route::currentData()],
            ])
            ->select([
                'a.id',
                'a.username',
                'a.first_name',
                'a.middle_name',
                'a.last_name',
                Database::dateFormat('a.birthdate', '\'%M %d, %Y\'', 'birthdate'),
                Database::plain(0)
                    ->table('umg_genders', 0)
                    ->where([
                        ['umg_genders.id', '=', 'a.gender_id'],
                    ], 0)
                    ->select([
                        Database::concat([
                            'umg_genders.name',
                        ], "' '"),
                    ], 0, 'gender'),
                Database::plain(0)
                    ->table('umg_users_email_addresses', 0)
                    ->where([
                        ['umg_users_email_addresses.user_id', '=', 'a.id'],
                    ], 0)
                    ->select([
                        Database::groupConcat([
                            'umg_users_email_addresses.email_address',
                        ], "' '"),
                    ], 0, 'email_addresses'),
                Database::plain(0)
                    ->table('umg_users_departments', 0)
                    ->leftJoin([
                        'umg_departments' => [
                            'umg_users_departments.department_id = umg_departments.id'
                        ],
                    ], 0)
                    ->where([
                        ['umg_users_departments.user_id', '=', 'a.id'],
                    ], 0)
                    ->select([
                        Database::groupConcat([
                            Database::condition('umg_departments.disabled_at IS NULL AND umg_departments.disabled_by IS NULL', "' '", "' text-disabled'"),
                            'umg_departments.name',
                        ], "' '"),
                    ], 0, 'departments'),
                Database::plain(0)
                    ->table('umg_users_roles', 0)
                    ->leftJoin([
                        'umg_roles' => [
                            'umg_users_roles.role_id = umg_roles.id'
                        ],
                    ], 0)
                    ->where([
                        ['umg_users_roles.user_id', '=', 'a.id'],
                    ], 0)
                    ->select([
                        Database::groupConcat([
                            Database::condition('umg_roles.disabled_at IS NULL AND umg_roles.disabled_by IS NULL', "' '", "' text-disabled'"),
                            'umg_roles.name',
                        ], "' '"),
                    ], 0, 'roles'),
                Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
                Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),
            ])
            ->fetch();
    }

    /**
     * Display the attendance data.
     *
     * @param string $data
     */
    public static function displayAttendanceData($data)
    {
        echo self::$Attendance_data[$data] ? self::$Attendance_data[$data] : '<span class=\'text-muted\'>' . Placeholder::get('long') . '</span>' ;
    }

    public static function editAttendance()
    {
        if (!Permission::can('edit-attendance')) {
            Form::setState('Cannot edit the attendance. Please try again later', 'You are not authorized to edit the attendance.', Form::ALERT_ERROR, true);
            return;
        }

        // Database::beginTransaction();

        /*
        if (Database::table('clm_classes')
            ->where([
                ['id', '!=', Route::currentData()],
                ['username', '=', Form::getFieldData('username')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot edit the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('username', 'Username already exist.', Form::VALIDATION_ERROR);
            return;
        }
        */

        if (!Database::table('atd_users_attendance')
            ->set([
                ['user_id', Form::getFieldData('user')],
                ['class_id', Form::getFieldData('class')],
                ['time_in', DateTime::convert('Y-m-d H:i',Form::getFieldData('time_in'))],
                ['time_out', DateTime::convert('Y-m-d H:i',Form::getFieldData('time_out'))],
            ])
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->update()) {
            Form::setState('Cannot edit the attendance. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        // if (!Database::table('clm_classes_schedules')
        //     ->set([
        //         ['subject_legend_id', Form::getFieldData('subject_type')],
        //         ['day_id', Form::getFieldData('days')],
        //         ['started_at', Form::getFieldData('started_at')],
        //         ['ended_at', Form::getFieldData('ended_at')],
        //         ['room_id', Form::getFieldData('room')],
        //     ])
        //     ->where([
        //         ['class_id', '=', Route::currentData()],
        //     ])
        //     ->update()) {
        //       Form::setState('Cannot edit the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
        //       return;
        // }

        // if (!Database::commit()) {
        //     Form::setState('Cannot edit the attendance. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
        //     return;
        // }

        Form::setState('Attendance has been successfully edited', 'The class will now be updated in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }


    /**
     * Load the attendance field data.
     */
    public static function loadAttendanceFieldData()
    {
        if ($data = Database::table('atd_users_attendance')
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->select()
            ->fetch()) {
            Form::createFieldData('user', $data['user_id']);
            Form::createFieldData('class', $data['class_id']);
            Form::createFieldData('time_in', DateTime::convert('F d, Y h:i', $data['time_in']));
            Form::createFieldData('time_out',DateTime::convert('F d, Y h:i', $data['time_out']));
        }

        // if ($data = Database::table('umg_users_email_addresses')
        //     ->where([
        //         ['user_id', '=', Route::currentData()],
        //     ])
        //     ->select([
        //         'email_address',
        //     ])
        //     ->fetchAll()) {
        //     Form::createFieldData('email_addresses', implode(',', array_column($data, 'email_address')));
        // }

        // if ($data = Database::table('umg_users_departments a')
        //     ->leftJoin([
        //         'umg_departments b' => [
        //             'a.department_id = b.id'
        //         ],
        //     ])
        //     ->where([
        //         ['a.user_id', '=', Route::currentData()],
        //         ['b.disabled_at', 'IS NULL'],
        //         ['b.disabled_by', 'IS NULL'],
        //         ['b.deleted_at', 'IS NULL'],
        //         ['b.deleted_by', 'IS NULL'],
        //     ])
        //     ->select([
        //         'a.department_id',
        //     ])
        //     ->fetchAll()) {
        //     Form::createFieldData('departments', array_column($data, 'department_id'));
        // }

        // if ($data = Database::table('umg_users_roles a')
        //     ->leftJoin([
        //         'umg_roles b' => [
        //             'a.role_id = b.id'
        //         ],
        //     ])
        //     ->where([
        //         ['a.user_id', '=', Route::currentData()],
        //         ['b.disabled_at', 'IS NULL'],
        //         ['b.disabled_by', 'IS NULL'],
        //         ['b.deleted_at', 'IS NULL'],
        //         ['b.deleted_by', 'IS NULL'],
        //     ])
        //     ->select([
        //         'a.role_id',
        //     ])
        //     ->fetchAll()) {
        //     Form::createFieldData('roles', array_column($data, 'role_id'));
        // }
    }

    /**
     * Add a new user.
     */
    public static function addNewUser()
    {
        if (!Permission::can('add-new-user')) {
            Form::setState('Cannot add a new user. Please try again later', 'You are not authorized to add new user.', Form::ALERT_ERROR, true);
            return;
        }

        Database::beginTransaction();

        if (Database::table('umg_users')
            ->where([
                ['username', '=', Form::getFieldData('username')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot add a new user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('username', 'Username already exist.', Form::VALIDATION_ERROR);
            return;
        }

        if (Form::getFieldData('password') != Form::getFieldData('confirm_password')) {
            Form::setState('Cannot add a new user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('confirm_password', 'Password does not match.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('umg_users')
            ->values([
                ['username', Form::getFieldData('username')],
                ['password', Form::getFieldData('password')],
                ['first_name', Form::getFieldData('first_name')],
                ['middle_name', Form::getFieldData('middle_name')],
                ['last_name', Form::getFieldData('last_name')],
                ['birthdate', Form::getFieldData('birthdate')],
                ['gender_id', Form::getFieldData('gender')],
            ])
            ->insert()) {
            Form::setState('Cannot add a new user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        $user_id = Database::lastInsertId();

        if (Form::getFieldData('email_addresses')) {
            foreach (explode(',', Form::getFieldData('email_addresses')) as $email_address) {
                if (!Database::table('umg_users_email_addresses')
                    ->values([
                        ['user_id', $user_id],
                        ['email_address', $email_address],
                    ])
                    ->insert()) {
                    Form::setState('Cannot add a new user. Please try again later', 'Somethingss went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }
            }
        }

        if (Form::getFieldData('departments')) {
            foreach (Form::getFieldData('departments') as $department_id) {
                if (!Database::table('umg_users_departments')
                    ->values([
                        ['user_id', $user_id],
                        ['department_id', $department_id],
                    ])
                    ->insert()) {
                    Form::setState('Cannot add a new user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }
            }
        }

        if (Form::getFieldData('roles')) {
            foreach (Form::getFieldData('roles') as $role_id) {
                if (!Database::table('umg_users_roles')
                    ->values([
                        ['user_id', $user_id],
                        ['role_id', $role_id],
                    ])
                    ->insert()) {
                    Form::setState('Cannot add a new user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }
            }
        }

        if (!Database::commit()) {
            Form::setState('Cannot add a new user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('User has been successfully added.', 'The user will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::reload();
    }


    public static function deleteAttendance()
    {
        if (!Permission::can('delete-attendance')) {
            Form::setState('Cannot delete the attendance. Please try again later', 'You are not authorized to delete the attendance.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('atd_users_attendance')
            ->where([
                  ['id', '=', Form::getFieldData('delete_attendance')], //DELETE SHIT
            ])
            ->purge()) {
            Form::setState('Cann1ot delete the attendance. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Attendance has been successfully deleted', 'The attendance will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }
    /**
     * Enable the user.
     */
    public static function enableUser()
    {
        if (!Permission::can('enable-user')) {
            Form::setState('Cannot enable the user. Please try again later', 'You are not authorized to enable the user.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_users')
            ->where([
                ['id', '=', Form::getFieldData('enable_user')],
                ['disabled_at', 'IS NOT NULL'],
                ['disabled_by', 'IS NOT NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->enable()) {
            Form::setState('Cannot enable the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('User has been successfully enabled', 'The user will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Restore the user.
     */
    public static function restoreUser()
    {
        if (!Permission::can('restore-user')) {
            Form::setState('Cannot restore the user. Please try again later', 'You are not authorized to restore the user.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_users')
            ->where([
                ['id', '=', Form::getFieldData('restore_user')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->restore()) {
            Form::setState('Cannot restore the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('User has been successfully restored', 'The user will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Purge the user.
     */
    public static function purgeUser()
    {
        if (!Permission::can('purge-user')) {
            Form::setState('Cannot purge the the user. Please try again later', 'You are not authorized to purge the user.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_users')
            ->where([
                ['id', '=', Form::getFieldData('purge_user')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->purge()) {
            Form::setState('Cannot purge the the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('User has been successfully purged', 'The user will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }
}
