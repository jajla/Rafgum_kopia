<?php

namespace App\Filament\Resources;

use App\Enums\Role;
use App\Enums\services;
use App\Filament\Resources\UserVisitResource\Pages;
use App\Filament\Resources\UserVisitResource\RelationManagers;
use App\Models\Visit;
use App\UserVisitService;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

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
        $dateFormat = 'Y-m-d';
        return $form
            ->schema([
                DatePicker::make('date')
                    ->minDate(now()->format($dateFormat))
                    //->native(false)
                    ->required()
                   //->displayFormat('d F Y')
                    ->live(),
                Select::make('time')
                    ->options(fn(Get $get) => (new UserVisitService())->getAvailableTimesForDate($get('date')))
                    ->hidden(fn(Get $get) => !$get('date'))
                    ->required()
                    ->formatStateUsing(fn($state) => date('H:i', strtotime($state)))
                    ->native(false),

                Select::make('service_type')
                    ->label(__('trans.form.service_type'))
                    ->options(
                        collect(Services::cases())
                            ->mapWithKeys(fn($role) => [$role->value => $role->getLabel()])
                            ->toArray()
                    )->required(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Visit::query()->where('user_id', Auth::id()))
            ->columns([
                TextColumn::make('date') ->formatStateUsing(fn($state) => Carbon::parse($state)
                    ->translatedFormat('j F l')),
                TextColumn::make('time')->formatStateUsing(fn($state) => date('H:i', strtotime($state))),
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

