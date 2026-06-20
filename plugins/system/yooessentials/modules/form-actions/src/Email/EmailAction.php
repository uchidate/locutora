<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\Email;

use function YOOtheme\app;
use YOOtheme\Arr;
use ZOOlanders\YOOessentials\Form\Actions\StandardAction;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;
use ZOOlanders\YOOessentials\Mailer;
use ZOOlanders\YOOessentials\Util;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\ValidationException;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Validator;

class EmailAction extends StandardAction
{
    public const NAME = 'email';

    public function __invoke(FormSubmissionResponse $response, callable $next): FormSubmissionResponse
    {
        $actionName = (new \ReflectionClass(self::class))->getShortName();
        $config = (object) self::prepareConfig($this->getConfig(), $response);

        self::validateConfig($config);

        try {
            self::send($config);
        } catch (ValidationException $e) {
            throw new \RuntimeException($e->getMessage());
        }

        return $next($response->withDataLog([
            self::NAME => $config
        ]));
    }

    private static function prepareConfig(array $config, FormSubmissionResponse $response): array
    {
        // sanitize
        $config['from'] = trim($config['from'] ?? '');
        $config['from_name'] = trim($config['from_name'] ?? '');
        $config['body'] = trim($config['body'] ?? '');
        $config['html'] = $config['html'] ?? true;
        $config['subject'] = trim($config['subject'] ?? '');

        $config['ccs'] = Util\Arr::trim(explode(',', $config['ccs'] ?? ''));
        $config['bccs'] = Util\Arr::trim(explode(',', $config['bccs'] ?? ''));
        $config['reply_tos'] = Util\Arr::trim(explode(',', $config['reply_tos'] ?? ''));
        $config['recipients'] = Util\Arr::trim(explode(',', $config['recipients'] ?? ''));

        $config['attachments'] = Util\Arr::trim($config['attachments'] ?? []);
        $config['submitted_attachments'] = Util\Arr::trim($config['submitted_attachments'] ?? []);

        // merge attachments
        foreach ($config['submitted_attachments'] ?? [] as $field) {
            $attachments = Arr::wrap($response->submission()->data($field) ?: []);
            $config['attachments'] = array_merge($config['attachments'], $attachments);
        }

        unset($config['submitted_attachments']);

        return $config;
    }

    private static function send(object $config): void
    {
        /** @var Mailer $mailer */
        $mailer = app(Mailer::class);

        foreach ($config->recipients as $recipient) {
            $mailer->addRecipient($recipient);
        }

        foreach ($config->ccs as $cc) {
            $mailer->addCc($cc);
        }

        foreach ($config->bccs as $bcc) {
            $mailer->addBcc($bcc);
        }

        foreach ($config->reply_tos as $replyTo) {
            $mailer->addReplyTo($replyTo);
        }

        foreach ($config->attachments as $attachment) {
            $mailer->addAttachment($attachment);
        }

        if ($config->from || $config->from_name) {
            $mailer->setFrom($config->from, $config->from_name);
        }

        if ($config->subject) {
            $mailer->setSubject($config->subject);
        }

        if ($config->body) {
            $plainBody = strip_tags(str_ireplace(['<p>', '<br>', '<br/>', '<br />'], "\n", $config->body));

            if ($config->html) {
                $mailer->isHTML(true);
                $mailer->setBody($config->body);
                $mailer->setAltBody($plainBody);
            } else {
                $mailer->isHtml(false);
                $mailer->setBody($plainBody);
            }
        }

        $mailer->send();
    }

    private static function validateConfig(object $config): void
    {
        if (count($config->recipients) <= 0) {
            throw new \RuntimeException('Recipient is empty.');
        }

        $validator = new Validator();

        $validator->email();
        $validator->noWhitespace();
        $validator->notOptional();

        foreach ($config->recipients as $recipient) {
            $validator->check($recipient);
        }
    }
}
