<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectRoleResource\Pages;
use App\Filament\Resources\ProjectRoleResource\RelationManagers;
use App\Models\ProjectRole;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use App\Models\User;
use App\Models\Project;
use App\Models\Role;

class ProjectRoleResource extends Resource
{
    protected static ?string $model = ProjectRole::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->options(fn () => User::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Select::make('project_id')
                    ->label('Project')
                    ->options(fn () => Project::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Select::make('role_id')
                    ->label('Role')
                    ->options(fn () => Role::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User')->sortable(),
                TextColumn::make('project.name')->label('Project')->sortable(),
                TextColumn::make('role.name')->label('Role')->sortable(),
                TextColumn::make('created_at')->dateTime()->label('Created'),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListProjectRoles::route('/'),
            'create' => Pages\CreateProjectRole::route('/create'),
            'edit' => Pages\EditProjectRole::route('/{record}/edit'),
        ];
    }
}
