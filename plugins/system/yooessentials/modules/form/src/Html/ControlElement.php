<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Html;

use YOOtheme\View\HtmlElement;

class ControlElement
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $label;

    /**
     * @var bool
     */
    public $required;

    /**
     * Constructor.
     *
     * @param string   $name
     * @param array    $attrs
     * @param mixed    $contents
     * @param callable $transform
     */
    public function __construct($name = null, $label = null, $required = false, $id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
    }

    /**
     * Renders element shortcut.
     *
     * @see render()
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Render element shortcut.
     *
     * @param array      $params
     * @param null|mixed $attrs
     *
     * @return string
     *
     * @see render()
     */
    public function __invoke(array $params = [], array $attrs = [])
    {
        return $this->render($params, $attrs);
    }

    /**
     * Renders the element tag.
     *
     * @param array  $params
     * @param array  $attrs
     *
     * @return string
     */
    public function render(array $params = [], array $attrs = [])
    {
        $html = [];

        $attrs = HtmlElement::attrs(array_merge([
            'data-yooessentials-form-field' => $this->name
        ], $attrs), $params);

        $for = $this->id ?? $this->name;

        $html[] = "<div{$attrs}>";

        if ($this->label) {
            $html[] = "<label class=\"uk-form-label\" for=\"{$for}\">";
            $html[] = $this->label;

            if ($this->required) {
                $html[] = ' *';
            }

            $html[] = '</label>';
        }

        $html[] = '<div class="uk-form-controls">';

        return implode('', $html);
    }

    /**
     * Renders element closing tag.
     *
     * @return string
     */
    public function end()
    {
        $errors = new HtmlElement('div', [
            'class' => [
                'uk-text-danger',
                'uk-text-small'
            ],
            'data-yooessentials-form-field-errors' => true
        ], '');

        return "</div>{$errors()}</div>";
    }
}
