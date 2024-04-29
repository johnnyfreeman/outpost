<?php

namespace App\Highlighter;

use Tempest\Highlight\Pattern;
use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Tokens\TokenType;

final readonly class GutterPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[\d\ ]+[\|\+\~\=]\s|\.\.\.|-->)';
    }

    public function getTokenType(): TokenType
    {
        return ConsoleTokenTypeEnum::GUTTER;
    }
}
