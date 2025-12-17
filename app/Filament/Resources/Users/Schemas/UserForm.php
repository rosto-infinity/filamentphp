<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\State;
use App\Models\Country;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Information de connection")->schema(([
                    TextInput::make("name"),
                    TextInput::make('email'),
                    TextInput::make('password')->password(),
                ])),
                Section::make("Localisation")->schema([
                    Select::make("country_id")
                        ->label("Pays")
                        ->options(Country::pluck("name", "id"))->reactive()
                        ->searchable(),
                    // ->live(), // -Déclenche la mise à jour immédiate des autres champs
                    Select::make("state_id")
                        ->label("Nom de la region")
                        ->options(function (callable $get) {
                            $country = $get("country_id");
                            if (!$country) {
                                return [];
                            } else {
                                return State::whereCountryId($country)
                                    ->pluck('name', 'id');
                            }
                        })->reactive()
                        ->searchable()
                        ->preload() // Optionnel : charge les données pour une recherche plus fluide
                        ->key('state_select'), // Aide parfois Livewire à suivre le composant

                ])
            ]);
    }
}
