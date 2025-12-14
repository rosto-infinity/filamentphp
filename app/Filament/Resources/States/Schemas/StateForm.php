<?php

namespace App\Filament\Resources\States\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;


class StateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Select::make("country_id")
                  ->relationship("country", "name"),
                TextInput::make("name")
            ]);
    }
}
