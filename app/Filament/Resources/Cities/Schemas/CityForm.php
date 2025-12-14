<?php

namespace App\Filament\Resources\Cities\Schemas;

use App\Models\Country;
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
                  ->options(Country::pluck("name", "id")),
                   Select::make("state_id")
                  ->relationship("state", "name"),
                TextInput::make("name"),    
            ]);
    }
}
