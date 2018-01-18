<?php
namespace App;

use LPU\Database;
use LPU\Datalist;
use LPU\Form;
use LPU\Permission;
use LPU\Placeholder;
use LPU\Route;

class Academics
{
    private static $course_data = [];
    private static $subject_data = [];
    private static $section_data = [];
    private static $class_data = [];
    private static $classlist_data = [];

public static function displayClassTable()
    {
        if (Permission::isAdmin() == true) {
            $where = array("a.assigned_professor", "IS NOT NULL");
            // var_dump($where);
        } else {
            $where = array("a.assigned_professor", " = " , Permission::getUserId());
            // var_dump($where);
        }

        switch (Route::currentData()) {
           case 'created':
           Datalist::displayTable([
               'id'          => 'ID',
               'faculty'     => 'FACULTY',
               'name'        => 'COURSE CODE',
               'description' => 'DESCRIPTION',
               'subj_type'   => 'SUBJECT TYPE',
               'section'     => 'SECTION',
               'time'        => 'TIME',
               'day'         => 'DAY',
               // 'user'         => 'user',
           ], Database::table('clm_classes a')
           ->leftJoin([
               'umg_users b' => [
                   'a.assigned_professor = b.id'
               ],
               'acd_subjects c' => [
                   'a.subject_id = c.id'
               ],
               'clm_classes_schedules d' => [
                         'a.id = d.class_id' //kuha time_start, time_end
                     ],
                     'clm_days e' => [
                         'd.day_id = e.id' //kuha time_start, time_end
                     ],
                     'acd_sections f' => [
                       'a.section_id = f.id'
                   ],
                   'acd_subject_legend g' => [
                       'd.subject_legend_id = g.id'
                   ],
               ])
           ->where([
               ['a.deleted_at', 'IS NULL'],
               ['a.deleted_by', 'IS NULL'],
               $where,
           ])
           ->select([
               'a.id',
               Database::concat([
                   'b.first_name',
                   "' '",
                   'b.last_name',
               ], 'faculty'),
               'c.name',
               'c.description',
               'g.subject_type AS subj_type',
               'f.name AS section',
               Database::concat([
                  Database::dateFormat('d.started_at', '\'%l:%i %p\''),
                  '" - "',
                  Database::dateFormat('d.ended_at', '\'%l:%i %p\''),
              ], 'time'),
               'e.name AS day',
           ])
           ->orderBy('b.first_name', 'desc')
           ->fetchAll(), function ($id) {
             $action = '';

             if (Permission::can('view-class')) {
                 $action .= "<form>
                 <a class='btn btn-warning btn-xs' href='" . Route::getURL('view-class', $id) . "' title='" . Route::getName('view-class')  . "'>" . Route::getIcon('view-class')  . "</a>
                 </form>";
             }

             if (Permission::can('edit-class')) {
                 $action .= "<form method='POST'>
                 <a class='btn btn-success btn-xs' href='" . Route::getURL('edit-class', $id) . "' title='" . Route::getName('edit-class')  . "'>" . Route::getIcon('edit-class')  . "</a>
                 </form>";
             }

                  //  if (Permission::can('disable-class')) {
                  //      $action .= "<form method='POST'>
                  //                    <button class='btn btn-default btn-xs' name='disable_class' title='" . Route::getName('disable-class')  . "' type='submit' value='{$id}'>" . Route::getIcon('disable-class')  . "</button>
                  //                  </form>";
                  //  }

             if (Permission::can('delete-class')) {
                 $action .= "<form method='POST'>
                 <button class='btn btn-danger btn-xs' name='delete_class' title='" . Route::getName('delete-class')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-class')  . "</button>
                 </form>";
             }

             return $action;
         });
           break;
           case 'disabled':
           Datalist::displayTable([
               'id'          => 'ID',
               'faculty'     => 'FACULTY',
               'name'        => 'COURSE CODE',
               'description' => 'DESCRIPTION',
           ], Database::table('clm_classes a')
           ->leftJoin([
               'umg_users b' => [
                   'a.assigned_professor = b.id'
               ],
               'acd_subjects c' => [
                   'a.subject_id = c.id'
               ],
           ])
           ->where([
               ['a.deleted_at', 'IS NOT NULL'],
               ['a.deleted_by', 'IS NOT NULL'],
               ['a.disabled_at', 'IS NOT NULL'],
               ['a.disabled_by', 'IS NOT NULL'],
           ])
           ->select([
               'a.id',
               Database::concat([
                   'b.first_name',
                   "' '",
                   'b.last_name',
               ], 'faculty'),
               'c.name',
               'c.description',
           ])
           ->fetchAll(), function ($id) {
               $action = '';

               if (Permission::can('enable-class')) {
                   $action .= "<form method='POST'>
                   <button class='btn btn-default btn-xs' name='enable_class' title='" . Route::getName('enable-class')  . "' type='submit' value='{$id}'>" . Route::getIcon('enable-class')  . "</button>
                   </form>";
               }

               if (Permission::can('delete-class')) {
                   $action .= "<form method='POST'>
                   <button class='btn btn-default btn-xs' name='delete_class' title='" . Route::getName('delete-class')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-class')  . "</button>
                   </form>";
               }

               return $action;
           });

       }
   }



/**
 * Load the class data.
 */
public static function loadClassData()
{
    self::$class_data = Database::table('clm_classes a')
            ->where([
                ['a.id', '=', Route::currentData()],
            ])
        ->select([
          'a.id',
            // 'b.username',
            // 'c.name',
            // 'c.description',
            // 'f.section',
            // 'd.started_at',
            // 'd.ended_at',
            // 'd.name',

            //
            Database::plain(0)
                ->table('umg_users', 0)
                ->where([
                    ['umg_users.id', '=', 'a.assigned_professor'],
                ], 0)
                ->select([
                    Database::concat([
                        Database::condition('umg_users.disabled_at IS NULL AND umg_users.disabled_by IS NULL', "' '", "' text-disabled'"),
                        'umg_users.first_name',
                        '" "',
                        'umg_users.last_name',
                    ], "' '"),
                ], 0, 'professor_name'),
            Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
            Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),
            //SUBJECT CODE
            Database::plain(0)
                ->table('acd_subjects', 0)
                ->where([
                    ['acd_subjects.id', '=', 'a.subject_id'],
                ], 0)
                ->select([
                    Database::concat([
                        Database::condition('acd_subjects.disabled_at IS NULL AND acd_subjects.disabled_by IS NULL', "' '", "' text-disabled'"),
                        'acd_subjects.name',
                    ], "' '"),
                ], 0, 'subject_code'),
            Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
            Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),

            //SUBJECT DESCRIPTION
            Database::plain(0)
                ->table('acd_subjects', 0)
                ->where([
                    ['acd_subjects.id', '=', 'a.subject_id'],
                ], 0)
                ->select([
                    Database::concat([
                        Database::condition('acd_subjects.disabled_at IS NULL AND acd_subjects.disabled_by IS NULL', "' '", "' text-disabled'"),
                        'acd_subjects.description',
                    ], "' '"),
                ], 0, 'subject_description'),
            Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
            Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),

            //SECTION
            Database::plain(0)
                ->table('acd_sections', 0)
                ->where([
                    ['acd_sections.id', '=', 'a.section_id'],
                ], 0)
                ->select([
                    Database::concat([
                        Database::condition('acd_sections.disabled_at IS NULL AND acd_sections.disabled_by IS NULL', "' '", "' text-disabled'"),
                        'acd_sections.name',
                    ], "' '"),
                ], 0, 'section'),
            Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
            Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),

            //TIME
            Database::plain(0)
                ->table('clm_classes_schedules', 0)
                ->where([
                    ['clm_classes_schedules.class_id', '=', 'a.id'],
                ], 0)
                ->select([
                    Database::groupConcat([

                        '"-"',
                        'clm_classes_schedules.ended_at',
                    ], "'<br>'"),
                ], 0, 'time'),
            Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
            Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),

        ])
        ->fetch();
}

/**
 * Display the course data.
 *
 * @param string $data
 */
public static function displayClassData($data)
{
    echo self::$class_data[$data] ? self::$class_data[$data] : '<span class=\'text-muted\'>' . Placeholder::get('long') . '</span>' ;
}

/**
 * Load the class data.
 */



public static function displayClassSelect($default_data = null)
{
    Datalist::displaySelect(['class'], Database::table('clm_classes a')
        ->leftJoin([
          'acd_subjects b' => [
            'a.subject_id = b.id'
          ],
          'clm_classes_schedules c' => [
            'a.id = c.class_id'
          ],
          'clm_days d' => [
            'c.day_id = d.id'
          ],
          'acd_sections e' => [
            'a.section_id = e.id'
          ],
          'acd_subject_legend f' => [
            'c.subject_legend_id = f.id'
          ],
        ])
        // ->where([
        //     // ['deleted_at', 'IS NULL'],
        //     // ['deleted_by', 'IS NULL'],
        // ])
        ->select([
          'a.id',
          Database::concat([
              'b.description',
              "' | '",
              'e.name',
              "' | '",
              'd.name',
              "' | '",
              'f.subject_type',
          ], 'class'),




            // 'disabled_at',
            // 'disabled_by',
        ])
        ->fetchAll(), $default_data);
}

