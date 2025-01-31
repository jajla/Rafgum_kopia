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
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
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
                TextColumn::make('time')->label('Time')->formatStateUsing(fn($state) => date('H:i', strtotime($state))),
                TextColumn::make('date')->formatStateUsing(fn($state) => Carbon::parse($state)->translatedFormat('j F l')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Section::make('podawanie danych')
                            ->schema([
                                Grid::make([
                                    'sm' => 2,
                                    'md' => 3,
                                    'lg' => 2,
                                    'xl' => 2,
                                    '2xl' => 2,
                                ])
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Imię')
                                            ->required(),

                                        Select::make('user_id')
                                            ->native(false)
                                            ->options(User::query()->get()->mapWithKeys(fn($user) => [$user->id => $user->last_name]))
                                            ->label('Wybierz użytkownika')
                                            ->required(),
                                    ]),
                            ]),
                        Section::make('data i czas')
                            ->schema([
                                Grid::make([
                                    'sm' => 2,       // Na małych ekranach 2 kolumny
                                    'md' => 2,       // Na średnich ekranach 2 kolumny
                                    'lg' => 2,       // Na dużych ekranach 2 kolumny
                                    'xl' => 2,       // Na bardzo dużych ekranach 3 kolumny
                                    '2xl' => 2,      // Na ekranach 2xl 4 kolumny
                                ])
                                ->schema([
                                    DatePicker::make('date')
                                        ->label('Data')
                                        ->minDate(now()->subDays(1))
                                        ->displayFormat('d F Y')
                                        ->required(),

                                    TimePicker::make('time')
                                        ->label('Czas')
                                        ->minutesStep(30)
                                        ->seconds(false)
                                        ->required(),
                                ])
                            ]),
                    ]),

                /* Section::make([
                     Select::make('user_id')
                         ->native(false)
                         ->options(User::query()->get()->mapWithKeys(fn($user) => [$user->id => $user->last_name]))
                         ->afterStateUpdated(function ($state) {
                             $user = User::find($state);
                         }),
                 ]), tu sie konczy 1 section*/
                /* Section::make([
                     DatePicker::make('date')
                         ->minDate(now()->subDays(1))->native(false)
                         ->displayFormat('d F Y'),

                     TimePicker::make('time')->native(false)
                         ->seconds(false)
                         ->minutesStep(30)

                 ]) tu sie konczy 2 section*/

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
