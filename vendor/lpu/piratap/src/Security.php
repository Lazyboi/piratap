<?php
namespace LPU;

class Security
{
    /**
     * Verify the password from the encrypted password
     *
     * @param string $password
     * @param string $encrypted_password
     *
     * @return bool
     */
    public static function verifyPassword($password, $encrypted_password)
    {
        return password_verify($password, $encrypted_password);
    }

    /**
     * Record the user activity.
     *
     * @param string $details
     */
    public static function recordUserActivty($details)
    {
        Database::table('umg_users_activities')
            ->values([
                ['details', $details],
            ])
            ->insert();
    }

    /**
     * Generate an unique id
     *
     * @return string
     */
    public static function generateUniqueId()
    {
        return md5(uniqid());
    }

    /**
     * Encrypt the password by hashing
     *
     * @param string $password
     *
     * @return string
     */
    public static function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Get the user activity.
     *
     * @param int $user_id
     *
     * @param array
     */
    public static function getUserActivty($user_id)
    {
        return Database::table('umg_users_activities a')
            ->innerJoin([
                'umg_users b' => [
                    'a.created_by = b.id'
                ],
            ])
            ->where([
              ['a.created_by', '=', $user_id],
              ['b.deleted_at', 'IS NULL'],
              ['b.deleted_by', 'IS NULL'],
            ])
            ->select([
              'a.details',
              Database::dateFormat('a.created_at', '\'%M %d, %Y %h:%i %s %p\'', 'created_at'),
              Database::concat([
                'b.first_name',
                "' '",
                'b.last_name',
              ], 'name'),
            ])
            ->fetchAll();
    }
}
