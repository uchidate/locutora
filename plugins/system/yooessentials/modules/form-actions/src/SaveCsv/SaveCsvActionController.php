<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\SaveCsv;

use YOOtheme\Config;
use YOOtheme\File;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use YOOtheme\Path;
use YOOtheme\Str;
use YOOtheme\Url;
use ZipArchive;
use ZOOlanders\YOOessentials\Form\FormService;

class SaveCsvActionController
{
    use InteractsWithCsv;

    public const DOWNLOAD_CSV_URL = '/yooessentials/form-download-csv';
    public const GET_COLUMNS_ENDPOINT = 'yooessentials/form-action/savecsv/columns';

    public function getColumns(Request $request, Response $response)
    {
        $form = $request->getParam('form') ?? [];

        try {
            $columns = [];
            $header = self::readCsvHeader((object) $form);

            foreach ($header as $i => $col) {
                $columns[] = [
                    'id' => $col,
                    'title' => Str::titleCase($col)
                ];
            }
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }

        return $response->withJson($columns);
    }

    public function download(Request $request, Response $response, FormService $formService, Config $appConfig)
    {
        $formId = $request->getParam('formid');
        $form = $formService->loadForm($formId);
        $actionId = $request->getParam('action');

        if (!$form->hasAction(SaveCsvAction::NAME)) {
            throw new \RuntimeException('This form does not have an associated Save CSV action');
        }

        $action = $form->actionConfigs(SaveCsvAction::NAME)[$actionId] ?? null;
        if (!$action) {
            throw new \RuntimeException('Cannot find an action with the give Id.');
        }

        $config = (object) $action->config();
        if (!Str::startsWith($config->path, '~')) {
            $config->path = "~/$config->path";
        }

        $filename = trim(basename($config->file ?: $form->id(), '.csv'), ' /');
        $path = Path::resolve($config->path) . '/';
        $files = File::glob($path . $filename . '-*.csv');

        if (count($files) <= 0) {
            throw new \RuntimeException('No files to download');
        }

        if (count($files) <= 1) {
            return $response->withRedirect(Url::to(array_shift($files)));
        }

        $zipFileName = $config->file ? str_replace('.' . File::getExtension($config->file), '', $config->file) : $form->id();
        $zipPath = $appConfig->get('app.tempDir') . '/' . $zipFileName . '.zip';

        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }

        $zip->close();

        return $response->withRedirect(Url::to($zipPath), 303);
    }
}
