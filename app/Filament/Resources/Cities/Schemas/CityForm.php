<?php

namespace App\Filament\Resources\Cities\Schemas;

use App\Models\Country;
use App\Models\State;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make("country_id")
                    ->options(Country::pluck("name", "id"))->reactive(),
                Select::make("state_id")
                    ->label("Nom de la region")
                    ->options(function (callable $get) {
                        $country = $get("country_id");
                        if (!$country) {
                            return [];
                        } else {
                            return State::whereCountryId($country)
                                ->pluck("name", "id");
                        }
                    })->reactive(),
                TextInput::make("name"),
            ]);
    }
}
