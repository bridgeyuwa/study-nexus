<?php

namespace App\Application\Search\Actions;

use App\Application\Search\Data\SearchInstitutionsData;
use App\Application\Search\Queries\InstitutionSearchQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

final readonly class SearchInstitutionsAction
{
    public function __construct(private InstitutionSearchQuery $query)
    {
    }

    public function execute(SearchInstitutionsData $data): LengthAwarePaginator
    {
        return Cache::remember(
            $data->cacheKey(),
            60 * 60,
            fn () => $this->query->execute($data)
        );
    }
}
