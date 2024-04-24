<?php

declare(strict_types=1);

namespace App\Highlighter;

use Tempest\Highlight\Tokens\TokenType;

enum ConsoleTokenTypeEnum: string implements TokenType
{
    case WARNING = 'rounded-sm bg-yellow-500 text-white px-1 py-0.5';
    case HELP = 'rounded-sm bg-teal-500 text-white px-1 py-0.5';
    case NOTE = 'rounded-sm bg-blue-500 text-white px-1 py-0.5';
    case FINISHED = 'text-green-300';
    case GUTTER = 'text-gray-600';

    public function getValue(): string
    {
        return $this->value;
    }

    public function canContain(TokenType $other): bool
    {
        return false;
    }
}
