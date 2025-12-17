<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\City;
use App\Models\State;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class UserForm
{
   public static function configure(Schema $schema): Schema
{
    return $schema->components([
        Section::make("Information de connexion")
            ->columns(2) // Organisation sur 2 colonnes pour la propreté
            ->schema([
                TextInput::make("name")
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

        Section::make("Localisation")
            ->columns(3) // Pays, Région et Ville sur une seule ligne
            ->schema([
                // PAYS
                Select::make("country_id")
                    ->label("Pays")
                    ->relationship('country', 'name') // Utilise la relation définie dans le modèle
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('state_id', null)), // Reset la région si le pays change

                // RÉGION
                Select::make("state_id")
                    ->label("Région")
                    ->options(fn (callable $get) => 
                        State::where('country_id', $get('country_id'))
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('city_id', null)) // Reset la ville si la région change
                    ->disabled(fn (callable $get) => !$get('country_id')), // Grisé si pas de pays

                // VILLE
                Select::make("city_id")
                    ->label("Ville")
                    ->options(fn (callable $get) => 
                        City::where('state_id', $get('state_id'))
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->disabled(fn (callable $get) => !$get('state_id')), // Grisé si pas de région
            ])
    ]);
}

}
