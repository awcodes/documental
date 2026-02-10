<?php

use Awcodes\Documental\Facades\Documental;
use League\CommonMark\Exception\CommonMarkException;

if (! function_exists('docMarkdown')) {
    /**
     * Convert a string to a markdown array.
     *
     * @return array{'content': string, 'toc': string}
     *
     * @throws CommonMarkException
     */
    function docMarkdown(string $string): array
    {
        return Documental::markdown($string);
    }
}
