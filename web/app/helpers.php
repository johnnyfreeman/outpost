<?php

use Tempest\Highlight\Language;
use App\Highlighter\CargoLanguage;
use Illuminate\Support\HtmlString;
use Tempest\Highlight\Highlighter;

function highlight(string|null $code, string|Language $language): HtmlString
{
    if (is_null($code)) {
        return new HtmlString('');
    }

    $highlighter = (new Highlighter)
        ->addLanguage(new CargoLanguage);

    return new HtmlString(
        $highlighter->parse($code, $language),
    );
}
