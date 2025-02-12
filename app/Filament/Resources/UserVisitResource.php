<?php

namespace App\Filament\Resources;

use App\Enums\Role;
use App\Filament\Resources\UserVisitResource\Pages;
use App\Filament\Resources\UserVisitResource\RelationManagers;
use App\Models\UserVisit;
use App\Models\Visit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserVisitResource extends Resource
{
    public static function canAccess(): bool
    {
        return auth()->user()->role === Role::User; // Sprawdzenie, czy użytkownik jest adminem
    }

    protected static ?string $label = 'Customer';
    protected static ?string $navigationLabel = 'Customers';
    protected static ?string $slug = 'pending-orders';
    protected static ?string $model = Visit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                //
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
            'index' => Pages\ListUserVisits::route('/'),
            'create' => Pages\CreateUserVisit::route('/create'),
            'edit' => Pages\EditUserVisit::route('/{record}/edit'),
        ];
    }
}
