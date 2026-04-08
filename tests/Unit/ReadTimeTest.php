<?php

use App\Http\Controllers\NewsController;
use ReflectionMethod;

// Thin wrapper so tests can call readTime() without repeating reflection boilerplate.
function readTime(string $content): float
{
    static $method = null;
    $method ??= tap(
        new ReflectionMethod(NewsController::class, 'readTime'),
        fn ($m) => $m->setAccessible(true)
    );

    return $method->invoke(new NewsController(), $content);
}

// ceil() always returns float, so we use toEqual() (loose) throughout.

it('strips html tags before counting words', function () {
    $words = implode(' ', array_fill(0, 200, 'word'));
    expect(readTime("<p>{$words}</p>"))->toEqual(1);
});

it('returns zero minutes for empty content', function () {
    expect(readTime(''))->toEqual(0);
});

it('returns 1 minute for exactly 200 words', function () {
    expect(readTime(implode(' ', array_fill(0, 200, 'word'))))->toEqual(1);
});

it('rounds up to 2 minutes for 201 words', function () {
    expect(readTime(implode(' ', array_fill(0, 201, 'word'))))->toEqual(2);
});

it('returns 2 minutes for exactly 400 words', function () {
    expect(readTime(implode(' ', array_fill(0, 400, 'word'))))->toEqual(2);
});

it('returns 1 minute for a single word', function () {
    expect(readTime('hello'))->toEqual(1);
});

it('returns zero for html-only content with no words', function () {
    expect(readTime('<p></p><br/><hr/>'))->toEqual(0);
});
