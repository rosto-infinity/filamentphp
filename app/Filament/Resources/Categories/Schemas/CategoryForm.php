<?php

namespace App\Filament\Resources\Categories\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->reactive()
                    ->afterStateUpdated(fn($state, callable $set) =>
                    $set("slug", Str::slug($state))),
                TextInput::make('slug')
            ]);
    }
}
