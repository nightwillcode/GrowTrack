<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskScheduleResource\Pages;
use App\Filament\Resources\TaskScheduleResource\RelationManagers;
use App\Models\TaskSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use App\Models\User;
use App\Models\Project;

class TaskScheduleResource extends Resource
{
    protected static ?string $model = TaskSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('project_id')
                    ->label('Project')
                    ->options(fn () => Project::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Select::make('user_id')
                    ->label('User')
                    ->options(fn () => User::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                TextInput::make('name')
                    ->label('Task Name')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->nullable()
                    ->maxLength(1000)
                    ->rows(4),

                DatePicker::make('visible_at')
                    ->label('Visible Date')
                    ->nullable(),

                TextInput::make('duration')
                    ->label('Repeat Count')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->helperText('Berapa kali task diulang sesuai frekuensi yang dipilih.'),

                Select::make('frequency')
                    ->options([
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'monthly' => 'Monthly',
                    ])
                    ->required()
                    ->reactive(),

                Toggle::make('allow_saturday')
                    ->visible(fn (Get $get) => $get('frequency') === 'daily'),

                Toggle::make('allow_sunday')
                    ->visible(fn (Get $get) => $get('frequency') === 'daily'),
                            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('project.name')->label('Project')->sortable(),
                TextColumn::make('user.name')->label('User')->sortable(),
                TextColumn::make('duration')->sortable()->searchable(),
                TextColumn::make('visible_at')->date()->label('Visible'),
                TextColumn::make('frequency')->sortable()->searchable(),
                TextColumn::make('created_at')->sortable()->searchable(),
            ])
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
            'index' => Pages\ListTaskSchedules::route('/'),
            'create' => Pages\CreateTaskSchedule::route('/create'),
            'edit' => Pages\EditTaskSchedule::route('/{record}/edit'),
        ];
    }
}
