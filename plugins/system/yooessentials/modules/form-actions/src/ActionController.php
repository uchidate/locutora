<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions;

use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Form\Form;

class ActionController
{
    public const ACTIONS_URL = '/yooessentials/actions';

    public function actions(Response $response, Form $form)
    {
        return $response->withJson($form->actions());
    }
}
