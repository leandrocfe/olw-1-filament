<?php

namespace App\Filament\Resources\ExportResource\Pages;

use App\Filament\Resources\ExportResource;
use App\Models\Export;
use Closure;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListExports extends ListRecords
{
    protected static string $resource = ExportResource::class;

    protected function getActions(): array
    {
        return [];
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (Export $record): null|string => null;
    }

    protected function getTableQuery(): Builder
    {
        return Export::where('user_id', auth()->user()->id);
    }
}
