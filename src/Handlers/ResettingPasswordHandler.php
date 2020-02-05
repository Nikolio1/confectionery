<?php

namespace App\Handlers;

use App\Entity\User;


/**
 * Class ResettingPasswordHandler
 *
 * @package App\Handlers
 */
class ResettingPasswordHandler
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var BaseHandler
     */
    protected $handler;

    /**
     * ResettingPasswordHandler constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param BaseHandler $handler
     */
    public function __construct(\Swift_Mailer $mailer, BaseHandler $handler)
    {
        $this->mailer = $mailer;
        $this->handler = $handler;
    }

    /**
     * @param User $user
     * @param $twig
     *
     * @return int
     */
    public function sendMail(User $user, $twig)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setContentType('text/html')
            ->setBody($twig)
        ;

       return $this->mailer->send($message);
    }

    /**
     * @param User $user
     *
     * @return mixed
     * @throws \Exception
     */
    public function tokenRecordToUser(User $user){
        $token = $this->generateToken();

        $user->setResetToken($token);
        $user->setResetTokenExpiresAt(new \DateTime('+1days'));

        return $this->handler->saveObject($user);

    }

    /**
     * @param $date
     *
     * @return bool
     * @throws \Exception
     */
    public function tokenDateCheck($date)
    {
        if ($date > (new \DateTime())) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function deleteToken(User $user)
    {
        $user->setResetToken(null);
        $user->setResetTokenExpiresAt(null);
        $this->handler->saveObject($user);

        return $user;
    }

    /**
     * @throws \Exception
     */
    public function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(64)), '+/', '-_'), '=');
    }
}
