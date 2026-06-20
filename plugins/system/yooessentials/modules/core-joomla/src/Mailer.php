<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Joomla;

use Joomla\CMS\Factory;
use Joomla\CMS\Mail\Mail;
use Joomla\CMS\Mail\MailHelper;
use YOOtheme\Config as Yooconfig;
use YOOtheme\File;
use YOOtheme\Path;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Mailer as MailerInterface;

class Mailer implements MailerInterface
{
    /**
     * @var Mail
     */
    public $mailer;

    /**
     * @var Yooconfig
     */
    public $yooconfig;

    /**
     * Constructor.
     */
    public function __construct(Yooconfig $yooconfig)
    {
        $this->mailer = Factory::getMailer();
        $this->yooconfig = $yooconfig;
    }

    public function setFrom(string $email, string $name = ''): MailerInterface
    {
        if (empty($email)) {
            $email = $this->yooconfig->get('joomla.config.mailfrom');
        }

        if (empty($name)) {
            $name = $this->yooconfig->get('joomla.config.fromname');
        }

        if (MailHelper::isEmailAddress($email)) {
            $this->mailer->setFrom($email, $name, false);
        }

        return $this;
    }

    public function addRecipient(string $email, string $name = ''): MailerInterface
    {
        if (MailHelper::isEmailAddress($email)) {
            $this->mailer->addRecipient($email, $name);
        }

        return $this;
    }

    public function addCc(string $email, string $name = ''): MailerInterface
    {
        if (MailHelper::isEmailAddress($email)) {
            $this->mailer->addCc($email, $name);
        }

        return $this;
    }

    public function addBcc(string $email, string $name = ''): MailerInterface
    {
        if (MailHelper::isEmailAddress($email)) {
            $this->mailer->addBcc($email, $name);
        }

        return $this;
    }

    public function addReplyTo(string $email, string $name = ''): MailerInterface
    {
        if (MailHelper::isEmailAddress($email)) {
            $this->mailer->addReplyTo($email, $name);
        }

        return $this;
    }

    public function setSubject(string $subject): MailerInterface
    {
        $this->mailer->setSubject($subject);

        return $this;
    }

    public function setBody(string $content): MailerInterface
    {
        $this->mailer->setBody($content);

        return $this;
    }

    public function setAltBody(string $content): MailerInterface
    {
        $this->mailer->AltBody = $content;

        return $this;
    }

    public function isHtml(bool $isHtml): MailerInterface
    {
        $this->mailer->isHtml($isHtml);

        return $this;
    }

    public function addAttachment(string $filePath): MailerInterface
    {
        if (!Str::startsWith($filePath, '~') && !Path::isAbsolute($filePath)) {
            $filePath = "~/$filePath";
        }

        if (File::exists($filePath)) {
            $this->mailer->addAttachment(Path::resolve($filePath));
        }

        return $this;
    }

    public function send(): bool
    {
        $result = $this->mailer->send();

        if ($result instanceof \Exception) {
            throw $result;
        }

        if (!$result) {
            throw new \Exception($this->mailer->ErrorInfo ?: 'There was an error sending the email.');
        }

        return $result;
    }
}
