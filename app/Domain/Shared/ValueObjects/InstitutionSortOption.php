<?php

namespace App\Domain\Shared\ValueObjects;

final readonly class InstitutionSortOption
{
    private const RANK = 'rank';
    private const ZA = 'za';
    private const AZ = '';

    private function __construct(public string $value)
    {
    }

    public static function fromNullable(?string $sort): self
    {
        if (in_array($sort, [self::RANK, self::ZA], true)) {
            return new self($sort);
        }

        return new self(self::AZ);
    }

    public function label(): string
    {
        return match ($this->value) {
            self::RANK => 'Rank',
            self::ZA => 'Z - A',
            default => 'A - Z',
        };
    }
}
