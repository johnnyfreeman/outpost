<?php

namespace App\Highlighter;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class WarningPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>warning):\s';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::TYPE;
    }
}
