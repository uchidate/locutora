<?php

namespace YOOtheme\Framework\Joomla;

use Joomla\CMS\Document\Document;
use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use YOOtheme\Framework\Application;
use YOOtheme\Framework\ApplicationAware;
use YOOtheme\Framework\Plugin\Plugin;
use YOOtheme\Framework\Routing\JsonResponse;
use YOOtheme\Framework\Routing\RawResponse;
use YOOtheme\Framework\Routing\Request;
use YOOtheme\Framework\Routing\ResponseProvider;

class JoomlaPlugin extends Plugin
{
    /**
     * {@inheritdoc}
     */
    public function main(Application $app)
    {
        require "{$this->path}/classmap.php";

        $app['db'] = function () {
            return new Database(Factory::getDBO());
        };

        $app['url'] = function ($app) {
            return new UrlGenerator($app['request'], $app['locator']);
        };

        $app['request'] = function ($app) {

            $baseUrl   = rtrim(Uri::root(false), '/');
            $basePath  = rtrim(strtr(JPATH_ROOT, '\\', '/'), '/');
            $baseRoute = 'index.php';

            if (isset($app['component'])) {
                $baseRoute .= "?option={$app['component']}";
            }

            return new Request($baseUrl, $basePath, $baseRoute);
        };

        $app['response'] = function ($app) {
            return new ResponseProvider($app['url']);
        };

        $app['csrf'] = function () {
            return new CsrfProvider;
        };

        $app['users'] = function ($app) {
            return new UserProvider($app['component'], isset($app['permissions']) ? $app['permissions'] : array());
        };

        $app['date'] = function () {

            $date = new DateHelper();
            $date->setFormats(array(
                'full'   => Text::_('DATE_FORMAT_LC2'),
                'long'   => Text::_('DATE_FORMAT_LC3'),
                'medium' => Text::_('DATE_FORMAT_LC1'),
                'short'  => Text::_('DATE_FORMAT_LC4')
            ));

            return $date;
        };

        $app['locale'] = function($app) {
            return str_replace('-', '_', $app['joomla.language']->get('tag'));
        };

        $app['admin'] = function ($app) {
            return $app['joomla']->isClient('administrator');
        };

        $app['session'] = function () {
            return Factory::getSession();
        };

        $app['secret'] = function () {
            return Factory::getConfig()->get('secret');
        };

        $app['joomla'] = function () {
            return Factory::getApplication();
        };

        $app['joomla.config'] = function () {
            return Factory::getConfig();
        };

        $app['joomla.language'] = function () {
            return Factory::getLanguage();
        };

        $app['joomla.document'] = function () {
            return Factory::getDocument();
        };

        $app['joomla.article'] = function () {
            return new ArticleHelper;
        };

        $app->extend('filter', function ($filter) {
            return $filter->register('content', new ContentFilter());
        });

        $app->on('boot', array($this, 'boot'));
        $app->on('view', array($this, 'registerAssets'), -10);
    }

    /**
     * Callback for 'boot' event.
     */
    public function boot($event, $app)
    {
        if (!is_dir($app['path.cache']) && !Folder::create($app['path.cache'])) {
            throw new \RuntimeException(sprintf('Unable to create cache folder in "%s"', $app['path.cache']));
        }

        if (isset($app['component'])) {
            $this->registerComponent($app);
        }

        $app['joomla']->registerEvent('onAfterRoute', array($this, 'init'));

        // using onBeforeCompileHead as onBeforeRender is triggered too early on some circumstances
        $app['joomla']->registerEvent('onBeforeCompileHead', function () use ($app) {
            $app->trigger('view', array($app));
        });
    }

    /**
     * Callback to initialize app.
     */
    public function init()
    {
        $this['plugins']->load();
        $this->app->trigger('init', array($this->app));
    }

    /**
     * Callback to register assets.
     */
    public function registerAssets()
    {
        foreach ($this['styles'] as $style) {

            $id = sprintf('%s-css', $style->getName());

            if ($source = $style->getSource()) {
                $this['joomla.document']->addStyleSheet(htmlentities($this['url']->to($source)), 'text/css', null, compact('id'));
            } elseif ($content = $style->getContent()) {
                $this['joomla.document']->addStyleDeclaration($content);
            }
        }

        foreach ($this['scripts'] as $script) {
            if ($source = $script->getSource()) {
                $this['joomla.document']->addScript(htmlentities($this['url']->to($source)), array(), array('defer' => !!$script->getOption('defer')));
            } elseif ($content = $script->getContent()) {
                $this['joomla.document']->addScriptDeclaration($content);
            } elseif ($template = $script->getOption('template')) {
                $this['joomla.document']->addCustomTag(sprintf("<script id=\"%s\" type=\"text/template\">%s</script>\n", $script->getName(), $this['view']->render($template)));
            }
        }
    }

    /**
     * Registers Joomla component integration.
     */
    protected function registerComponent(Application $app)
    {
        $app['joomla']->registerEvent('onAfterDispatch', function () use ($app) {

            if ($app['component'] !== $app['joomla']->input->get('option')) {
                return;
            }

            $response = $app->handle(null, false);

            if ($response->getStatus() != 200) {
                $app['joomla']->setHeader('status', $response->getStatus());
            }

            if ($response instanceof JsonResponse) {
                $app['joomla']->input->set('format', 'json');
                $app['joomla']->loadDocument(Document::getInstance('json')->setBuffer((string) $response));
            } elseif ($response instanceof RawResponse) {
                $app['joomla']->input->set('format', 'raw');
                $app['joomla']->loadDocument(Document::getInstance('raw')->setBuffer((string) $response));
            } else {
                $app['joomla.document']->setBuffer((string) $response, 'component');
            }

        });
    }
}
