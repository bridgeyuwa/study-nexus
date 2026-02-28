<?php

namespace Tests\Unit\Application\Search;

use App\Application\Search\Data\SearchInstitutionsData;
use Illuminate\Http\Request;
use Tests\TestCase;

class SearchInstitutionsDataTest extends TestCase
{
    public function test_cache_key_is_stable_for_valid_filters(): void
    {
        $request = Request::create('/search', 'GET', [
            'location' => '1',
            'level' => '2',
            'program' => '3',
            'type' => 'public',
            'category' => '4',
            'religion' => '5',
            'sort' => 'rank',
            'page' => 2,
        ]);

        $data = SearchInstitutionsData::fromRequest($request);

        $this->assertSame('search_location_1_level_2_program_3_type_public_category_4_religion_5_sort_rank_page_2', $data->cacheKey());
    }
}
