<?php

namespace App\Highlighter;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Php\Patterns\KeywordPattern;

class CargoLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'cargo';
    }
    
    public function getAliases(): array
    {
        return [];
    }
    
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new WarningPattern,
            new HelpPattern,
        ];
    }
}
