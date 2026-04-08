<?php

use App\Actions\News\GetSimilarNewsAction;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Support\Facades\Cache;

test('returns a collection of at most 5 items', function () {
    $category = NewsCategory::factory()->create();
    $source = News::factory()->create();
    $source->newsCategories()->attach($category);

    News::factory()->count(6)->create()->each(fn ($n) => $n->newsCategories()->attach($category));

    $result = (new GetSimilarNewsAction)->execute($source->load('newsCategories'));

    expect($result)->toHaveCount(5);
});

test('excludes the source news item from results', function () {
    $category = NewsCategory::factory()->create();
    $source = News::factory()->create();
    $source->newsCategories()->attach($category);

    $similar = News::factory()->create();
    $similar->newsCategories()->attach($category);

    $result = (new GetSimilarNewsAction)->execute($source->load('newsCategories'));

    expect($result->pluck('id'))->not->toContain($source->id);
});

test('returns only news sharing at least one category with the source', function () {
    $sharedCategory = NewsCategory::factory()->create();
    $unrelatedCategory = NewsCategory::factory()->create();

    $source = News::factory()->create();
    $source->newsCategories()->attach($sharedCategory);

    $related = News::factory()->create();
    $related->newsCategories()->attach($sharedCategory);

    $unrelated = News::factory()->create();
    $unrelated->newsCategories()->attach($unrelatedCategory);

    $result = (new GetSimilarNewsAction)->execute($source->load('newsCategories'));

    expect($result->pluck('id'))
        ->toContain($related->id)
        ->not->toContain($unrelated->id);
});

test('returns an empty collection when no other news shares a category', function () {
    $source = News::factory()->create();
    $source->newsCategories()->attach(NewsCategory::factory()->create());

    News::factory()->create()->newsCategories()->attach(NewsCategory::factory()->create());

    $result = (new GetSimilarNewsAction)->execute($source->load('newsCategories'));

    expect($result)->toHaveCount(0);
});

test('result is cached by news id', function () {
    $category = NewsCategory::factory()->create();
    $source = News::factory()->create();
    $source->newsCategories()->attach($category);

    Cache::spy();

    (new GetSimilarNewsAction)->execute($source->load('newsCategories'));

    Cache::shouldHaveReceived('remember')
        ->once()
        ->withArgs(fn ($key) => $key === 'similar_news_'.$source->id);
});

test('second call with same news returns cached result without re-querying', function () {
    $category = NewsCategory::factory()->create();
    $source = News::factory()->create();
    $source->newsCategories()->attach($category);

    $similar = News::factory()->create();
    $similar->newsCategories()->attach($category);

    $action = new GetSimilarNewsAction;
    $first = $action->execute($source->load('newsCategories'));

    // Add more similar news after first call — cache should serve stale result.
    $extra = News::factory()->create();
    $extra->newsCategories()->attach($category);

    $second = $action->execute($source->load('newsCategories'));

    expect($first->pluck('id')->sort()->values())
        ->toEqual($second->pluck('id')->sort()->values());
});