public static function displayClassListTable()
    {
        if (Permission::isAdmin() == true) {
            $where = array("a.assigned_professor", "IS NOT NULL");
            // var_dump($where);
        } else {
            $where = array("a.assigned_professor", " = " , Permission::getUserId());
            // var_dump($where);
        }

        switch (Route::currentData()) {
           case 'created':
           Datalist::displayTable([
               'id'          => 'ID',
               'subject'     => 'SUBJECT',
               'section'     => 'SECTION',
               // 'students'     => 'STUDENT(S)',
           ], Database::table('clm_classes a')
           ->leftJoin([
               'acd_sections b' => [
                   'a.section_id = b.id'
               ],
               // 'umg_users c' => [
               //     'c.id = '
               // ],
               // 'umg_student d' => [
               //    'd.user_id = c.id'
               // ],
               'acd_subjects c' => [
                 'a.subject_id = c.id'
               ],
               ])
           ->select([
               'a.id',
               'c.description AS subject',
               'b.name AS section',
               // Database::plain(0)
               //     ->table('umg_student', 0)
               //     ->leftJoin([
               //         'umg_users' => [
               //             'umg_student.user_id = umg_users.id'
               //         ],
               //     ], 0)
               //     ->where([
               //         ['umg_student.section_id', '=', 'a.section_id'],
               //     ], 0)
               //     ->select([
               //         Database::groupConcat([
               //             'umg_users.last_name',
               //             '" "',
               //             'umg_users.first_name'
               //         ], "'<br>'"),
               //     ], 0, 'students'),

               // Database::groupConcat([
               //     'b.first_name',
               //     "' '",
               //     'b.last_name',
               // ], 'students'),
           ])
           ->fetchAll(), function ($id) {
             $action = '';

             if (Permission::can('view-classlist')) {
                 $action .= "<form>
                 <a class='btn btn-warning btn-xs' href='" . Route::getURL('view-classlist', $id) . "' title='" . Route::getName('view-classlist')  . "'>" . Route::getIcon('view-classlist')  . "</a>
                 </form>";
             }

             if (Permission::can('edit-classlist')) {
                 $action .= "<form method='POST'>
                 <a class='btn btn-success btn-xs' href='" . Route::getURL('edit-classlist', $id) . "' title='" . Route::getName('edit-classlist')  . "'>" . Route::getIcon('edit-classlist')  . "</a>
                 </form>";
             }

                  //  if (Permission::can('disable-class')) {
                  //      $action .= "<form method='POST'>
                  //                    <button class='btn btn-default btn-xs' name='disable_class' title='" . Route::getName('disable-class')  . "' type='submit' value='{$id}'>" . Route::getIcon('disable-class')  . "</button>
                  //                  </form>";
                  //  }

             if (Permission::can('delete-classlist')) {
                 $action .= "<form method='POST'>
                 <button class='btn btn-danger btn-xs' name='delete_classlist' title='" . Route::getName('delete-classlist')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-classlist')  . "</button>
                 </form>";
             }

             return $action;
         });
           break;
           // case 'disabled':
           // Datalist::displayTable([
           //     'id'          => 'ID',
           //     'faculty'     => 'FACULTY',
           //     'name'        => 'COURSE CODE',
           //     'description' => 'DESCRIPTION',
           // ], Database::table('clm_classes a')
           // ->leftJoin([
           //     'umg_users b' => [
           //         'a.assigned_professor = b.id'
           //     ],
           //     'acd_subjects c' => [
           //         'a.subject_id = c.id'
           //     ],
           // ])
           // ->where([
           //     ['a.deleted_at', 'IS NOT NULL'],
           //     ['a.deleted_by', 'IS NOT NULL'],
           //     ['a.disabled_at', 'IS NOT NULL'],
           //     ['a.disabled_by', 'IS NOT NULL'],
           // ])
           // ->select([
           //     'a.id',
           //     Database::concat([
           //         'b.first_name',
           //         "' '",
           //         'b.last_name',
           //     ], 'faculty'),
           //     'c.name',
           //     'c.description',
           // ])
           // ->fetchAll(), function ($id) {
           //     $action = '';
           //
           //     if (Permission::can('enable-class')) {
           //         $action .= "<form method='POST'>
           //         <button class='btn btn-default btn-xs' name='enable_class' title='" . Route::getName('enable-class')  . "' type='submit' value='{$id}'>" . Route::getIcon('enable-class')  . "</button>
           //         </form>";
           //     }
           //
           //     if (Permission::can('delete-class')) {
           //         $action .= "<form method='POST'>
           //         <button class='btn btn-default btn-xs' name='delete_class' title='" . Route::getName('delete-class')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-class')  . "</button>
           //         </form>";
           //     }
           //
           //     return $action;
           // });

       }
   }


public static function displayClassListData($data)
{
    echo self::$classlist_data[$data] ? self::$classlist_data[$data] : '<span class=\'text-muted\'>' . Placeholder::get('long') . '</span>' ;
}


public static function loadClassListData()
{
    self::$classlist_data = Database::table('clm_classes a')
            ->where([
                ['a.id', '=', Route::currentData()],
            ])
        ->select([
          'a.id',

            //SUBJECT DESCRIPTION
            Database::plain(0)
                ->table('acd_subjects', 0)
                ->where([
                    ['acd_subjects.id', '=', 'a.subject_id'],
                ], 0)
                ->select([
                    Database::concat([
                        Database::condition('acd_subjects.disabled_at IS NULL AND acd_subjects.disabled_by IS NULL', "' '", "' text-disabled'"),
                        'acd_subjects.description',
                    ], "' '"),
                ], 0, 'subject'),
            Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
            Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),

            //Student name
            Database::plain(0)
                ->table('umg_student', 0)
                ->first([])
                ->leftJoin([
                    'umg_users' => [
                        'umg_student.user_id = umg_users.id'
                    ],
                ], 0)
                ->where([
                    ['umg_student.section_id', '=', 'a.section_id'],
                ], 0)
                ->select([
                    Database::groupConcat([
                        'umg_users.last_name',
                        '" "',
                        'umg_users.first_name'
                    ], "'<br>'"),
                ], 0, 'students'),
            Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
            Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),


            Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
            Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),

        ])
        ->fetch();
}



/**
 * Load the course field data.
 */
public static function loadClassFieldData()
{
    if ($data = Database::table('clm_classes a')
        ->leftJoin([
            'clm_classes_schedules b' => [
                'a.id = b.class_id'
            ]
        ])
        ->where([
            ['a.id', '=', Route::currentData()],
        ])
        ->select([
            'a.subject_id',
            'a.section_id',
            'a.assigned_professor',
            'b.subject_legend_id',
            'b.day_id',
            'b.started_at',
            'b.ended_at',
            'b.room_id',
        ])
        ->fetch()) {
        Form::createFieldData('subject', $data['subject_id']);
        Form::createFieldData('section', $data['section_id']);
        Form::createFieldData('professor', $data['assigned_professor']);
        Form::createFieldData('subject_type', $data['subject_legend_id']);
        Form::createFieldData('days', $data['day_id']);
        Form::createFieldData('started_at', $data['started_at']);
        Form::createFieldData('ended_at', $data['ended_at']);
        Form::createFieldData('room', $data['room_id']);

    }
}

