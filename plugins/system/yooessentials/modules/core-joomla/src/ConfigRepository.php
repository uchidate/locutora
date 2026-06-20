<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Joomla;

use Joomla\CMS\User\User;
use YOOtheme\Config;
use YOOtheme\Database;
use YOOtheme\Http\Request;
use ZOOlanders\YOOessentials\Config\AbstractConfigRepository;
use ZOOlanders\YOOessentials\Config\ConfigInterface;
use ZOOlanders\YOOessentials\Config\ConfigRepositoryInterface;

class ConfigRepository extends AbstractConfigRepository implements ConfigRepositoryInterface
{
    protected const FOLDER = 'system';
    protected const ELEMENT = 'yooessentials';

    /** @var Database */
    private $database;
    /** @var Config */
    private $config;
    /** @var User */
    private $user;

    public function __construct(Database $database, Config $config, User $user)
    {
        $this->database = $database;
        $this->config = $config;
        $this->user = $user;
    }

    public function authorize(): bool
    {
        if ($this->config->get('app.isAdmin') && !$this->user->authorise('core.edit', 'com_templates')) {
            return false;
        }

        return true;
    }

    public function load(ConfigInterface $config): void
    {
        $query = 'SELECT custom_data FROM @extensions WHERE element = :element AND folder = :folder LIMIT 1';

        $result = $this->database->fetchAssoc($query, [
            'folder' => self::FOLDER,
            'element' => self::ELEMENT,
        ]);

        $values = json_decode($result['custom_data'] ?? null, true);
        if (!$values) {
            return;
        }

        $config->replace($values);
    }

    public function fromRequest(Request $request): ?array
    {
        // if in preview request
        if ($custom = $request('customizer')) {
            $params = json_decode(base64_decode($custom), true);

            return $params['yooessentials'] ?? null;
        }

        return null;
    }

    protected function persist(array $values): void
    {
        $data = json_encode($values);
        if (!$data) {
            return;
        }

        $this->database->update('@extensions', ['custom_data' => $data], [
            'folder' => self::FOLDER,
            'element' => self::ELEMENT,
        ]);
    }
}
