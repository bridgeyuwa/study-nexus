<?php

namespace App\Application\Search\Data;

use App\Domain\Shared\ValueObjects\InstitutionSortOption;
use Illuminate\Http\Request;

final readonly class SearchInstitutionsData
{
    public function __construct(
        public ?string $location,
        public ?string $level,
        public ?string $program,
        public string $type,
        public ?string $category,
        public ?string $religion,
        public InstitutionSortOption $sort,
        public int $page,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        $type = $request->string('type')->toString();

        return new self(
            location: $request->input('location'),
            level: $request->input('level'),
            program: $request->input('program'),
            type: in_array($type, ['public', 'federal', 'state', 'private'], true) ? $type : '',
            category: $request->input('category'),
            religion: $request->input('religion'),
            sort: InstitutionSortOption::fromNullable($request->input('sort')),
            page: (int) $request->input('page', 1),
        );
    }

    public function cacheKey(): string
    {
        return implode('_', [
            'search',
            'location', $this->location ?? 'null',
            'level', $this->level ?? 'null',
            'program', $this->program ?? 'null',
            'type', $this->type ?: 'null',
            'category', $this->category ?? 'null',
            'religion', $this->religion ?? 'null',
            'sort', $this->sort->value ?: 'az',
            'page', $this->page,
        ]);
    }
}
