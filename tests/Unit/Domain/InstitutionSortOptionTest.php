<?php

namespace Tests\Unit\Domain;

use App\Domain\Shared\ValueObjects\InstitutionSortOption;
use PHPUnit\Framework\TestCase;

class InstitutionSortOptionTest extends TestCase
{
    public function test_it_defaults_to_az_for_unknown_value(): void
    {
        $option = InstitutionSortOption::fromNullable('invalid');

        $this->assertSame('', $option->value);
        $this->assertSame('A - Z', $option->label());
    }
}
