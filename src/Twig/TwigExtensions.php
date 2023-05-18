<?php

namespace App\Twig;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigExtensions extends AbstractExtension
{

    public function getFilters()
    {
        return [
            new TwigFilter('unset', [$this, 'unsetArrayItem']),
            new TwigFilter('shortText', [$this, 'getShortText']),
            new TwigFilter('add_query', [$this, 'addQueryParams'])
        ];
    }

    public function addQueryParams(string $url): string
    {
        $queryString = $_SERVER['QUERY_STRING'];

        if ($queryString) {
            $url .= '?' . $queryString;
        }

        return $url;
    }

    public function getShortText($text, $length = 20)
    {
        if (strlen($text) > $length + 3) {
            $text = substr($text, 0, $length);
            $text .= '...';
        }

        return $text;
    }

    public function unsetArrayItem($array, $unsetItem)
    {
        if (isset($array[$unsetItem])) {
            unset($array[$unsetItem]);
        }
        return $array;
    }
}
