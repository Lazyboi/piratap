<?php
namespace LPU;

class Database
{
    private static $reserved_words = [
        'CURDATE', 'CURTIME', 'NOW()', 'IS NOT NULL', 'IS NULL',
    ];
    private static $connection = null;
    private static $plain_mode = [];
    private static $subquery = [
        'table'    => '',
        'join'     => '',
        'where'    => '',
        'order_by' => '',
        'show'     => '',
        'select'   => null,
    ];
    private static $query = [
        'table'    => '',
        'join'     => '',
        'values'   => '',
        'set'      => '',
        'where'    => '',
        'order_by' => '',
        'show'     => '',
        'select'   => null,
        'params'   => [],
    ];

    /**
     * Set up the database configuration after the connection.
     */
    private static function setup()
    {
        $setup = self::$connection->prepare('SET group_concat_max_len = ' . Config::get('database')['group_concat_max_len']);
        $setup->execute();
    }

    /**
     * Check if column exists in the table.
     *
     * @param string $name
     *
     * @return bool
     */
    private static function checkColumn($name)
    {
        $column = self::$connection->prepare('SHOW COLUMNS FROM ' . self::$query['table'] . " LIKE '{$name}'");
        $column->execute();
        return count($column->fetchAll());
    }

    /**
     * Clean all variables used in the database during execution of query.
     * This is used when after executing a database query to prevent errors.
     *
     * @param int $instance
     */
    private static function clean($instance = null)
    {
        if (!empty(self::$plain_mode[$instance])) {
            self::$subquery[$instance] = [
                'table'    => '',
                'join'     => '',
                'where'    => '',
                'order_by' => '',
                'show'     => '',
                'select'   => null,
            ];

            self::$plain_mode[$instance] = false;
        } else {
            self::$query['table']    = '';
            self::$query['join']     = '';
            self::$query['values']   = '';
            self::$query['set']      = '';
            self::$query['where']    = '';
            self::$query['order_by'] = '';
            self::$query['show']     = '';
            self::$query['select']   = null;
            self::$query['params']   = [];
        }
    }

    /**
     * Open a database connection, this is needed if you will execute queries from
     * the database.
     */
    public static function startConnection()
    {
        $config = Config::get('database');

        self::$connection = new \PDO("mysql:host={$config['host']};dbname={$config['name']};charset={$config['charset']};", $config['username'], $config['password']);

        self::setup();
    }

    /**
     * Begin a transaction, this would turn off the autocommit. You would require
     * to call commit() at the end of the query to save changes.
     */
    public static function beginTransaction()
    {
        self::$connection->beginTransaction();
    }

    /**
     * Turn the database into plain mode, which will not process any query.
     *
     * @param int $instance
     */
    public static function plain($instance)
    {
        self::$subquery[$instance] = [
            'table'    => '',
            'join'     => '',
            'where'    => '',
            'order_by' => '',
            'show'     => '',
            'select'   => null,
        ];

        self::$plain_mode[$instance] = true;
        return new static;
    }

    /**
     * Call the database table to be used.
     *
     * @param string $table
     * @param int $instance
     */
    public static function table($table, $instance = null)
    {
        if (!empty(self::$plain_mode[$instance])) {
            self::$subquery[$instance]['table'] = $table;
            return new static;
        }

        self::$query['table'] = $table;
        return new static;
    }

    /**
     * Create a LEFT JOIN query based on given parameters.
     *
     * @param array $join
     * @param int $instance
     */
    public static function leftJoin($join, $instance = null)
    {
        $join_query = '';

        foreach ($join as $key => $value) {
            $join_query .= " LEFT JOIN {$key} ON {$value[0]}";
        }

        if (!empty(self::$plain_mode[$instance])) {
            self::$subquery[$instance]['join'] = $join_query;
            return new static;
        }

        self::$query['join'] = $join_query;
        return new static;
    }

