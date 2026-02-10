<?php

namespace Awcodes\Documental\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum VersionStatus: string implements HasColor, HasLabel
{
    case ReleaseCandidate = 'rc';
    case Alpha = 'alpha';
    case Beta = 'beta';
    case Stable = 'stable';

    public function getLabel(): string
    {
        return match ($this) {
            self::ReleaseCandidate => 'RC',
            self::Alpha => 'Alpha',
            self::Beta => 'Beta',
            self::Stable => 'Stable',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::ReleaseCandidate => 'danger',
            self::Alpha => 'warning',
            self::Beta => 'info',
            self::Stable => 'success',
        };
    }
}
