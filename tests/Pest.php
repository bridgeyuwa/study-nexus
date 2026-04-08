<?php

// All Feature tests run inside the Laravel TestCase and get a fresh
// in-memory database for every test.
pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

// Unit tests run inside the Laravel TestCase only. Those that need
// the database declare RefreshDatabase themselves (ComputeRankTest).
pest()->extend(Tests\TestCase::class)
    ->in('Unit');