    /**
     * Create an INNER JOIN query based on given parameters.
     *
     * @param array $join
     * @param int $instance
     */
    public static function innerJoin($join, $instance = null)
    {
        $join_query = '';

        foreach ($join as $key => $value) {
            $join_query .= " INNER JOIN {$key} ON {$value[0]}";
        }

        if (!empty(self::$plain_mode[$instance])) {
            self::$subquery[$instance]['join'] = $join_query;
            return new static;
        }

        self::$query['join'] = $join_query;
        return new static;
    }

    /**
     * Create a VALUES query based on given parameters.
     *
     * @param array $where
     */
    public static function values($values)
    {
        $values = array_filter($values);

        $values_query = '';
        $values_query .= ' (';

        foreach ($values as $key => $value) {
            if ($key > 0) {
                $values_query .= ', ';
            }

            $values_query .= $value[0];
        }

        if (self::checkColumn('created_at') && self::checkColumn('created_by')) {
            $values_query .= ', created_at, created_by';
        }

        $values_query .= ') VALUES (';

        foreach ($values as $key => $value) {
            if ($key > 0) {
                $values_query .= ', ';
            }

            $values_query .= in_array($value[1], self::$reserved_words) ? " {$value[1]}" : ' ?' ;
        }

        if (self::checkColumn('created_at') && self::checkColumn('created_by')) {
            $values_query .= ', NOW(), ' . Authentication::getAuthenticatedUser();
        }

        $values_query .= ')';

        self::$query['values'] = $values_query;
        self::$query['params'] = array_merge(self::$query['params'], $values);
        return new static;
    }

    /**
     * Create a SET query based on given parameters.
     *
     * @param array $where
     */
    public static function set($set)
    {
        $set_query = '';
        $set_query .= ' SET';

        foreach ($set as $key => $value) {
            if ($key > 0) {
                $set_query .= ', ';
            }

            $set_query .= in_array($value[1], self::$reserved_words) ? " {$value[0]} = {$value[1]}" : " {$value[0]} = ?" ;
        }

        if (self::checkColumn('updated_at') && self::checkColumn('updated_by')) {
            $set_query .= ', updated_at = NOW(), updated_by = ' . Authentication::getAuthenticatedUser();
        }

        self::$query['set'] = $set_query;
        self::$query['params'] = array_merge(self::$query['params'], $set);
        return new static;
    }

    /**
     * Create a WHERE query based on given parameters.
     *
     * @param array $where
     * @param int $instance
     */
    public static function where($where, $instance = null)
    {
        $where_query = '';
        $where_query .= ' WHERE';

        foreach ($where as $key => $value) {
            if ($key > 0) {
                $where_query .= ' AND';
            }

            $where_query .= in_array($value[1], self::$reserved_words) ? " {$value[0]} {$value[1]}" : (" {$value[0]} {$value[1]} " . (!empty(self::$plain_mode[$instance]) ? $value[2] : '?')) ;
        }

        if (!empty(self::$plain_mode[$instance])) {
            self::$subquery[$instance]['where'] = $where_query;
            return new static;
        }

        self::$query['where'] = $where_query;
        self::$query['params'] = array_merge(self::$query['params'], $where);
        return new static;
    }

    /**
     * Order rows by ascending or descending.
     *
     * @param srting $column
     * @param string $order
     * @param int $instance
     */
    public static function orderBy($column, $order, $instance = null)
    {
        $order_by_query = " ORDER BY {$column} {$order}";

        if (!empty(self::$plain_mode[$instance])) {
            self::$subquery[$instance]['order_by'] = $order_by_query;
            return new static;
        }

        self::$query['order_by'] = $order_by_query;
        return new static;
    }

    /**
     * Limit on how many rows should be displayed when fetching data.
     *
     * @param int $show
     * @param int $instance
     */
    public static function show($show, $instance = null)
    {
        $show_query = " LIMIT {$show}";

        if (!empty(self::$plain_mode[$instance])) {
            self::$subquery[$instance]['show'] = $show_query;
            return new static;
        }

        self::$query['show'] = $show_query;
        return new static;
    }

