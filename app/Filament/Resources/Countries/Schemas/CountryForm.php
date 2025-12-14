<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               TextInput::make("name")->rules(['required', 'min:3', 'max:160'])
                                ->validationMessages([
                                    "min" => "Le Pays doit avoir au moins  2 caractères",
                                    "required" => "Le Pays est oligatoire",
                                    "max" => "Le Pays doit avoir au max  160 caractères"
                                ])
                                ->label("Pays")
            ]);
    }
}
