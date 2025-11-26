<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;


class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               TextInput::make("title")
               ->required(),
               TextInput::make("slug"),
               Select::make("category_id")
               ->label("Category")
               ->options(Category::all()->pluck("name", "id"))
               ->required(),
               ColorPicker::make("color"),
               MarkdownEditor::make('body')
               ->required(),
               FileUpload::make("image")
               ->image()
               ->disk("public")
               ->directory("posts")
               ->nullable(),
                TagsInput::make("tags")
                ->required(),            
                Toggle::make("published"), 
                DatePicker::make("published_at"),           
            ]);
    }
}
