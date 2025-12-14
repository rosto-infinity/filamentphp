<?php

namespace App\Filament\Resources\Tags\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')->rules([
                    "required",
                ])->reactive()
                    ->afterStateUpdated(fn($state, callable $set) =>
                    $set("slug", Str::slug($state))),
                TextInput::make('slug'),
            ]);
    }
}