    /**
     * select data from the database.
     *
     * @param array $columns
     * @param int $instance
     * @param string $alias
     */
    public static function select($columns = ['*'], $instance = null, $alias = null)
    {
        if (!empty(self::$plain_mode[$instance])) {
            $select = '(SELECT ' . implode(',', $columns) . ' FROM ' . self::$subquery[$instance]['table'] . self::$subquery[$instance]['join'] . self::$subquery[$instance]['where'] . self::$subquery[$instance]['order_by'] . self::$subquery[$instance]['show'] . ')' . (($alias) ? "AS {$alias}" : '');

            self::clean($instance);
            return $select;
        }

        self::$query['select'] = self::$connection->prepare('SELECT ' . implode(',', $columns) . ' FROM ' . self::$query['table'] . self::$query['join'] . self::$query['where'] . self::$query['order_by'] . self::$query['show']);

        $index = 1;

        foreach (self::$query['params'] as $key => $value) {
            if (!in_array($value[count($value) - 1], self::$reserved_words)) {
                self::$query['select']->bindValue($index++, $value[count($value) - 1]);
            }
        }

        self::$query['select']->execute();
        return new static;
    }

    /**
     * Concat strings.
     *
     * @param array $strings
     * @param string $alias
     *
     * @return string
     */
    public static function concat($strings, $alias = null)
    {
        return 'CONCAT(' . 'IFNULL(' . implode(', \'\'), IFNULL(', $strings) . ', \'\'))' . (($alias) ? " AS {$alias}" : '');
    }

    /**
     * Concat strings from a group.
     *
     * @param array $strings
     * @param string $separator
     * @param string $alias
     *
     * @return string
     */
    public static function groupConcat($strings, $separator, $alias = null)
    {
        return 'GROUP_CONCAT(' . 'CONCAT(' . 'IFNULL(' . implode(', \'' . Placeholder::get('long') . '\'), IFNULL(', $strings) . ', \'\'))' . " SEPARATOR {$separator})" . (($alias) ? " AS {$alias}" : '');
    }

    /**
     * Evaluate a string using conditional expressions.
     *
     * @param string $expression
     * @param string $true
     * @param string $false
     * @param string $alias
     *
     * @return string
     */
    public static function condition($expression, $true, $false, $alias = null)
    {
        return "if({$expression}, {$true}, {$false})" . (($alias) ? " AS {$alias}" : '');
    }

    /**
     * Format a date.
     *
     * @param string $date
     * @param string $format
     * @param string $alias
     *
     * @return string
     */
    public static function dateFormat($date, $format, $alias = null)
    {
        return "DATE_FORMAT({$date}, {$format})" . (($alias) ? " AS {$alias}" : '');
    }

    /**
     * fetch data from the database.
     *
     * @return array
     */
    public static function fetch()
    {
        $result = self::$query['select']->fetch();
        self::clean();
        return $result;
    }

    /**
     * fetch data as associative array from the database.
     *
     * @return array
     */
    public static function fetchAll()
    {
        $result = self::$query['select']->fetchAll(\PDO::FETCH_ASSOC);
        self::clean();
        return $result;
    }

    /**
     * Insert a data from the database.
     *
     * @return bool
     */
    public static function insert()
    {
        $statement = self::$connection->prepare('INSERT INTO ' . self::$query['table'] . self::$query['values']);

        $index = 1;

        foreach (self::$query['params'] as $key => $value) {
            if (!in_array($value[count($value) - 1], self::$reserved_words)) {
                $statement->bindValue($index++, $value[count($value) - 1]);
            }
        }

        self::clean();
        return $statement->execute();
    }

