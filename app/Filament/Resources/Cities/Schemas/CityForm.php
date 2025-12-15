<?php

namespace App\Filament\Resources\Cities\Schemas;

use App\Models\Country;
use App\Models\State;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('country_id')
                    ->label('Nom du pays')
                    ->options(Country::pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->reactive(),
                Select::make('state_id')
                    ->label('Nom de la region')
                    ->options(function (callable $get) {
                        $country = $get('country_id');
                        if (!$country) {
                            return [];
                        } else {
                            return State::whereCountryId($country)
                                ->pluck('name', 'id');
                        }
                    })->reactive(),
                TextInput::make('name')
                    ->label('Non de la ville')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
