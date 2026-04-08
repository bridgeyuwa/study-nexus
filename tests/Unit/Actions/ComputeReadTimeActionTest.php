<?php

use App\Actions\News\ComputeReadTimeAction;

test('returns 1 for exactly 200 words', function () {
    $content = implode(' ', array_fill(0, 200, 'word'));

    expect((new ComputeReadTimeAction)->execute($content))->toBe(1);
});

test('rounds up to 2 for 201 words', function () {
    $content = implode(' ', array_fill(0, 201, 'word'));

    expect((new ComputeReadTimeAction)->execute($content))->toBe(2);
});

test('strips html tags before counting words', function () {
    $words = implode(' ', array_fill(0, 200, 'word'));

    expect((new ComputeReadTimeAction)->execute("<p>{$words}</p>"))->toBe(1);
});

test('returns 0 for empty string', function () {
    expect((new ComputeReadTimeAction)->execute(''))->toBe(0);
});

test('returns 0 for html-only content with no words', function () {
    expect((new ComputeReadTimeAction)->execute('<p></p><br/><hr/>'))->toBe(0);
});

test('returns 1 for a single word', function () {
    expect((new ComputeReadTimeAction)->execute('hello'))->toBe(1);
});

test('returns 2 for exactly 400 words', function () {
    $content = implode(' ', array_fill(0, 400, 'word'));

    expect((new ComputeReadTimeAction)->execute($content))->toBe(2);
});
