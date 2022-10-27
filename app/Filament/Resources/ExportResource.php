<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExportResource\Pages;
use App\Models\Export;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class ExportResource extends Resource
{
    protected static ?string $model = Export::class;

    protected static ?string $navigationIcon = 'heroicon-o-cloud-download';

    protected static ?string $navigationGroup = 'Beers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //id
                TextColumn::make('id')
                    ->sortable()
                    ->searchable(),

                //user
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),

                //name
                TextColumn::make('file_name')
                    ->sortable()
                    ->searchable(),

                //created_at
                TextColumn::make('created_at')
                    ->dateTime('d/m/y H:i')
                    ->sortable(),

                //updated_at
                TextColumn::make('updated_at')
                    ->dateTime('d/m/y H:i')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('created_at')
                ->form([
                    DatePicker::make('created_from'),
                    DatePicker::make('created_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                }),
            ])
            ->actions([
                Action::make('download')
                    ->url(fn (Export $record): string => Storage::disk('s3')->url($record->file_name))
                    ->icon('heroicon-o-download')
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExports::route('/'),
            //'create' => Pages\CreateExport::route('/create'),
            //'edit' => Pages\EditExport::route('/{record}/edit'),
        ];
    }
}