    /**
     * Get the user who created the data.
     *
     * @param string $created_at
     * @param string $created_by
     * @param string $alias
     *
     * @return string
     */
    public static function getCreator($created_at, $created_by, $alias)
    {
        return Database::plain(0)
            ->table('umg_users', 0)
            ->where([
                ['umg_users.id', '=', $created_by],
                ['umg_users.deleted_at', 'IS NULL'],
                ['umg_users.deleted_by', 'IS NULL'],
            ], 0)
            ->select([
                Database::concat([
                    "'<span class=\''",
                    Database::condition('umg_users.disabled_at IS NULL AND umg_users.disabled_by IS NULL', '\'\'', '\' text-disabled\''),
                    "'\'>'",
                    'umg_users.first_name',
                    "' '",
                    'umg_users.last_name',
                    "'</span>'",
                    "'<div>('",
                    Database::dateFormat($created_at, '\'%M %d, %Y %l:%i:%s %p\''),
                    "')</div>'",
                    Database::plain(1)
                        ->table('umg_users_departments', 1)
                        ->leftJoin([
                            'umg_departments' => [
                                'umg_users_departments.department_id = umg_departments.id'
                            ],
                        ], 1)
                        ->where([
                            ['umg_users_departments.user_id', '=', $created_by],
                            ['umg_departments.deleted_at', 'IS NULL'],
                            ['umg_departments.deleted_by', 'IS NULL'],
                        ], 1)
                        ->select([
                            Database::groupConcat([
                                "'<div class=\''",
                                Database::condition('umg_departments.disabled_at IS NULL AND umg_departments.disabled_by IS NULL', '\'\'', '\' text-disabled\''),
                                "'\'>('",
                                'umg_departments.name',
                                "')</div>'",
                            ], "' '"),
                        ], 1),
                ]),
            ], 0, $alias);
    }

    /**
     * Get the ID of last inserted data.
     *
     * @return int
     */
    public static function lastInsertId()
    {
        return self::$connection->lastInsertId();
    }

    /**
     * Update a data from the database.
     *
     * @return bool
     */
    public static function update()
    {
        $statement = self::$connection->prepare('UPDATE ' . self::$query['table'] . self::$query['set'] . self::$query['where']);

        $index = 1;

        foreach (self::$query['params'] as $key => $value) {
            if (!in_array($value[count($value) - 1], self::$reserved_words)) {
                $statement->bindValue($index++, $value[count($value) - 1]);
            }
        }

        self::clean();
        return $statement->execute();
    }

    /**
     * Get the user who updated the data.
     *
     * @param string $updated_at
     * @param string $updated_by
     * @param string $alias
     *
     * @return string
     */
    public static function getUpdater($updated_at, $updated_by, $alias)
    {
        return Database::plain(0)
            ->table('umg_users', 0)
            ->where([
                ['umg_users.id', '=', $updated_by],
                ['umg_users.deleted_at', 'IS NULL'],
                ['umg_users.deleted_by', 'IS NULL'],
            ], 0)
            ->select([
                Database::concat([
                    "'<span class=\''",
                    Database::condition('umg_users.disabled_at IS NULL AND umg_users.disabled_by IS NULL', '\'\'', '\' text-disabled\''),
                    "'\'>'",
                    'umg_users.first_name',
                    "' '",
                    'umg_users.last_name',
                    "'</span>'",
                    "'<div>('",
                    Database::dateFormat($updated_at, '\'%M %d, %Y %l:%i:%s %p\''),
                    "')</div>'",
                    Database::plain(1)
                        ->table('umg_users_departments', 1)
                        ->leftJoin([
                            'umg_departments' => [
                                'umg_users_departments.department_id = umg_departments.id'
                            ],
                        ], 1)
                        ->where([
                            ['umg_users_departments.user_id', '=', $updated_by],
                            ['umg_departments.deleted_at', 'IS NULL'],
                            ['umg_departments.deleted_by', 'IS NULL'],
                        ], 1)
                        ->select([
                            Database::groupConcat([
                                "'<div class=\''",
                                Database::condition('umg_departments.disabled_at IS NULL AND umg_departments.disabled_by IS NULL', '\'\'', '\' text-disabled\''),
                                "'\'>('",
                                'umg_departments.name',
                                "')</div>'",
                            ], "' '"),
                        ], 1),
                ]),
            ], 0, $alias);
    }

