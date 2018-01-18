<?php
namespace App;

use LPU\Database;
use LPU\DateTime;
use LPU\Form;
use LPU\Mail;
use LPU\Route;
use LPU\Security;
use LPU\Session;

class Authentication
{
    /**
     * Sign in to the application.
     */
    public static function signIn()
    {
        if (!Form::validate(['username', 'password', 'sign_in'])) {
            Form::setState('Log in to your account', 'If you are a member of the university, you can sign in using your username and password provided below.', Form::MESSAGE_DEFAULT);
            return;
        }

        if ($data = Database::table('umg_users')
            ->where([
                ['username', '=', Form::getFieldData('username')],
            ])
            ->select([
                'id',
                'password',
                'disabled_at',
                'disabled_by',
                'deleted_at',
                'deleted_by',
            ])
            ->fetch()) {
            if (Security::verifyPassword(Form::getFieldData('password'), $data['password'])) {
                if (!$data['disabled_at'] && !$data['disabled_by']) {
                    if (!$data['deleted_at'] && !$data['deleted_by']) {
                        Session::create('authenticated_user', $data['id']);

                        Security::recordUserActivty('Attempted to log in at <i>' . DateTime::get('F d, Y H:i:s A') . '</i> and was successful.');

                        Route::go('dashboard');
                    } else {
                        Form::setState('Unable to sign in. Please try again later', 'Sorry, but we\'re having trouble signing you in. It seems that your account was deleted.', Form::MESSAGE_ERROR);
                    }
                } else {
                    Form::setState('Unable to sign in. Please try again later', 'Sorry, but we\'re having trouble signing you in. It seems that your account was disabled.', Form::MESSAGE_ERROR);
                }
            } else {
                Form::setState('Unable to sign in. Please try again later', 'Sorry, but we\'re having trouble signing you in. It seems that there is a problem in your password.', Form::MESSAGE_ERROR);
                Form::setFieldState('password', 'Password is incorrect.', Form::VALIDATION_ERROR);
            }
        } else {
            Form::setState('Unable to sign in. Please try again later', 'Sorry, but we\'re having trouble signing you in. It seems that there is a problem in your username.', Form::MESSAGE_ERROR);
            Form::setFieldState('username', 'Username does not exist.', Form::VALIDATION_ERROR);
        }
    }

    /**
     * Send a reset password link.
     */
    public static function sendResetPasswordLink()
    {
        if (!Form::validate(['email_address', 'submit'])) {
            Form::setState('Retrieve your password', 'To retrieve your password, enter your email address that is associated with your account. If you have a multiple email addresses, the primary email address will be used.', Form::MESSAGE_DEFAULT);
            return;
        }

        if ($data = Database::table('umg_users_email_addresses a')
            ->innerJoin([
                'umg_users b' => [
                    'a.user_id = b.id'
                ],
            ])
            ->where([
                ['a.email_address', '=', Form::getFieldData('email_address')],
                ['a.is_primary', '=', 1],
            ])
            ->select([
                'b.id',
                'b.disabled_at',
                'b.disabled_by',
                'b.deleted_at',
                'b.deleted_by',
            ])
            ->fetch()) {
            if (!$data['disabled_at'] && !$data['disabled_by']) {
                if (!$data['deleted_at'] && !$data['deleted_by']) {
                    $token = Security::generateUniqueId();

                    if (!Database::table('umg_users_reset_tokens')
                        ->values([
                            ['user_id', $data['id']],
                            ['token', $token],
                        ])
                        ->insert()) {
                        Form::setState('Unable to retrieve password. Please try again later', 'Sorry, but we\'re having trouble retrieving your password. It seems that your account was deleted.', Form::MESSAGE_ERROR);
                        return;
                    }

                    Mail::setup();
                    Mail::send(Form::getFieldData('email_address'), 'Password Retrieval', 'test');

                    Form::setState('Password has been successfully retrieved', 'We have sent you an instruction on your email on how to retrieve your passsword.', Form::MESSAGE_SUCCESS, true);

                    Route::reload();
                } else {
                    Form::setState('Unable to retrieve password. Please try again later', 'Sorry, but we\'re having trouble retrieving your password. It seems that your account was deleted.', Form::MESSAGE_ERROR);
                }
            } else {
                Form::setState('Unable to retrieve password. Please try again later', 'Sorry, but we\'re having trouble retrieving your password. It seems that your account was disabled.', Form::MESSAGE_ERROR);
            }
        } else {
            Form::setState('Unable to retrieve password. Please try again later', 'Sorry, but we\'re having trouble retrieving your password. It seems that your email address is not associated with any account.', Form::MESSAGE_ERROR);
            Form::setFieldState('email_address', 'Email address does not exist.', Form::VALIDATION_ERROR);
        }
    }

    /**
     * Change the password.
     */
    public static function changePassword()
    {
        if (!Form::validate(['new_password', 'confirm_new_password', 'change_password'])) {
            Form::setState('Change your password', 'To change your password, enter your new password twice. The password should be at least minimum of 8 characters.', Form::MESSAGE_DEFAULT, true);
            return;
        }

        if ($data = Database::table('umg_users_email_addresses a')
            ->innerJoin([
                'umg_users b' => [
                    'a.user_id = b.id'
                ],
            ])
            ->where([
                ['a.email_address', '=', Form::getFieldData('email_address')],
                ['a.is_primary', '=', 1],
            ])
            ->select([
                'b.id',
                'b.disabled_at',
                'b.disabled_by',
                'b.deleted_at',
                'b.deleted_by',
            ])
            ->fetch()) {
            if (!$data['disabled_at'] && !$data['disabled_by']) {
                if (!$data['deleted_at'] && !$data['deleted_by']) {
                    Mail::setup();
                    Mail::send(Form::getFieldData('email_address'), 'Password Retrieval', 'test');

                    Form::setState('Password has been successfully retrieved', 'We have sent you an instruction on your email on how to retrieve your passsword.', Form::MESSAGE_SUCCESS, true);

                    Route::reload();
                } else {
                    Form::setState('Unable to retrieve password. Please try again later', 'Sorry, but we\'re having trouble retrieving your password. It seems that your account was deleted.', Form::MESSAGE_ERROR, true);
                }
            } else {
                Form::setState('Unable to retrieve password. Please try again later', 'Sorry, but we\'re having trouble retrieving your password. It seems that your account was disabled.', Form::MESSAGE_ERROR, true);
            }
        } else {
            Form::setState('Unable to retrieve password. Please try again later', 'Sorry, but we\'re having trouble retrieving your password. It seems that your email address is not associated with any account.', Form::MESSAGE_ERROR, true);
            Form::setFieldState('email_address', 'Email address does not exist.', Form::VALIDATION_ERROR);
        }
    }

    /**
     * Sign out from the application.
     */
    public static function signOut()
    {
        Security::recordUserActivty('Attempted to log out at <i>' . DateTime::get('F d, Y H:i:s A') . '</i> and was successful.');

        Session::destroy();

        Route::go('login');
    }
}
