<?php
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;

class PlgContentFontawesomeicon extends CMSPlugin
{
    public function onContentPrepare($context, &$row, &$params, $page = 0)
    {
        // Check if the content is an object and has a text property
        if (is_object($row) && isset($row->text)) {
            $row->text = $this->replaceIcon($row->text);
        } elseif (is_string($row)) {
            $row = $this->replaceIcon($row);
        }
    }

    private function replaceIcon($text)
    {
        // The pattern to search for any Font Awesome shortcode, e.g., {fa fa-home}, {fas fa-user}, etc.
        $pattern = '/\{(fa[s|r|l|b]?|fab|fal|far|fas) fa-([a-z0-9-]+)\}/';

        // Replacement using a callback function to construct the HTML dynamically
        $replacement = function ($matches) {
            // matches[1] is the font awesome style prefix (fas, far, etc.)
            // matches[2] is the icon name
            return '<i class="' . $matches[1] . ' fa-' . $matches[2] . '"></i>';
        };

        // Perform the replacement
        return preg_replace_callback($pattern, $replacement, $text);
    }
}