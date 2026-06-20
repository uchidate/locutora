<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Csv;

use YOOtheme\Event;
use YOOtheme\File;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\DynamicSourceInputType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Sources\Csv\Type\CsvFilterType;
use ZOOlanders\YOOessentials\Sources\Csv\Type\CsvOrderingType;
use ZOOlanders\YOOessentials\Util\Prop;
use ZOOlanders\YOOessentials\Vendor\League\Csv\Reader;

class CsvSource extends AbstractSourceType implements SourceInterface
{
    /** @var Reader */
    private $csv;

    public function types(): array
    {
        try {
            $this->csv();
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'provider' => 'csv',
                'error' => $e->getMessage()
            ]);

            return [];
        }

        $filterType = new CsvFilterType();
        $orderingType = new CsvOrderingType();
        $objectType = new Type\CsvFileType($this);
        $queryType = new Type\CsvQueryType($this, $objectType);

        return [
            $filterType,
            $orderingType,
            new DynamicSourceInputType($filterType),
            new DynamicSourceInputType($orderingType),
            $objectType,
            $queryType,
        ];
    }

    public function csv(): Reader
    {
        if ($this->csv) {
            return $this->csv;
        }

        $file = $this->config('file');

        if ($file and !Str::startsWith($file, '~')) {
            $file = "~/$file";
        }

        if (!File::exists($file)) {
            throw new \Exception("CSV File Not Found at '{$file}'");
        }

        $enclosure = Prop::parseString($this->config(), 'enclosure', '"', 1);
        $delimiter = Prop::parseString($this->config(), 'delimiter', ',', 1);

        $csv = Reader::createFromPath(File::get($file), 'r')
            ->setHeaderOffset(0)
            ->skipEmptyRecords()
            ->setEnclosure($enclosure)
            ->setDelimiter($delimiter);

        $headers = $csv->getHeader();

        if (count(array_filter($headers)) !== count($headers)) {
            throw new \Exception('CSV File contains empty Headers.');
        }

        if (count(array_unique($headers)) !== count($headers)) {
            $diff = array_diff_key($headers, array_unique($headers));

            throw new \Exception('CSV File contains duplicate Headers: ' . implode(', ', $diff));
        }

        return $this->csv = $csv;
    }
}