    /**
     * Disable a data from the database, this is a temporary disable which
     * can be reverse using the Database::enable() method.
     *
     * @return bool
     */
    public static function disable()
    {
        $statement = self::$connection->prepare('UPDATE ' . self::$query['table'] . ' SET disabled_at = NOW(), disabled_by = ' . Authentication::getAuthenticatedUser() . self::$query['where']);

        $index = 1;

        foreach (self::$query['params'] as $key => $value) {
            if (!in_array($value[count($value) - 1], self::$reserved_words)) {
                $statement->bindValue($index++, $value[count($value) - 1]);
            }
        }

        self::clean();
        return $statement->execute();
    }

    /**
     * Get the user who disabled the data.
     *
     * @param string $disabled_at
     * @param string $disabled_by
     * @param string $alias
     *
     * @return string
     */
    public static function getDisabler($disabled_at, $disabled_by, $alias)
    {
        return Database::plain(0)
            ->table('umg_users', 0)
            ->where([
                ['umg_users.id', '=', $disabled_by],
                ['umg_users.deleted_at', 'IS NULL'],
                ['umg_users.deleted_by', 'IS NULL'],
            ], 0)
            ->select([
                Database::concat([
                    "'<span class=\''",
                    Database::condition('umg_users.disabled_at IS NULL AND umg_users.disabled_by IS NULL', '\'\'', '\' text-disabled\''),
                    "'\'>'",
                    'umg_users.first_name',
                    "' '",
                    'umg_users.last_name',
                    "'</span>'",
                    "'<div>('",
                    Database::dateFormat($disabled_at, '\'%M %d, %Y %l:%i:%s %p\''),
                    "')</div>'",
                    Database::plain(1)
                        ->table('umg_users_departments', 1)
                        ->leftJoin([
                            'umg_departments' => [
                                'umg_users_departments.department_id = umg_departments.id'
                            ],
                        ], 1)
                        ->where([
                            ['umg_users_departments.user_id', '=', $disabled_by],
                            ['umg_departments.deleted_at', 'IS NULL'],
                            ['umg_departments.deleted_by', 'IS NULL'],
                        ], 1)
                        ->select([
                            Database::groupConcat([
                                "'<div class=\''",
                                Database::condition('umg_departments.disabled_at IS NULL AND umg_departments.disabled_by IS NULL', '\'\'', '\' text-disabled\''),
                                "'\'>('",
                                'umg_departments.name',
                                "')</div>'",
                            ], "' '"),
                        ], 1),
                ]),
            ], 0, $alias);
    }

    /**
     * Enable a data from the database.
     *
     * @return bool
     */
    public static function enable()
    {
        $statement = self::$connection->prepare('UPDATE ' . self::$query['table'] . ' SET disabled_at = NULL, disabled_by = NULL' . self::$query['where']);

        $index = 1;

        foreach (self::$query['params'] as $key => $value) {
            if (!in_array($value[count($value) - 1], self::$reserved_words)) {
                $statement->bindValue($index++, $value[count($value) - 1]);
            }
        }

        self::clean();
        return $statement->execute();
    }

    /**
     * Delete a data from the database, this is a temporary deletion which
     * can be reverse using the Database::restore() method.
     *
     * @return bool
     */
    public static function delete()
    {
        $statement = self::$connection->prepare('UPDATE ' . self::$query['table'] . ' SET deleted_at = NOW(), deleted_by = ' . Authentication::getAuthenticatedUser() . self::$query['where']);

        $index = 1;

        foreach (self::$query['params'] as $key => $value) {
            if (!in_array($value[count($value) - 1], self::$reserved_words)) {
                $statement->bindValue($index++, $value[count($value) - 1]);
            }
        }

        self::clean();
        return $statement->execute();
    }

