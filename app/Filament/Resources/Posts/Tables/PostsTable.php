<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Toggle;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ReplicateAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\View;
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
                TextColumn::make('id')
                ->label('ID')->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make("tags.name")
                ->label("Etiquette")->toggleable(isToggledHiddenByDefault:true),
                ImageColumn::make("image")
                ->circular()
                ->disk("public"),
                TextColumn::make("title")->sortable()->searchable(),
                TextColumn::make("slug")->sortable()->searchable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make("category.name")->sortable()->searchable(),
                TextColumn::make("body")->toggleable(),
                ToggleColumn::make("published")->toggleable(),
                TextColumn::make("created_at")
                ->label("Date de creation")
                ->datetime()->sortable(),
                ColorColumn::make('color')->toggleable(),
                TextColumn::make('actions')
                ->label('Boutons d\'actions')
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
                // RestoreAction::make(),
                // ImportAction::make(),
                ReplicateAction::make(),
               ViewAction::make(),
                DeleteAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
