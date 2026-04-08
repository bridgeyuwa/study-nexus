<?php

namespace App\DTOs;

use App\Models\CategoryClass;
use App\Models\Level;
use App\Models\Program;
use App\Models\ReligiousAffiliationCategory;
use App\Models\State;

final class SearchFiltersData
{
    public function __construct(
        public readonly ?State $state,
        public readonly ?Level $level,
        public readonly ?Program $program,
        public readonly string $typeSlug,
        public readonly ?CategoryClass $categoryClass,
        public readonly ?ReligiousAffiliationCategory $religiousAffiliationCategory,
        public readonly string $sortBy,
        public readonly int $page,
    ) {}

    public function cacheKey(): string
    {
        return 'search_'
            .'location_'.($this->state?->id ?? 'null')
            .'_level_'.($this->level?->id ?? 'null')
            .'_program_'.($this->program?->id ?? 'null')
            .'_type_'.($this->typeSlug ?: 'null')
            .'_category_'.($this->categoryClass?->id ?? 'null')
            .'_religion_'.($this->religiousAffiliationCategory?->id ?? 'null')
            .'_sort_'.($this->sortBy ?: 'null')
            .$this->page;
    }
}
