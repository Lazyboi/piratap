<?php
namespace LPU;

class Mail
{
    private static $mail;

    /**
     * Set up the mail configuration.
     */
    public static function setup()
    {
        self::$mail = new \PHPMailer(true);
        self::$mail->isSMTP();
        self::$mail->Host = Config::get('mail')['host'];
        self::$mail->SMTPAuth = Config::get('mail')['authentication'];
        self::$mail->Username = Config::get('mail')['username'];
        self::$mail->Password = Config::get('mail')['password'];
        self::$mail->SMTPSecure = Config::get('mail')['encryption'];
        self::$mail->Port = Config::get('mail')['port'];
        self::$mail->setFrom(Config::get('mail')['username'], Config::get('mail')['name']);
        self::$mail->isHTML(true);
    }

    /**
     * Send an email to a recipient.
     *
     * @param string $recipient
     * @param string $subject
     * @param string $body
     */
    public static function send($recipient, $subject, $body)
    {
        self::$mail->addAddress($recipient);
        self::$mail->Subject = $subject;
        self::$mail->Body = $body;
        self::$mail->send();
    }

    /**
     * Send an email to multiple recipients.
     *
     * @param array $recipients
     * @param string $subject
     * @param string $body
     */
    public static function multipleSend($recipients, $subject, $body)
    {
        foreach ($recipients as $recipient) {
            self::$mail->addAddress($recipient);
            self::$mail->Subject = $subject;
            self::$mail->Body = $body;
            self::$mail->send();
        }
    }
}
