<?php

namespace App\Filament\Resources\MealResource\Pages;

use App\Filament\Resources\MealResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMeals extends ManageRecords
{
    protected static string $resource = MealResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