//first step sa edit
public static function validateClass()
{
    if (!Database::table('clm_classes')
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

public static function addNewClass()
{
    if (!Permission::can('add-new-class')) {
        Form::setState('Cannot add a new class. Please try again later', 'You are not authorized to add new user.', Form::ALERT_ERROR, true);
        return;
    }

    /*
    if (Database::table('clm_classes')
        ->where([
            ['id', '=', Form::getFieldData('id')],
        ])
        ->select()
        ->fetch()) {
        Form::setState('Cannot add a new class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
        Form::setFieldState('id', 'Class already exist.', Form::VALIDATION_ERROR);
        return;
    }
    */

    if (!Database::table('clm_classes')
        ->values([
            ['subject_id', Form::getFieldData('subject')],
            ['section_id', Form::getFieldData('section')],
            ['assigned_professor', Form::getFieldData('professor')],
        ])
        ->insert()) {
        Form::setState('Cannot add a new class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
        return;
    }

    $class_id = Database::lastInsertId();

    if (!Database::table('clm_classes_schedules')
        ->values([
            ['class_id', $class_id],
            ['subject_legend_id', Form::getFieldData('subject_type')],
            ['day_id', Form::getFieldData('days')],
            ['started_at', Form::getFieldData('started_at')],
            ['ended_at', Form::getFieldData('ended_at')],
            ['room_id', Form::getFieldData('room')],
        ])
        ->insert()) {
        Form::setState('Cannot add a new class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
        return;
    }

    Form::setState('Class has been successfully added.', 'The class will now be available in the system..', Form::ALERT_SUCCESS, true);

    Route::go(Route::getParent(Route::current()));
}

public static function editClass()
{
    if (!Permission::can('edit-class')) {
        Form::setState('Cannot edit the class. Please try again later', 'You are not authorized to edit the class.', Form::ALERT_ERROR, true);
        return;
    }

    Database::beginTransaction();

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

    if (!Database::table('clm_classes')
        ->set([
            ['subject_id', Form::getFieldData('subject')],
            ['section_id', Form::getFieldData('section')],
            ['assigned_professor', Form::getFieldData('professor')],
        ])
        ->where([
            ['id', '=', Route::currentData()],
        ])
        ->update()) {
        Form::setState('Cannot edit the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
        return;
    }

    if (!Database::table('clm_classes_schedules')
        ->set([
            ['subject_legend_id', Form::getFieldData('subject_type')],
            ['day_id', Form::getFieldData('days')],
            ['started_at', Form::getFieldData('started_at')],
            ['ended_at', Form::getFieldData('ended_at')],
            ['room_id', Form::getFieldData('room')],
        ])
        ->where([
            ['class_id', '=', Route::currentData()],
        ])
        ->update()) {
          Form::setState('Cannot edit the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
          return;
    }

    if (!Database::commit()) {
        Form::setState('Cannot edit the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
        return;
    }

    Form::setState('Class has been successfully edited', 'The class will now be updated in the system.', Form::ALERT_SUCCESS, true);

    Route::go(Route::getParent(Route::current()));
}

public static function deleteClass()
{
    if (!Permission::can('delete-class')) {
        Form::setState('Cannot delete the class. Please try again later', 'You are not authorized to delete the class.', Form::ALERT_ERROR, true);
        return;
    }

    if (!Database::table('clm_classes')
        ->where([
            ['id', '=', Form::getFieldData('delete_class')],
            ['deleted_at', 'IS NULL'],
            ['deleted_by', 'IS NULL'],
        ])
        ->delete()) {
        Form::setState('Cannot delete the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
        return;
    }

    Form::setState('Class has been successfully deleted', 'The class will no longer be available in the system.', Form::ALERT_SUCCESS, true);

    Route::reload();
}

/**
 * Enable the class.
 */
public static function enableClass()
{
    if (!Permission::can('enable-class')) {
        Form::setState('Cannot enable the class. Please try again later', 'You are not authorized to enable the class.', Form::ALERT_ERROR, true);
        return;
    }

    if (!Database::table('clm_classes')
        ->where([
            ['id', '=', Form::getFieldData('enable_class')],
            ['disabled_at', 'IS NOT NULL'],
            ['disabled_by', 'IS NOT NULL'],
            ['deleted_at', 'IS NULL'],
            ['deleted_by', 'IS NULL'],
        ])
        ->enable()) {
        Form::setState('Cannot enable the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
        return;
    }

    Form::setState('Class has been successfully enabled', 'The class will now be available in the system..', Form::ALERT_SUCCESS, true);

    Route::reload();
}

/**
 * Restore the class.
 */
public static function restoreClass()
{
    if (!Permission::can('restore-class')) {
        Form::setState('Cannot restore the class. Please try again later', 'You are not authorized to restore the class.', Form::ALERT_ERROR, true);
        return;
    }

    if (!Database::table('clm_classes')
        ->where([
            ['id', '=', Form::getFieldData('restore_class')],
            ['deleted_at', 'IS NOT NULL'],
            ['deleted_by', 'IS NOT NULL'],
        ])
        ->restore()) {
        Form::setState('Cannot restore the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
        return;
    }

    Form::setState('Class has been successfully restored', 'The class will now be available in the system..', Form::ALERT_SUCCESS, true);

    Route::reload();
}

/**
 * Purge the class.
 */
public static function purgeClass()
{
    if (!Permission::can('purge-class')) {
        Form::setState('Cannot purge the class. Please try again later', 'You are not authorized to purge the class.', Form::ALERT_ERROR, true);
        return;
    }

    if (!Database::table('clm_classes')
        ->where([
            ['id', '=', Form::getFieldData('purge_class')],
            ['deleted_at', 'IS NOT NULL'],
            ['deleted_by', 'IS NOT NULL'],
        ])
        ->purge()) {
        Form::setState('Cannot purge the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
        return;
    }

    Form::setState('Class has been successfully purged', 'The class will no longer be available in the system.', Form::ALERT_SUCCESS, true);

    Route::reload();
}

public static function displayStudentClassesTable()
    {
        // if (Permission::isAdmin() == true) {
        //     $where = array("a.assigned_professor", "IS NOT NULL");
        //     // var_dump($where);
        // } else {
        //     $where = array("a.assigned_professor", " = " , Permission::getUserId());
        //     // var_dump($where);
        // }

        switch (Route::currentData()) {
           case 'created':
           Datalist::displayTable([
               'id'          => 'ID',
               'student'     => 'STUDENT NAME',
               'subjects'       => 'SUBJECT(S)',
           ], Database::table('umg_users_classes a')
           ->leftJoin([
               'umg_users b' => [
                   'b.id = a.user_id'
               ],
               'clm_classes c' =>[
                   'c.id = a.class_id'
               ],
               'acd_subjects d' =>[
                  'd.id = c.subject_id'
               ],
               ])
           // ->where([
           //     ['a.deleted_at', 'IS NULL'],
           //     ['a.deleted_by', 'IS NULL'],
           //     $where,
           // ])
           ->select([
               'a.id',
               Database::concat([
                   'b.last_name',
                   "' '",
                   'b.first_name',
               ], 'student'),
               Database::groupConcat([
                   'd.description',
               ], "''", "subjects"),
             ])

           // ->orderBy('b.last_name', 'desc')
           ->fetchAll(), function ($id) {
             $action = '';

             if (Permission::can('view-student-classes')) {
                 $action .= "<form>
                 <a class='btn btn-warning btn-xs' href='" . Route::getURL('view-student-classes', $id) . "' title='" . Route::getName('view-student-classes')  . "'>" . Route::getIcon('view-student-classes')  . "</a>
                 </form>";
             }

             if (Permission::can('edit-student-classes')) {
                 $action .= "<form method='POST'>
                 <a class='btn btn-success btn-xs' href='" . Route::getURL('edit-student-classes', $id) . "' title='" . Route::getName('edit-student-classes')  . "'>" . Route::getIcon('edit-student-classes')  . "</a>
                 </form>";
             }

                  //  if (Permission::can('disable-class')) {
                  //      $action .= "<form method='POST'>
                  //                    <button class='btn btn-default btn-xs' name='disable_class' title='" . Route::getName('disable-class')  . "' type='submit' value='{$id}'>" . Route::getIcon('disable-class')  . "</button>
                  //                  </form>";
                  //  }

             if (Permission::can('delete-student-classes')) {
                 $action .= "<form method='POST'>
                 <button class='btn btn-danger btn-xs' name='delete_class' title='" . Route::getName('delete-student-classes')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-student-classes')  . "</button>
                 </form>";
             }

             return $action;
         });
           break;
           // case 'disabled':
           // Datalist::displayTable([
           //     'id'          => 'ID',
           //     'faculty'     => 'FACULTY',
           //     'name'        => 'COURSE CODE',
           //     'description' => 'DESCRIPTION',
           // ], Database::table('clm_classes a')
           // ->leftJoin([
           //     'umg_users b' => [
           //         'a.assigned_professor = b.id'
           //     ],
           //     'acd_subjects c' => [
           //         'a.subject_id = c.id'
           //     ],
           // ])
           // ->where([
           //     ['a.deleted_at', 'IS NOT NULL'],
           //     ['a.deleted_by', 'IS NOT NULL'],
           //     ['a.disabled_at', 'IS NOT NULL'],
           //     ['a.disabled_by', 'IS NOT NULL'],
           // ])
           // ->select([
           //     'a.id',
           //     Database::concat([
           //         'b.first_name',
           //         "' '",
           //         'b.last_name',
           //     ], 'faculty'),
           //     'c.name',
           //     'c.description',
           // ])
           // ->fetchAll(), function ($id) {
           //     $action = '';
           //
           //     if (Permission::can('enable-class')) {
           //         $action .= "<form method='POST'>
           //         <button class='btn btn-default btn-xs' name='enable_class' title='" . Route::getName('enable-class')  . "' type='submit' value='{$id}'>" . Route::getIcon('enable-class')  . "</button>
           //         </form>";
           //     }
           //
           //     if (Permission::can('delete-class')) {
           //         $action .= "<form method='POST'>
           //         <button class='btn btn-default btn-xs' name='delete_class' title='" . Route::getName('delete-class')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-class')  . "</button>
           //         </form>";
           //     }
           //
           //     return $action;
           // });

       }
   }


    /**
     * Validate the class.
     */
    public static function validateAssignedClass()
    {
        if (!Database::table('clm_classes')
            ->where(array_merge([
                ['id', '=', Route::currentData()],
                ['assigned_professor', '=', Authentication::getAuthenticatedUser()],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ], (Route::current() == 'import-assigned-class' ? [
                ['imported_at', 'IS NULL'],
                ['imported_by', 'IS NULL'],
                ['finalized_at', 'IS NULL'],
                ['finalized_by', 'IS NULL'],
            ] : [])))
            ->show(1)
            ->select()
            ->fetch()) {
            Route::go(Route::getParent(Route::current()));
        }
    }

    /**
      * Load the class data.
      */
    public static function loadAssignedClassData()
    {
        if (Route::current() == 'print-assigned-class-waiver-seat-plan') {
            self::$class_data = Database::table('clm_classes a')
                ->where([
                    ['a.id', '=', Route::currentData()],
                ])
                ->show(1)
                ->select([
                    'a.id',
                    Database::plain(0)
                        ->table('clm_laboratories', 0)
                        ->where([
                            ['clm_laboratories.id', '=', 'a.laboratory_id'],
                            ['clm_laboratories.deleted_at', 'IS NULL'],
                            ['clm_laboratories.deleted_by', 'IS NULL'],
                        ], 0)
                        ->select([
                            Database::concat([
                                "'<span class=\''",
                                Database::condition('clm_laboratories.disabled_at IS NULL AND clm_laboratories.disabled_by IS NULL', "' '", "' text-disabled'"),
                                "'\'>'",
                                'clm_laboratories.name',
                                "'</span>'",
                            ]),
                        ], 0, 'laboratory'),
                    Database::plain(0)
                        ->table('acd_subjects', 0)
                        ->leftJoin([
                            'clm_classes' => [
                                'acd_subjects.id = clm_classes.laboratory_id'
                            ],
                        ], 0)
                        ->where([
                            ['acd_subjects.deleted_at', 'IS NULL'],
                            ['acd_subjects.deleted_by', 'IS NULL'],
                            ['clm_classes.id', '=', 'a.id'],
                        ], 0)
                        ->select([
                            Database::concat([
                                "'<span class=\''",
                                Database::condition('acd_subjects.disabled_at IS NULL AND acd_subjects.disabled_by IS NULL', "' '", "' text-disabled'"),
                                "'\'>'",
                                'acd_subjects.name',
                                "'</span>'",
                            ], "' '"),
                        ], 0, 'subject'),
                    Database::plain(0)
                        ->table('umg_users', 0)
                        ->where([
                            ['umg_users.id', '=', 'a.assigned_professor'],
                            ['umg_users.deleted_at', 'IS NULL'],
                            ['umg_users.deleted_by', 'IS NULL'],
                        ], 0)
                        ->select([
                            Database::concat([
                                "'<span class=\''",
                                Database::condition('umg_users.disabled_at IS NULL AND umg_users.disabled_by IS NULL', "' '", "' text-disabled'"),
                                "'\'>'",
                                'umg_users.first_name',
                                "' '",
                                'umg_users.last_name',
                                "'</span>'",
                            ]),
                        ], 0, 'assigned_professor'),
                    Database::plain(0)
                        ->table('clm_classes_schedules', 0)
                        ->innerJoin([
                            'clm_days' => [
                                'clm_classes_schedules.day_id = clm_days.id'
                            ],
                        ], 0)
                        ->where([
                            ['clm_classes_schedules.class_id', '=', 'a.id'],
                        ], 0)
                        ->select([
                            Database::groupConcat([
                                'clm_days.name',
                            ], "'/'"),
                        ], 0, 'days'),
                    Database::plain(0)
                        ->table('clm_classes_schedules', 0)
                        ->innerJoin([
                            'clm_days' => [
                                'clm_classes_schedules.day_id = clm_days.id'
                            ],
                        ], 0)
                        ->where([
                            ['clm_classes_schedules.class_id', '=', 'a.id'],
                        ], 0)
                        ->select([
                            Database::groupConcat([
                                Database::dateFormat('clm_classes_schedules.started_at', '\'%l:%i:%s %p\''),
                                '\' - \'',
                                Database::dateFormat('clm_classes_schedules.ended_at', '\'%l:%i:%s %p\''),
                            ], "'/'"),
                        ], 0, 'time'),
                    Database::plain(0)
                        ->table('clm_laboratories_computers b', 0)
                        ->leftJoin([
                            'clm_classes_seat_plans c' => [
                                'b.computer_id = c.computer_id'
                            ],
                        ], 0)
                        ->where([
                            ['b.laboratory_id', '=', 'a.laboratory_id'],
                        ], 0)
                        ->select([
                            Database::groupConcat([
                                "'<tr>'",
                                "'<td>'",
                                Database::plain(1)
                                    ->table('clm_computers', 1)
                                    ->where([
                                        ['clm_computers.id', '=', 'b.computer_id'],
                                        ['clm_computers.deleted_at', 'IS NULL'],
                                        ['clm_computers.deleted_by', 'IS NULL'],
                                    ], 1)
                                    ->select([
                                        Database::concat([
                                            "'<span class=\''",
                                            Database::condition('clm_computers.disabled_at IS NULL AND clm_computers.disabled_by IS NULL', "' '", "' text-disabled'"),
                                            "'\'>'",
                                            'clm_computers.name',
                                            "'</span>'",
                                        ], "' '"),
                                    ], 1),
                                "'</td>'",
                                "'<td>'",
                                'c.last_name',
                                "', '",
                                'c.first_name',
                                "'</td>'",
                                "'<td>'",
                                'c.student_number',
                                "'</td>'",
                                "'<td>'",
                                Database::plain(1)
                                    ->table('acd_sections', 1)
                                    ->where([
                                        ['acd_sections.id', '=', 'a.section_id'],
                                        ['acd_sections.deleted_at', 'IS NULL'],
                                        ['acd_sections.deleted_by', 'IS NULL'],
                                    ], 1)
                                    ->select([
                                        Database::concat([
                                            "'<span class=\''",
                                            Database::condition('acd_sections.disabled_at IS NULL AND acd_sections.disabled_by IS NULL', "' '", "' text-disabled'"),
                                            "'\'>'",
                                            'acd_sections.name',
                                            "'</span>'",
                                        ], "' '"),
                                    ], 1),
                                "'</td>'",
                                "'<td>'",
                                Database::plain(1)
                                    ->table('umg_departments', 1)
                                    ->leftJoin([
                                        'acd_courses' => [
                                            'umg_departments.id = acd_courses.department_id'
                                        ],
                                    ], 1)
                                    ->where([
                                        ['umg_departments.deleted_at', 'IS NULL'],
                                        ['umg_departments.deleted_by', 'IS NULL'],
                                        ['acd_courses.id', '=', 'c.course_id'],
                                    ], 1)
                                    ->select([
                                        Database::concat([
                                            "'<span class=\''",
                                            Database::condition('umg_departments.disabled_at IS NULL AND umg_departments.disabled_by IS NULL', "' '", "' text-disabled'"),
                                            "'\'>'",
                                            'umg_departments.acronym',
                                            "'</span>'",
                                        ], "' '"),
                                    ], 1),
                                "'</td>'",
                                "'<td></td>'",
                                "'<td></td>'",
                                "'</tr>'",
                            ], "' '"),
                        ], 0, 'class_list'),
                    Database::plain(0)
                        ->table('acd_sections', 0)
                        ->where([
                            ['acd_sections.id', '=', 'a.section_id'],
                            ['acd_sections.deleted_at', 'IS NULL'],
                            ['acd_sections.deleted_by', 'IS NULL'],
                        ], 0)
                        ->select([
                            Database::concat([
                                "'<span class=\''",
                                Database::condition('acd_sections.disabled_at IS NULL AND acd_sections.disabled_by IS NULL', "' '", "' text-disabled'"),
                                "'\'>'",
                                'acd_sections.name',
                                "'</span>'",
                            ], "' '"),
                        ], 0, 'section'),
                    Database::plain(0)
                        ->table('acd_subjects', 0)
                        ->leftJoin([
                            'clm_classes' => [
                                'acd_subjects.id = clm_classes.laboratory_id'
                            ],
                        ], 0)
                        ->where([
                            ['acd_subjects.deleted_at', 'IS NULL'],
                            ['acd_subjects.deleted_by', 'IS NULL'],
                            ['clm_classes.id', '=', 'a.id'],
                        ], 0)
                        ->select([
                            Database::concat([
                                "'<span class=\''",
                                Database::condition('acd_subjects.disabled_at IS NULL AND acd_subjects.disabled_by IS NULL', "' '", "' text-disabled'"),
                                "'\'>'",
                                'acd_subjects.description',
                                "'</span>'",
                            ], "' '"),
                        ], 0, 'subject_description'),
                    Database::plain(0)
                        ->table('clm_laboratories_computers b', 0)
                        ->leftJoin([
                            'clm_classes_seat_plans c' => [
                                'b.computer_id = c.computer_id'
                            ],
                        ], 0)
                        ->where([
                            ['b.laboratory_id', '=', 'a.laboratory_id'],
                        ], 0)
                        ->select([
                            Database::groupConcat([
                                "'<div style=\''",
                                'b.position',
                                "'\'>'",
                                "'<h5>PC No. :'",
                                Database::plain(1)
                                    ->table('clm_computers', 1)
                                    ->where([
                                        ['clm_computers.id', '=', 'b.computer_id'],
                                        ['clm_computers.deleted_at', 'IS NULL'],
                                        ['clm_computers.deleted_by', 'IS NULL'],
                                    ], 1)
                                    ->select([
                                        Database::concat([
                                            "'<span class=\''",
                                            Database::condition('clm_computers.disabled_at IS NULL AND clm_computers.disabled_by IS NULL', "' '", "' text-disabled'"),
                                            "'\'>'",
                                            'clm_computers.name',
                                            "'</span>'",
                                        ], "' '"),
                                    ], 1),
                                "'</h5>'",
                                "'<h5>Name :'",
                                'c.last_name',
                                "', '",
                                'c.first_name',
                                "'</h5>'",
                                "'<h5>Stud. No. :'",
                                'c.student_number',
                                "'</h5>'",
                                "'</div>'",
                            ], "' '"),
                        ], 0, 'class_seat_plan'),
                ])
                ->fetch();
        } else {
            self::$class_data = Database::table('clm_classes a')
                ->where([
                    ['a.id', '=', Route::currentData()],
                ])
                ->show(1)
                ->select([
                    'a.id',
                    Database::plain(0)
                        ->table('clm_laboratories', 0)
                        ->leftJoin([
                            'clm_classes' => [
                                'clm_laboratories.id = clm_classes.laboratory_id'
                            ],
                        ], 0)
                        ->where([
                            ['clm_laboratories.deleted_at', 'IS NULL'],
                            ['clm_laboratories.deleted_by', 'IS NULL'],
                            ['clm_classes.id', '=', 'a.id'],
                        ], 0)
                        ->select([
                            Database::concat([
                                "'<span class=\''",
                                Database::condition('clm_laboratories.disabled_at IS NULL AND clm_laboratories.disabled_by IS NULL', "' '", "' text-disabled'"),
                                "'\'>'",
                                'clm_laboratories.name',
                                "'</span>'",
                            ], "' '"),
                        ], 0, 'laboratory'),
                    Database::plain(0)
                        ->table('acd_sections', 0)
                        ->leftJoin([
                            'clm_classes' => [
                                'acd_sections.id = clm_classes.laboratory_id'
                            ],
                        ], 0)
                        ->where([
                            ['acd_sections.deleted_at', 'IS NULL'],
                            ['acd_sections.deleted_by', 'IS NULL'],
                            ['clm_classes.id', '=', 'a.id'],
                        ], 0)
                        ->select([
                            Database::concat([
                                "'<span class=\''",
                                Database::condition('acd_sections.disabled_at IS NULL AND acd_sections.disabled_by IS NULL', "' '", "' text-disabled'"),
                                "'\'>'",
                                'acd_sections.name',
                                "'</span>'",
                            ], "' '"),
                        ], 0, 'section'),
                    Database::plain(0)
                        ->table('acd_subjects', 0)
                        ->leftJoin([
                            'clm_classes' => [
                                'acd_subjects.id = clm_classes.laboratory_id'
                            ],
                        ], 0)
                        ->where([
                            ['acd_subjects.deleted_at', 'IS NULL'],
                            ['acd_subjects.deleted_by', 'IS NULL'],
                            ['clm_classes.id', '=', 'a.id'],
                        ], 0)
                        ->select([
                            Database::concat([
                                "'<span class=\''",
                                Database::condition('acd_subjects.disabled_at IS NULL AND acd_subjects.disabled_by IS NULL', "' '", "' text-disabled'"),
                                "'\'>'",
                                'acd_subjects.name',
                                "'</span>'",
                                "'<div>('",
                                'acd_subjects.description',
                                "')</div>'",
                            ], "' '"),
                        ], 0, 'subject'),
                    Database::plain(0)
                        ->table('clm_classes_schedules', 0)
                        ->innerJoin([
                            'clm_days' => [
                                'clm_classes_schedules.day_id = clm_days.id'
                            ],
                        ], 0)
                        ->where([
                            ['clm_classes_schedules.class_id', '=', 'a.id'],
                        ], 0)
                        ->select([
                            Database::groupConcat([
                                'clm_days.name',
                                "'<div>('",
                                Database::dateFormat('clm_classes_schedules.started_at', '\'%l:%i:%s %p\''),
                                '\' - \'',
                                Database::dateFormat('clm_classes_schedules.ended_at', '\'%l:%i:%s %p\''),
                                "')</div>'",
                            ], "'<br>'"),
                        ], 0, 'schedules'),
                    Database::plain(0)
                        ->table('umg_users', 0)
                        ->where([
                            ['umg_users.id', '=', 'a.imported_by'],
                            ['umg_users.deleted_at', 'IS NULL'],
                            ['umg_users.deleted_by', 'IS NULL'],
                        ], 0)
                        ->select([
                            Database::concat([
                                "'<span class=\''",
                                Database::condition('umg_users.disabled_at IS NULL AND umg_users.disabled_by IS NULL', "' '", "' text-disabled'"),
                                "'\'>'",
                                'umg_users.first_name',
                                "' '",
                                'umg_users.last_name',
                                "'</span>'",
                                "'<div>('",
                                Database::dateFormat('a.imported_at', '\'%M %d, %Y %l:%i:%s %p\''),
                                "')</div>'",
                                Database::plain(1)
                                    ->table('umg_users_departments', 1)
                                    ->leftJoin([
                                        'umg_departments' => [
                                            'umg_users_departments.department_id = umg_departments.id'
                                        ],
                                    ], 1)
                                    ->where([
                                        ['umg_users_departments.user_id', '=', 'a.imported_by'],
                                        ['umg_departments.deleted_at', 'IS NULL'],
                                        ['umg_departments.deleted_by', 'IS NULL'],
                                    ], 1)
                                    ->select([
                                        Database::groupConcat([
                                            "'<div class=\''",
                                            Database::condition('umg_departments.disabled_at IS NULL AND umg_departments.disabled_by IS NULL', "' '", "' text-disabled'"),
                                            "'\'>('",
                                            'umg_departments.name',
                                            "')</div>'",
                                        ], "' '"),
                                    ], 1),
                            ]),
                        ], 0, 'imported_by'),
                    Database::plain(0)
                        ->table('umg_users', 0)
                        ->where([
                            ['umg_users.id', '=', 'a.finalized_by'],
                            ['umg_users.deleted_at', 'IS NULL'],
                            ['umg_users.deleted_by', 'IS NULL'],
                        ], 0)
                        ->select([
                            Database::concat([
                                "'<span class=\''",
                                Database::condition('umg_users.disabled_at IS NULL AND umg_users.disabled_by IS NULL', "' '", "' text-disabled'"),
                                "'\'>'",
                                'umg_users.first_name',
                                "' '",
                                'umg_users.last_name',
                                "'</span>'",
                                "'<div>('",
                                Database::dateFormat('a.finalized_at', '\'%M %d, %Y %l:%i:%s %p\''),
                                "')</div>'",
                                Database::plain(1)
                                    ->table('umg_users_departments', 1)
                                    ->leftJoin([
                                        'umg_departments' => [
                                            'umg_users_departments.department_id = umg_departments.id'
                                        ],
                                    ], 1)
                                    ->where([
                                        ['umg_users_departments.user_id', '=', 'a.finalized_by'],
                                        ['umg_departments.deleted_at', 'IS NULL'],
                                        ['umg_departments.deleted_by', 'IS NULL'],
                                    ], 1)
                                    ->select([
                                        Database::groupConcat([
                                            "'<div class=\''",
                                            Database::condition('umg_departments.disabled_at IS NULL AND umg_departments.disabled_by IS NULL', "' '", "' text-disabled'"),
                                            "'\'>('",
                                            'umg_departments.name',
                                            "')</div>'",
                                        ], "' '"),
                                    ], 1),
                            ]),
                        ], 0, 'finalized_by'),
                    Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
                    Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),
                ])
                ->fetch();
        }
    }

    /**
     * Display the class data.
     *
     * @param string $data
     */
    public static function displayAssignedClassData($data)
    {
        echo self::$class_data[$data] ? self::$class_data[$data] : '<span class=\'text-muted\'>' . Placeholder::get('long') . '</span>' ;
    }

    /**
     * Import the class.
     */
    public static function importAssignedClass()
    {
        if (!Permission::can('import-assigned-class')) {
            Form::setState('Cannot import the class. Please try again later', 'You are not authorized to import the class.', Form::ALERT_ERROR, true);
            return;
        }

        Database::beginTransaction();

        if (!Database::table('clm_classes')
            ->set([
                ['imported_at', 'NOW()'],
                ['imported_by', Authentication::getAuthenticatedUser()],
            ])
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->update()) {
            Form::setState('Cannot import the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        if (!in_array(Form::getFieldFile('official_class_list', 'type'), ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'xls', 'xlsx'])) {
            Form::setState('Cannot import the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('official_class_list', 'File must be a proper excel file.', Form::VALIDATION_ERROR);
            return;
        }

        $official_class_list = \PHPExcel_IOFactory::createReader('Excel5')
            ->load(Form::getFieldFile('official_class_list', 'tmp_name'))
            ->getSheet(0);

        $computer_id = 0;

        for ($row = 7; $row <= $official_class_list->getHighestRow() - 15; $row++) {
            $student = $official_class_list->rangeToArray("A{$row}:D{$row}", null, true, false)[0];

            if (!in_array($student[0], ['Boys', 'Girls'])) {
                $student_number = $student[1];
                $first_name = explode(',', $student[2])[1];
                $last_name = explode(',', $student[2])[0];
                $course_id = Database::table('acd_courses')
                    ->where([
                        ['name', '=', $student[3]],
                    ])
                    ->show(1)
                    ->select([
                        'id',
                    ])
                    ->fetch()['id'];

                    //
                if (!Database::table('clm_classes_seat_plans')
                    ->values([
                        ['class_id', Route::currentData()],
                        ['computer_id', ++$computer_id],
                        ['student_number', $student_number],
                        ['first_name', ucwords(strtolower($first_name))],
                        ['last_name', ucwords(strtolower($last_name))],
                        ['course_id', $course_id],
                    ])
                    ->insert()) {
                    Form::setState('Cannot import the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }
            }
        }

        if (!Database::commit()) {
            Form::setState('Cannot import the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Class has been successfully imported', 'The class will now be imported.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Clear the class.
     */
    public static function clearAssignedClass()
    {
        if (!Permission::can('clear-assigned-class')) {
            Form::setState('Cannot clear the class. Please try again later', 'You are not authorized to clear the class.', Form::ALERT_ERROR, true);
            return;
        }

        Database::beginTransaction();

        if (!Database::table('clm_classes')
            ->set([
                ['imported_at', null],
                ['imported_by', null],
            ])
            ->where([
                ['id', '=', Form::getFieldData('clear_assigned_class')],
                ['assigned_professor', '=', Authentication::getAuthenticatedUser()],
                ['imported_at', 'IS NOT NULL'],
                ['imported_by', 'IS NOT NULL'],
                ['finalized_at', 'IS NULL'],
                ['finalized_by', 'IS NULL'],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->update()) {
            Form::setState('Cannot clear the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('clm_classes_seat_plans')
            ->where([
                ['class_id', '=', Form::getFieldData('clear_assigned_class')],
            ])
            ->purge()) {
            Form::setState('Cannot clear the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::commit()) {
            Form::setState('Cannot clear the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Class has been successfully cleared', 'The class will now be cleared.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Finalize the class.
     */
    public static function finalizeAssignedClass()
    {
        if (!Permission::can('finalize-assigned-class')) {
            Form::setState('Cannot finalize the class. Please try again later', 'You are not authorized to finalize the class.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('clm_classes')
            ->set([
                ['finalized_at', 'NOW()'],
                ['finalized_by', Authentication::getAuthenticatedUser()],
            ])
            ->where([
                ['id', '=', Form::getFieldData('finalize_assigned_class')],
                ['assigned_professor', '=', Authentication::getAuthenticatedUser()],
                ['imported_at', 'IS NOT NULL'],
                ['imported_by', 'IS NOT NULL'],
                ['finalized_at', 'IS NULL'],
                ['finalized_by', 'IS NULL'],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->update()) {
            Form::setState('Cannot finalize the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Class has been successfully finalized', 'The class will now be finalized.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }






    public static function displayCourseTable()
    {
        switch (Route::currentData()) {
            case 'created':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'description' => 'DESCRIPTION',
                    'department'  => 'DEPARTMENT',
                ], Database::table('acd_courses a')
                    ->where([
                        ['a.disabled_at', 'IS NULL'],
                        ['a.disabled_by', 'IS NULL'],
                        ['a.deleted_at', 'IS NULL'],
                        ['a.deleted_by', 'IS NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.description',
                        Database::plain(0)
                            ->table('umg_departments', 0)
                            ->where([
                                ['umg_departments.id', '=', 'a.department_id'],
                                ['umg_departments.deleted_at', 'IS NULL'],
                                ['umg_departments.deleted_by', 'IS NULL'],
                            ], 0)
                            ->select([
                                Database::concat([
                                    Database::condition('umg_departments.disabled_at IS NULL AND umg_departments.disabled_by IS NULL', "' '", "' text-disabled'"),
                                    'umg_departments.name',
                                ], "' '"),
                            ], 0, 'department'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('view-course')) {
                            $action .= "<form>
                                          <a class='btn btn-warning btn-xs' href='" . Route::getURL('view-course', $id) . "' title='" . Route::getName('view-course')  . "'>" . Route::getIcon('view-course')  . "</a>
                                        </form>";
                        }

                        if (Permission::can('edit-course')) {
                            $action .= "<form method='POST'>
                                          <a class='btn btn-success btn-xs' href='" . Route::getURL('edit-course', $id) . "' title='" . Route::getName('edit-course')  . "'>" . Route::getIcon('edit-course')  . "</a>
                                        </form>";
                        }

                        // if (Permission::can('disable-course')) {
                        //     $action .= "<form method='POST'>
                        //                   <button class='btn btn-default btn-xs' name='disable_course' title='" . Route::getName('disable-course')  . "' type='submit' value='{$id}'>" . Route::getIcon('disable-course')  . "</button>
                        //                 </form>";
                        // }

                        if (Permission::can('delete-course')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-danger btn-xs' name='delete_course' title='" . Route::getName('delete-course')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-course')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'disabled':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'description' => 'DESCRIPTION',
                    'department'  => 'DEPARTMENT',
                    'disabled_by' => 'DISABLED BY',
                ], Database::table('acd_courses a')
                    ->where([
                        ['a.disabled_at', 'IS NOT NULL'],
                        ['a.disabled_by', 'IS NOT NULL'],
                        ['a.deleted_at', 'IS NULL'],
                        ['a.deleted_by', 'IS NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.description',
                        Database::plain(0)
                            ->table('umg_departments', 0)
                            ->where([
                                ['umg_departments.id', '=', 'a.department_id'],
                                ['umg_departments.deleted_at', 'IS NULL'],
                                ['umg_departments.deleted_by', 'IS NULL'],
                            ], 0)
                            ->select([
                                Database::concat([

                                    Database::condition('umg_departments.disabled_at IS NULL AND umg_departments.disabled_by IS NULL', "' '", "' text-disabled'"),

                                    'umg_departments.name',

                                ], "' '"),
                            ], 0, 'department'),
                        Database::getDisabler('a.disabled_at', 'a.disabled_by', 'disabled_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('enable-course')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='enable_course' title='" . Route::getName('enable-course')  . "' type='submit' value='{$id}'>" . Route::getIcon('enable-course')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('delete-course')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='delete_course' title='" . Route::getName('delete-course')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-course')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'deleted':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'description' => 'DESCRIPTION',
                    'department'  => 'DEPARTMENT',
                    'deleted_by'  => 'DELETED BY',
                ], Database::table('acd_courses a')
                    ->where([
                        ['a.deleted_at', 'IS NOT NULL'],
                        ['a.deleted_by', 'IS NOT NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.description',
                        Database::plain(0)
                            ->table('umg_departments', 0)
                            ->where([
                                ['umg_departments.id', '=', 'a.department_id'],
                                ['umg_departments.deleted_at', 'IS NULL'],
                                ['umg_departments.deleted_by', 'IS NULL'],
                            ], 0)
                            ->select([
                                Database::concat([

                                    Database::condition('umg_departments.disabled_at IS NULL AND umg_departments.disabled_by IS NULL', "' '", "' text-disabled'"),

                                    'umg_departments.name',

                                ], "' '"),
                            ], 0, 'department'),
                        Database::getDeleter('a.deleted_at', 'a.deleted_by', 'deleted_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('restore-course')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='restore_course' title='" . Route::getName('restore-course')  . "' type='submit' value='{$id}'>" . Route::getIcon('restore-course')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('purge-course')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='purge_course' title='" . Route::getName('purge-course')  . "' type='submit' value='{$id}'>" . Route::getIcon('purge-course')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            default:
        }
    }

    /**
     * Validate the course.
     */
    public static function validateCourse()
    {
        if (!Database::table('acd_courses')
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
     * Load the course data.
     */
    public static function loadCourseData()
    {
        self::$course_data = Database::table('acd_courses a')
            ->where([
                ['a.id', '=', Route::currentData()],
            ])
            ->select([
                'a.id',
                'a.name',
                'a.description',
                Database::plain(0)
                    ->table('umg_departments', 0)
                    ->where([
                        ['umg_departments.id', '=', 'a.department_id'],
                    ], 0)
                    ->select([
                        Database::concat([

                            Database::condition('umg_departments.disabled_at IS NULL AND umg_departments.disabled_by IS NULL', "' '", "' text-disabled'"),

                            'umg_departments.name',

                        ], "' '"),
                    ], 0, 'department'),
                Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
                Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),
            ])
            ->fetch();
    }

    /**
     * Display the course data.
     *
     * @param string $data
     */
    public static function displayCourseData($data)
    {
        echo self::$course_data[$data] ? self::$course_data[$data] : '<span class=\'text-muted\'>' . Placeholder::get('long') . '</span>' ;
    }

    /**
     * Load the course field data.
     */
    public static function loadCourseFieldData()
    {
        if ($data = Database::table('acd_courses')
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->select()
            ->fetch()) {
            Form::createFieldData('name', $data['name']);
            Form::createFieldData('description', $data['description']);
            Form::createFieldData('department', $data['department_id']);
        }
    }

    /**
     * Add a new course.
     */
    public static function addNewCourse()
    {
        if (!Permission::can('add-new-course')) {
            Form::setState('Cannot add a new course. Please try again later', 'You are not authorized to add a new course.', Form::ALERT_ERROR, true);
            return;
        }

        if (Database::table('acd_courses')
            ->where([
                ['name', '=', Form::getFieldData('name')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot add a new course. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('name', 'Name has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('acd_courses')
            ->values([
                ['name', Form::getFieldData('name')],
                ['description', Form::getFieldData('description')],
                ['department_id', Form::getFieldData('department')],
            ])
            ->insert()) {
            Form::setState('Cannot add a new course. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Course has been successfully added', 'The course will now be available in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Edit the course.
     */
    public static function editCourse()
    {
        if (!Permission::can('edit-course')) {
            Form::setState('Cannot edit the course. Please try again later', 'You are not authorized to edit course.', Form::ALERT_ERROR, true);
            return;
        }

        if (Database::table('acd_courses')
            ->where([
                ['id', '!=', Route::currentData()],
                ['name', '=', Form::getFieldData('name')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot edit the course. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('name', 'Name has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('acd_courses')
            ->set([
                ['name', Form::getFieldData('name')],
                ['description', Form::getFieldData('description')],
                ['department_id', Form::getFieldData('department')],
            ])
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->update()) {
            Form::setState('Cannot edit the course. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Course has been successfully edited', 'The course will now be updated in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Disable the course.
     */
    public static function disableCourse()
    {
        if (!Permission::can('disable-course')) {
            Form::setState('Cannot disable the course. Please try again later', 'You are not authorized to disable the course.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_courses')
            ->where([
                ['id', '=', Form::getFieldData('disable_course')],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->disable()) {
            Form::setState('Cannot disable the course. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Course has been successfully disabled', 'The course will no longer be available but will still appear in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Delete the course.
     */
    public static function deleteCourse()
    {
        if (!Permission::can('delete-course')) {
            Form::setState('Cannot delete the course. Please try again later', 'You are not authorized to delete the course.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_courses')
            ->where([
                ['id', '=', Form::getFieldData('delete_course')],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->delete()) {
            Form::setState('Cannot delete the course. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Course has been successfully deleted', 'The course will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Enable the course.
     */
    public static function enableCourse()
    {
        if (!Permission::can('enable-course')) {
            Form::setState('Cannot enable the course. Please try again later', 'You are not authorized to enable the course.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_courses')
            ->where([
                ['id', '=', Form::getFieldData('enable_course')],
                ['disabled_at', 'IS NOT NULL'],
                ['disabled_by', 'IS NOT NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->enable()) {
            Form::setState('Cannot enable the course. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Course has been successfully enabled', 'The course will now be available in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Restore the course.
     */
    public static function restoreCourse()
    {
        if (!Permission::can('restore-course')) {
            Form::setState('Cannot restore the course. Please try again later', 'You are not authorized to restore the course.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_courses')
            ->where([
                ['id', '=', Form::getFieldData('restore_course')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->restore()) {
            Form::setState('Cannot restore the course. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Course has been successfully restored', 'The course will now be available in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Purge the course.
     */
    public static function purgeCourse()
    {
        if (!Permission::can('purge-course')) {
            Form::setState('Cannot purge the course. Please try again later', 'You are not authorized to purge the course.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_courses')
            ->where([
                ['id', '=', Form::getFieldData('purge_course')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->purge()) {
            Form::setState('Cannot purge the course. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Course has been successfully purged', 'The course will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Display the list of subjects as select box.
     *
     * @param string || array $default_data
     */
    public static function displaySubjectSelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('acd_subjects')
            ->where([
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->select([
                'id',
                Database::concat([
                    'name',
                    "' - '",
                    'description',
                    'disabled_at',
                    'disabled_by',
                ], 'name'),
            ])
            ->fetchAll(), $default_data);
    }

    /**
     * Display the list of subjects as select box.
     *
     * @param string || array $default_data
     */
    public static function displaySubjectLegendSelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('acd_subject_legend')
            ->select([
                'id',
                'name',
            ])
            ->fetchAll(), $default_data);
    }

    /**
     * Display the list of subjects as table.
     */
    public static function displaySubjectTable()
    {
        switch (Route::currentData()) {
            case 'created':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'description' => 'DESCRIPTION',
                ], Database::table('acd_subjects a')
                    ->where([
                        ['a.disabled_at', 'IS NULL'],
                        ['a.disabled_by', 'IS NULL'],
                        ['a.deleted_at', 'IS NULL'],
                        ['a.deleted_by', 'IS NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.description',
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('view-subject')) {
                            $action .= "<form>
                                          <a class='btn btn-warning btn-xs' href='" . Route::getURL('view-subject', $id) . "' title='" . Route::getName('view-subject')  . "'>" . Route::getIcon('view-subject')  . "</a>
                                        </form>";
                        }

                        if (Permission::can('edit-subject')) {
                            $action .= "<form method='POST'>
                                          <a class='btn btn-success btn-xs' href='" . Route::getURL('edit-subject', $id) . "' title='" . Route::getName('edit-subject')  . "'>" . Route::getIcon('edit-subject')  . "</a>
                                        </form>";
                        }

                        // if (Permission::can('disable-subject')) {
                        //     $action .= "<form method='POST'>
                        //                   <button class='btn btn-default btn-xs' name='disable_subject' title='" . Route::getName('disable-subject')  . "' type='submit' value='{$id}'>" . Route::getIcon('disable-subject')  . "</button>
                        //                 </form>";
                        // }

                        if (Permission::can('delete-subject')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-danger btn-xs' name='delete_subject' title='" . Route::getName('delete-subject')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-subject')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'disabled':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'description' => 'DESCRIPTION',
                    'disabled_by' => 'DISABLED BY',
                ], Database::table('acd_subjects a')
                    ->where([
                        ['a.disabled_at', 'IS NOT NULL'],
                        ['a.disabled_by', 'IS NOT NULL'],
                        ['a.deleted_at', 'IS NULL'],
                        ['a.deleted_by', 'IS NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.description',
                        Database::getDisabler('a.disabled_at', 'a.disabled_by', 'disabled_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('enable-subject')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='enable_subject' title='" . Route::getName('enable-subject')  . "' type='submit' value='{$id}'>" . Route::getIcon('enable-subject')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('delete-subject')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='delete_subject' title='" . Route::getName('delete-subject')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-subject')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'deleted':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'description' => 'DESCRIPTION',
                    'deleted_by'  => 'DELETED BY',
                ], Database::table('acd_subjects a')
                    ->where([
                        ['a.deleted_at', 'IS NOT NULL'],
                        ['a.deleted_by', 'IS NOT NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.description',
                        Database::getDeleter('a.deleted_at', 'a.deleted_by', 'deleted_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('restore-subject')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='restore_subject' title='" . Route::getName('restore-subject')  . "' type='submit' value='{$id}'>" . Route::getIcon('restore-subject')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('purge-subject')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='purge_subject' title='" . Route::getName('purge-subject')  . "' type='submit' value='{$id}'>" . Route::getIcon('purge-subject')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            default:
        }
    }

    /**
     * Validate the subject.
     */
    public static function validateSubject()
    {
        if (!Database::table('acd_subjects')
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
     * Load the subject data.
     */
    public static function loadSubjectData()
    {
        self::$subject_data = Database::table('acd_subjects a')
            ->where([
                ['a.id', '=', Route::currentData()],
            ])
            ->select([
                'a.id',
                'a.name',
                'a.description',
                Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
                Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),
            ])
            ->fetch();
    }

    /**
     * Display the subject data.
     *
     * @param string $data
     */
    public static function displaySubjectData($data)
    {
        echo self::$subject_data[$data] ? self::$subject_data[$data] : '<span class=\'text-muted\'>' . Placeholder::get('long') . '</span>' ;
    }

    /**
     * Load the subject field data.
     */
    public static function loadSubjectFieldData()
    {
        if ($data = Database::table('acd_subjects')
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->select()
            ->fetch()) {
            Form::createFieldData('name', $data['name']);
            Form::createFieldData('description', $data['description']);
        }
    }

    /**
     * Add a new subject.
     */
    public static function addNewSubject()
    {
        if (!Permission::can('add-new-subject')) {
            Form::setState('Cannot add a new subject. Please try again later', 'You are not authorized to add a new subject.', Form::ALERT_ERROR, true);
            return;
        }

        if (Database::table('acd_subjects')
            ->where([
                ['name', '=', Form::getFieldData('name')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot add a new subject. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('name', 'Name has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('acd_subjects')
            ->values([
                ['name', Form::getFieldData('name')],
                ['description', Form::getFieldData('description')],
            ])
            ->insert()) {
            Form::setState('Cannot add a new subject. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Subject has been successfully added', 'The subject will now be available in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Edit the subject.
     */
    public static function editSubject()
    {
        if (!Permission::can('edit-subject')) {
            Form::setState('Cannot edit the subject. Please try again later', 'You are not authorized to edit subject.', Form::ALERT_ERROR, true);
            return;
        }

        if (Database::table('acd_subjects')
            ->where([
                ['id', '!=', Route::currentData()],
                ['name', '=', Form::getFieldData('name')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot edit the subject. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('name', 'Name has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('acd_subjects')
            ->set([
                ['name', Form::getFieldData('name')],
                ['description', Form::getFieldData('description')],
            ])
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->update()) {
            Form::setState('Cannot edit the subject. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Subject has been successfully edited', 'The subject will now be updated in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Disable the subject.
     */
    public static function disableSubject()
    {
        if (!Permission::can('disable-subject')) {
            Form::setState('Cannot disable the subject. Please try again later', 'You are not authorized to disable the subject.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_subjects')
            ->where([
                ['id', '=', Form::getFieldData('disable_subject')],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->disable()) {
            Form::setState('Cannot disable the subject. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Subject has been successfully disabled', 'The subject will no longer be available but will still appear in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Delete the subject.
     */
    public static function deleteSubject()
    {
        if (!Permission::can('delete-subject')) {
            Form::setState('Cannot delete the subject. Please try again later', 'You are not authorized to delete the subject.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_subjects')
            ->where([
                ['id', '=', Form::getFieldData('delete_subject')],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->delete()) {
            Form::setState('Cannot delete the subject. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Subject has been successfully deleted', 'The subject will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Enable the subject.
     */
    public static function enableSubject()
    {
        if (!Permission::can('enable-subject')) {
            Form::setState('Cannot enable the subject. Please try again later', 'You are not authorized to enable the subject.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_subjects')
            ->where([
                ['id', '=', Form::getFieldData('enable_subject')],
                ['disabled_at', 'IS NOT NULL'],
                ['disabled_by', 'IS NOT NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->enable()) {
            Form::setState('Cannot enable the subject. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Subject has been successfully enabled', 'The subject will now be available in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Restore the subject.
     */
    public static function restoreSubject()
    {
        if (!Permission::can('restore-subject')) {
            Form::setState('Cannot restore the subject. Please try again later', 'You are not authorized to restore the subject.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_subjects')
            ->where([
                ['id', '=', Form::getFieldData('restore_subject')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->restore()) {
            Form::setState('Cannot restore the subject. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Subject has been successfully restored', 'The subject will now be available in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Purge the subject.
     */
    public static function purgeSubject()
    {
        if (!Permission::can('purge-subject')) {
            Form::setState('Cannot purge the subject. Please try again later', 'You are not authorized to purge the subject.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_subjects')
            ->where([
                ['id', '=', Form::getFieldData('purge_subject')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->purge()) {
            Form::setState('Cannot purge the subject. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Subject has been successfully purged', 'The subject will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Display the list of sections as select box.
     *
     * @param string || array $default_data
     */
    public static function displaySectionSelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('acd_sections')
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
     * Display the list of sections as table.
     */
    public static function displaySectionTable()
    {
        switch (Route::currentData()) {
            case 'created':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'description' => 'DESCRIPTION',
                ], Database::table('acd_sections a')
                    ->where([
                        ['a.disabled_at', 'IS NULL'],
                        ['a.disabled_by', 'IS NULL'],
                        ['a.deleted_at', 'IS NULL'],
                        ['a.deleted_by', 'IS NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.description',
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('view-section')) {
                            $action .= "<form>
                                          <a class='btn btn-warning btn-xs' href='" . Route::getURL('view-section', $id) . "' title='" . Route::getName('view-section')  . "'>" . Route::getIcon('view-section')  . "</a>
                                        </form>";
                        }

                        if (Permission::can('edit-section')) {
                            $action .= "<form method='POST'>
                                          <a class='btn btn-success btn-xs' href='" . Route::getURL('edit-section', $id) . "' title='" . Route::getName('edit-section')  . "'>" . Route::getIcon('edit-section')  . "</a>
                                        </form>";
                        }

                        // if (Permission::can('disable-section')) {
                        //     $action .= "<form method='POST'>
                        //                   <button class='btn btn-default btn-xs' name='disable_section' title='" . Route::getName('disable-section')  . "' type='submit' value='{$id}'>" . Route::getIcon('disable-section')  . "</button>
                        //                 </form>";
                        // }

                        if (Permission::can('delete-section')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-danger btn-xs' name='delete_section' title='" . Route::getName('delete-section')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-section')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'disabled':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'description' => 'DESCRIPTION',
                    'disabled_by' => 'DISABLED BY',
                ], Database::table('acd_sections a')
                    ->where([
                        ['a.disabled_at', 'IS NOT NULL'],
                        ['a.disabled_by', 'IS NOT NULL'],
                        ['a.deleted_at', 'IS NULL'],
                        ['a.deleted_by', 'IS NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.description',
                        Database::getDisabler('a.disabled_at', 'a.disabled_by', 'disabled_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('enable-section')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='enable_section' title='" . Route::getName('enable-section')  . "' type='submit' value='{$id}'>" . Route::getIcon('enable-section')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('delete-section')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='delete_section' title='" . Route::getName('delete-section')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-section')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'deleted':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'description' => 'DESCRIPTION',
                    'deleted_by'  => 'DELETED BY',
                ], Database::table('acd_sections a')
                    ->where([
                        ['a.deleted_at', 'IS NOT NULL'],
                        ['a.deleted_by', 'IS NOT NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.description',
                        Database::getDeleter('a.deleted_at', 'a.deleted_by', 'deleted_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('restore-section')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='restore_section' title='" . Route::getName('restore-section')  . "' type='submit' value='{$id}'>" . Route::getIcon('restore-section')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('purge-section')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='purge_section' title='" . Route::getName('purge-section')  . "' type='submit' value='{$id}'>" . Route::getIcon('purge-section')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            default:
        }
    }

    /**
     * Validate the section.
     */
    public static function validateSection()
    {
        if (!Database::table('acd_sections')
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
     * Load the section data.
     */
    public static function loadSectionData()
    {
        self::$section_data = Database::table('acd_sections a')
            ->where([
                ['a.id', '=', Route::currentData()],
            ])
            ->select([
                'a.id',
                'a.name',
                'a.description',
                Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
                Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),
            ])
            ->fetch();
    }

    /**
     * Display the section data.
     *
     * @param string $data
     */
    public static function displaySectionData($data)
    {
        echo self::$section_data[$data] ? self::$section_data[$data] : '<span class=\'text-muted\'>' . Placeholder::get('long') . '</span>' ;
    }

    /**
     * Load the section field data.
     */
    public static function loadSectionFieldData()
    {
        if ($data = Database::table('acd_sections')
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->select()
            ->fetch()) {
            Form::createFieldData('name', $data['name']);
            Form::createFieldData('description', $data['description']);
        }
    }



    /**
     * Add a new section.
     */
    public static function addNewSection()
    {
        if (!Permission::can('add-new-section')) {
            Form::setState('Cannot add a new section. Please try again later', 'You are not authorized to add a new section.', Form::ALERT_ERROR, true);
            return;
        }

        if (Database::table('acd_sections')
            ->where([
                ['name', '=', Form::getFieldData('name')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot add a new section. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('name', 'Name has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('acd_sections')
            ->values([
                ['name', Form::getFieldData('name')],
                ['description', Form::getFieldData('description')],
            ])
            ->insert()) {
            Form::setState('Cannot add a new section. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Section has been successfully added', 'The section will now be available in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Edit the section.
     */
    public static function editSection()
    {
        if (!Permission::can('edit-section')) {
            Form::setState('Cannot edit the section. Please try again later', 'You are not authorized to edit section.', Form::ALERT_ERROR, true);
            return;
        }

        if (Database::table('acd_sections')
            ->where([
                ['id', '!=', Route::currentData()],
                ['name', '=', Form::getFieldData('name')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot edit the section. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('name', 'Name has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('acd_sections')
            ->set([
                ['name', Form::getFieldData('name')],
                ['description', Form::getFieldData('description')],
            ])
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->update()) {
            Form::setState('Cannot edit the section. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Section has been successfully edited', 'The section will now be updated in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Disable the section.
     */
    public static function disableSection()
    {
        if (!Permission::can('disable-section')) {
            Form::setState('Cannot disable the section. Please try again later', 'You are not authorized to disable the section.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_sections')
            ->where([
                ['id', '=', Form::getFieldData('disable_section')],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->disable()) {
            Form::setState('Cannot disable the section. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Section has been successfully disabled', 'The section will no longer be available but will still appear in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Delete the section.
     */
    public static function deleteSection()
    {
        if (!Permission::can('delete-section')) {
            Form::setState('Cannot delete the section. Please try again later', 'You are not authorized to delete the section.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_sections')
            ->where([
                ['id', '=', Form::getFieldData('delete_section')],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->delete()) {
            Form::setState('Cannot delete the section. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Section has been successfully deleted', 'The section will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Enable the section.
     */
    public static function enableSection()
    {
        if (!Permission::can('enable-section')) {
            Form::setState('Cannot enable the section. Please try again later', 'You are not authorized to enable the section.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_sections')
            ->where([
                ['id', '=', Form::getFieldData('enable_section')],
                ['disabled_at', 'IS NOT NULL'],
                ['disabled_by', 'IS NOT NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->enable()) {
            Form::setState('Cannot enable the section. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Section has been successfully enabled', 'The section will now be available in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Restore the section.
     */
    public static function restoreSection()
    {
        if (!Permission::can('restore-section')) {
            Form::setState('Cannot restore the section. Please try again later', 'You are not authorized to restore the section.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_sections')
            ->where([
                ['id', '=', Form::getFieldData('restore_section')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->restore()) {
            Form::setState('Cannot restore the section. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Section has been successfully restored', 'The section will now be available in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Purge the section.
     */
    public static function purgeSection()
    {
        if (!Permission::can('purge-section')) {
            Form::setState('Cannot purge the section. Please try again later', 'You are not authorized to purge the section.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('acd_sections')
            ->where([
                ['id', '=', Form::getFieldData('purge_section')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->purge()) {
            Form::setState('Cannot purge the section. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Section has been successfully purged', 'The section will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    public static function displayDaySelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('clm_days')
            ->select([
                'id',
                'name',
            ])
            ->fetchAll(), $default_data);
    }

    public static function displayRoomSelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('clm_rooms')
            ->select([
                'id',
                'name',
            ])
            ->fetchAll(), $default_data);
    }


}
