<?php

namespace App\Highlighter;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class HelpPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>help):\s';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::PROPERTY;
    }
}
