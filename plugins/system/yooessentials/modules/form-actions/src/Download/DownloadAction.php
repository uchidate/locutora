<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\Download;

use function YOOtheme\app;
use YOOtheme\Encrypter;
use YOOtheme\File;
use YOOtheme\Str;
use YOOtheme\Url;
use ZOOlanders\YOOessentials\Form\Actions\StandardAction;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;

class DownloadAction extends StandardAction
{
    public const NAME = 'download';

    public function __invoke(FormSubmissionResponse $response, callable $next): FormSubmissionResponse
    {
        $file = $this->config('file', '');
        $file = $response->submission()->parseTags($file);

        if ($file && !Str::startsWith($file, '~') && !Str::startsWith($file, '/')) {
            $file = File::get("~/$file");
        }

        if (!$file) {
            $actionName = (new \ReflectionClass(self::class))->getShortName();

            throw new \RuntimeException("$actionName Error: File Not Found.");
        }

        /** @var Encrypter $encrypter */
        $encrypter = app(Encrypter::class);

        $file = $encrypter->encrypt($file);

        return $next($response->withData([
            'download' => Url::route(DownloadActionController::DOWNLOAD_URL, compact('file'))
        ]));
    }
}
