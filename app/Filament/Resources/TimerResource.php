<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimerResource\Pages;
use App\Filament\Resources\TimerResource\RelationManagers;
use App\Models\Timer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;


class TimerResource extends Resource
{
    protected static ?string $model = Timer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('task_id')
                    ->relationship('task', 'name')
                    ->searchable()
                    ->required()
                    ->label('Task'),

                DateTimePicker::make('started_at')
                    ->required(),

                DateTimePicker::make('stopped_at')
                    ->nullable(),

                // Optional: Read-only duration
                TextInput::make('duration')
                    ->numeric()
                    ->suffix('seconds')
                    ->readOnly()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('task.name')->label('Task'),
                TextColumn::make('started_at')->dateTime()->label('Started'),
                TextColumn::make('stopped_at')->dateTime()->label('Stopped'),
                TextColumn::make('duration')->label('Duration (s)'),
            ])
            ->defaultSort('started_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTimer::route('/'),
            'create' => Pages\CreateTimer::route('/create'),
            'edit' => Pages\EditTimer::route('/{record}/edit'),
        ];
    }
}
