<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Information de connexion')
                ->columns(2) // -Organisation sur 2 colonnes pour la propreté
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true), // -Évite l'erreur d'email déjà pris lors de l'edit
                    TextInput::make('password')
                        ->password()
                        ->dehydrated(fn ($state) => filled($state)) // -N'enregistre que s'il est rempli
                        ->required(fn ($context) => $context === 'create'), // -Requis uniquement à la création
                ]),

            Section::make('Localisation')
                ->columns(3)
                ->schema([
                    // PAYS
                    Select::make('country_id')
                        ->label('Pays')
                        ->options(Country::pluck('name', 'id'))
                        ->live() // --Recommandé en 2025 à la place de reactive()
                        ->searchable()
                        ->preload()
                        ->afterStateUpdated(function ($set) {
                            $set('state_id', null);
                            $set('city_id', null);
                        }),

                    // RÉGION
                    Select::make('state_id')
                        ->label('Région')
                        ->options(function (callable $get) {
                            $countryId = $get('country_id');

                            if (! $countryId) {
                                return [];
                            }

                            return State::where('country_id', $countryId)
                                ->pluck('name', 'id');
                        })
                        ->live()
                        ->searchable()
                        ->preload()
                        ->afterStateUpdated(fn ($set) => $set('city_id', null))
                        ->disabled(fn (callable $get) => ! $get('country_id')),

                    // VILLE
                    Select::make('city_id')
                        ->label('Ville')
                        ->options(function (callable $get) {
                            $stateId = $get('state_id');

                            if (! $stateId) {
                                return [];
                            }

                            return City::where('state_id', $stateId)
                                ->pluck('name', 'id');
                        })
                        ->searchable()
                        ->preload()
                        ->disabled(fn (callable $get) => ! $get('state_id')),
                ]),

        ]);
    }
}
