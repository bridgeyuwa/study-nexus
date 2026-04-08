<?php

namespace App\Actions\News;

final class ComputeReadTimeAction
{
    public function execute(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));

        return (int) ceil($wordCount / 200);
    }
}
