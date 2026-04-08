<?php

namespace Tests\Unit;

use App\Http\Controllers\NewsController;
use ReflectionMethod;
use Tests\TestCase;

class ReadTimeTest extends TestCase
{
    private function readTime(string $content): int
    {
        $method = new ReflectionMethod(NewsController::class, 'readTime');
        $method->setAccessible(true);

        return $method->invoke(new NewsController(), $content);
    }

    public function test_strips_html_tags_before_counting_words(): void
    {
        // 200 words wrapped in HTML → 1 minute
        $words   = implode(' ', array_fill(0, 200, 'word'));
        $content = "<p>{$words}</p>";

        $this->assertEquals(1, $this->readTime($content));
    }

    public function test_empty_content_returns_zero_minutes(): void
    {
        $this->assertEquals(0, $this->readTime(''));
    }

    public function test_two_hundred_words_is_exactly_one_minute(): void
    {
        $content = implode(' ', array_fill(0, 200, 'word'));

        $this->assertEquals(1, $this->readTime($content));
    }

    public function test_two_hundred_and_one_words_rounds_up_to_two_minutes(): void
    {
        $content = implode(' ', array_fill(0, 201, 'word'));

        $this->assertEquals(2, $this->readTime($content));
    }

    public function test_four_hundred_words_is_exactly_two_minutes(): void
    {
        $content = implode(' ', array_fill(0, 400, 'word'));

        $this->assertEquals(2, $this->readTime($content));
    }

    public function test_single_word_is_one_minute(): void
    {
        $this->assertEquals(1, $this->readTime('hello'));
    }

    public function test_html_only_content_with_no_words_returns_zero(): void
    {
        $this->assertEquals(0, $this->readTime('<p></p><br/><hr/>'));
    }
}
