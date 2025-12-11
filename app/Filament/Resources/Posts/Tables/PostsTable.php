<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Toggle;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;

class PostsTable
{
    
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make("image")
                ->circular()
                ->disk("public"),
                TextColumn::make("title")->sortable()->searchable(),
                TextColumn::make("slug")->sortable()->searchable(),
                TextColumn::make("category.name")->sortable()->searchable(),
                TextColumn::make("body"),
                ToggleColumn::make("published"),
                TextColumn::make("created_at")
                ->label("Date de creation")
                ->datetime()->sortable(),
                ColorColumn::make('color'),
                TextColumn::make("tags"),
            ])
            ->filters([
                Filter::make("created_at")
                 ->label("Date de creation")
                  ->schema([
                    DatePicker::make("created_at")
                    ->label("selectionne la date :")
                  ])->query(function($query, $data){
                     return $query
                    ->when($data["created_at"], function($q, $date){
                        $q->whereDate("created_at", $date);
                    });
                  }),
                  SelectFilter::make("category_id")
                  ->label("Selectionne la Categorie")
                  ->relationship("category", "name")
                  ->preload()
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
