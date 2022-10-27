<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Beers extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-badge-check';

    protected static string $view = 'filament.pages.beers';

    protected static ?string $navigationGroup = 'Beers';
}