    /**
     * Get the user who deleted the data.
     *
     * @param string $deleted_at
     * @param string $deleted_by
     * @param string $alias
     *
     * @return string
     */
    public static function getDeleter($deleted_at, $deleted_by, $alias)
    {
        return Database::plain(0)
            ->table('umg_users', 0)
            ->where([
                ['umg_users.id', '=', $deleted_by],
                ['umg_users.deleted_at', 'IS NULL'],
                ['umg_users.deleted_by', 'IS NULL'],
            ], 0)
            ->select([
                Database::concat([
                    "'<span class=\''",
                    Database::condition('umg_users.disabled_at IS NULL AND umg_users.disabled_by IS NULL', '\'\'', '\' text-disabled\''),
                    "'\'>'",
                    'umg_users.first_name',
                    "' '",
                    'umg_users.last_name',
                    "'</span>'",
                    "'<div>('",
                    Database::dateFormat($deleted_at, '\'%M %d, %Y %l:%i:%s %p\''),
                    "')</div>'",
                    Database::plain(1)
                        ->table('umg_users_departments', 1)
                        ->leftJoin([
                            'umg_departments' => [
                                'umg_users_departments.department_id = umg_departments.id'
                            ],
                        ], 1)
                        ->where([
                            ['umg_users_departments.user_id', '=', $deleted_by],
                            ['umg_departments.deleted_at', 'IS NULL'],
                            ['umg_departments.deleted_by', 'IS NULL'],
                        ], 1)
                        ->select([
                            Database::groupConcat([
                                "'<div class=\''",
                                Database::condition('umg_departments.disabled_at IS NULL AND umg_departments.disabled_by IS NULL', '\'\'', '\' text-disabled\''),
                                "'\'>('",
                                'umg_departments.name',
                                "')</div>'",
                            ], "' '"),
                        ], 1),
                ]),
            ], 0, 'deleted_by');
    }

    /**
     * Purge a data from the database, this is a permanent deletion which cannot
     * be reverse once it has been deleted.
     *
     * @return bool
     */
    public static function purge()
    {
        $statement = self::$connection->prepare('DELETE FROM ' . self::$query['table'] . self::$query['where']);

        $index = 1;

        foreach (self::$query['params'] as $key => $value) {
            if (!in_array($value[count($value) - 1], self::$reserved_words)) {
                $statement->bindValue($index++, $value[count($value) - 1]);
            }
        }

        self::clean();
        return $statement->execute();
    }

    /**
     * Restore a deleted data from the database.
     *
     * @return bool
     */
    public static function restore()
    {
        $statement = self::$connection->prepare('UPDATE ' . self::$query['table'] . ' SET deleted_at = NULL, deleted_by = NULL' . self::$query['where']);

        $index = 1;

        foreach (self::$query['params'] as $key => $value) {
            if (!in_array($value[count($value) - 1], self::$reserved_words)) {
                $statement->bindValue($index++, $value[count($value) - 1]);
            }
        }

        self::clean();
        return $statement->execute();
    }

    /**
     * Commit any changes done to the database, this will save the newly change
     * data from the database. This can be reverse by using the Database::rollBack()
     * method.
     *
     * @return bool
     */
    public static function commit()
    {
        return self::$connection->commit();
    }

    /**
     * Rollback any changes done to the database, this would require the
     * Database::beginTransaction() method to be called first.
     *
     * @return bool
     */
    public static function rollBack()
    {
        return self::$connection->rollBack();
    }

    /**
     * Close the current database connection. By nature, the connection is automatically
     * closed when the script ends. This is only necessary if you need to close
     * the connection between execution of scripts.
     */
    public static function endConnection()
    {
        self::$connection = null;
    }
}
