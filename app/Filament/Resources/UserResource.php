<?php

namespace App\Filament\Resources;

use App\Enums\Role;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Widgets\UserWidget;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    public static function canAccess(): bool
    {
        return auth()->user()->role === Role::Admin;
    }

    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getPluralLabel(): string
    {
        return __('trans.resources.users');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'md' => 3,
                    'lg' => 3,
                    'xl' => 3,
                    '2xl' => 3,
                ])->schema([
                    TextInput::make('first_name')
                        ->label(__('trans.form.first_name'))
                        ->required()
                        ->alpha()
                        ->autofocus(),
                    TextInput::make('last_name')
                        ->label(__('trans.form.last_name'))
                        ->required()
                        ->alpha(),
                    TextInput::make('email')
                        ->label(__('trans.form.email'))
                        ->required()
                        ->email()
                        ->unique(User::class),
                    TextInput::make('phone_number')
                        ->label(__('trans.form.phone_number'))
                        ->required()
                        ->minValue(9)
                        ->integer(),
                    Select::make('role')
                        ->label(__('trans.form.role'))
                        ->options(
                            collect(Role::cases())
                                ->mapWithKeys(fn($role) => [$role->value => $role->getLabel()])
                                ->toArray()
                        ),
                    TextInput::make('password')
                        ->label(__('password'))
                        ->required()
                        ->password(),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(['20','30','40','all'])
            ->defaultPaginationPageOption(30)
            ->columns([
                Split::make([
                    //w tabeli nie da sie dac tlumaczen bo nie ma label
                    Textcolumn::make('first_name')
                        ->searchable()
                        ->alignCenter(),
                    Textcolumn::make('last_name')
                        ->alignCenter(),
                    Textcolumn::make('email')
                        ->alignCenter(),
                    Textcolumn::make('phone_number')
                        ->formatStateUsing(function ($state) {
                            return preg_replace('/(\d{3})(\d{3})(\d{3})/', '$1-$2-$3', $state);
                        })->alignCenter(),
                    Textcolumn::make('role')
                        ->formatStateUsing(fn($state) => $state->getLabel())
                        ->alignCenter()

                    //label z role enum
                ])->from('xl'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->form([
                    Fieldset::make('Podstawowe informacje')
                        ->schema([
                            TextInput::make('first_name')
                                ->label(__('trans.form.first_name')),
                            TextInput::make('last_name')
                                ->label(__('trans.form.last_name')),
                            TextInput::make('phone_number')
                                ->label(__('trans.form.phone_number')),
                            TextInput::make('email')
                                ->label(__('trans.form.email')),
                            Select::make('role')
                                ->label(__('trans.form.role'))
                                ->options(
                                    collect(Role::cases())
                                        ->mapWithKeys(fn($role) => [$role->value => $role->getLabel()])
                                        ->toArray()
                                ),
                            TextInput::make('password')->label(__('trans.form.password')),
                        ])->columns(3),
                ]),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
