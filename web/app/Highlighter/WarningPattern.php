<?php

namespace App\Highlighter;

use Tempest\Highlight\Pattern;
use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Tokens\TokenType;

final readonly class WarningPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>warning):\s';
    }

    public function getTokenType(): TokenType
    {
        return ConsoleTokenTypeEnum::WARNING;
    }
}
