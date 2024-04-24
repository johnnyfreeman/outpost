<?php

namespace App\Highlighter;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;

final readonly class FinishedPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>Finished)\s';
    }

    public function getTokenType(): TokenType
    {
        return ConsoleTokenTypeEnum::FINISHED;
    }
}
