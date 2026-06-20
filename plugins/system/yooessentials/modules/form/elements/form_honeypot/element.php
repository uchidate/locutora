<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

use function YOOtheme\App;
use YOOtheme\Encrypter;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionRequest;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;
use ZOOlanders\YOOessentials\Util\Prop;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Validator;

return [

    'transforms' => [

        'render' => function ($node) {

            /** @var FormSubmissionRequest $submission */
            $submission = app(FormSubmissionRequest::class);

            $controlName = $node->controls->honeypot['name'];
            $controlProps = $node->controls->honeypot['props'];

            $node->control = (object) [
                'name' => $controlName,
                'id' => $controlProps['id'] ?? null,
                'errors' => $submission->validator()->errors($controlName) ?? [],
                'props' => $controlProps,
                'time' => $node->controls->honeypot['time']
            ];
        }

    ],

    'controls' => [

        'honeypot' => function ($node) {
            /** @var Encrypter $encrypt */
            $crypt = app(Encrypter::class);

            $name = 'h' . rand() . 'p';
            $props = Prop::filterByPrefix($node->props, 'control_');
            $time = base64_encode($crypt->encrypt((new \DateTime())->format('U')));

            return compact('name', 'props', 'time');
        }

    ],

    'validation' => function ($control, Validator $validator, FormSubmissionRequest $submission) {
        $validator->setName('honeypot');

        $validator
            ->callback(function ($value) use ($control, $submission) {
                if ($value) {
                    return false;
                }

                $encryptedTime = $submission->data($control['name'] . '_time');

                /** @var Encrypter $encrypter */
                $crypt = app(Encrypter::class);
                $time = $crypt->decrypt(base64_decode($encryptedTime));

                $time = \DateTime::createFromFormat('U', $time);
                if (!$time) {
                    return false;
                }

                $now = new \DateTime();
                if ($time >= $now) {
                    return false;
                }

                $seconds = ($now->getTimestamp() - $time->getTimestamp());
                $minSeconds = $control['props']['min_seconds'] ?? 1;
                if ($seconds < $minSeconds) {
                    return false;
                }

                return true;
            });

        return $validator;
    },

    'submission' => function ($control, FormSubmissionRequest $submission, FormSubmissionResponse $response) {
        $controlName = $control['name'];

        // Remove from data, it's not used
        $data = $submission->data();
        unset($data[$controlName]);
        unset($data[$controlName . '_time']);
        $submission->setData($data);
    }

];
