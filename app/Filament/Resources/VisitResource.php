<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitResource\Pages;
use App\Filament\Resources\VisitResource\RelationManagers;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitResource extends Resource
{
    protected static ?string $model = Visit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')->label('Date'),
                TimePicker::make('time')->label('time'),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.last_name')->label('User'),
                TextColumn::make('time')->label('Time')->formatStateUsing(fn($state) => Carbon::parse($state)->translatedFormat('H:m')),
                TextColumn::make('date')->formatStateUsing(fn($state) => Carbon::parse($state)->translatedFormat('j F l')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->form([
                    Fieldset::make('Visit')
                        ->schema([
                            Select::make('user_id')
                                ->options(User::query()->get()->mapWithKeys(fn($user) => [$user->id => $user->last_name]))
                                ->afterStateUpdated(function ($state) {
                                    $user = User::find($state);
                                }),
                            DatePicker::make('date'),
                           TimePicker::make('time')->native(false)->seconds(false)->minutesStep(30)
                        ])
                ]),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageVisits::route('/'),
        ];
    }
}
