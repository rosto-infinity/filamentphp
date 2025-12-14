<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Checkbox;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Tabs\Tab as TabsTab;
use Filament\Schemas\Schema; // Utilisation de Schema
use Filament\Schemas\Components\Tabs as ComponentsTabs;
use Filament\Forms\Components\Tabs; // Importation de Tabs

use Filament\Forms\Components\Tabs\Tab; // Importation de Tab
use Filament\Schemas\Components\Section as ComponentsSection;
use Illuminate\Support\Str; // Importation de la classe Str pour le slug

class PostForm
{
    /**
     * Configure le schéma du formulaire de publication avec design et sécurité.
     */
    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->components([
                Section::make('Title')
                    ->description('---------------')
                    ->icon(Heroicon::RocketLaunch)
                    ->schema([
                        Group::make()->schema([
                            TextInput::make('title')->rules(['required', 'min:3', 'max:160'])
                                ->validationMessages([
                                    "min" => "Le titre doit avoir au moins  3 caractères",
                                    "required" => "Le titre est oligatoire",
                                    "max" => "Le titre doit avoir au max  160 caractères"
                                ]),
                            TextInput::make('slug')
                                ->rules(['required'])->unique()
                                ->validationMessages([
                                    "unique" => "Le slug doit etre unique",
                                    "required" => "Le slug est oligatoire"
                                ]),
                            Select::make("category_id")
                                ->label("Catégorie")
                                // ->options(Category::all()->pluck("name", "id"))
                                ->relationship("category", "name")
                                ->required()
                                ->searchable()
                                ->preload(),
                            ColorPicker::make('color')->nullable(),
                        ])->columns(2),
                        MarkdownEditor::make('body')->rules(['required']),
                    ]),
                Group::make()->schema([
                    Section::make('Image Upload')
                        ->schema([
                            FileUpload::make('image')->disk('public')->directory('posts')
                                ->rules(['required'])
                                ->maxSize(2048) // 2 Mo
                                ->helperText("Taille maximale : 2Mo. Formats acceptés : .JPG,.JPEG, .PNG, .GIF, .SVG.")
                        ]),
                    Section::make('Meta')
                        ->schema([
                            // TagsInput::make('tags'),
                            Select::make("post_tag")
                                            // ->options(Category::all()->pluck("name", "id"))
                                            ->relationship("tags", "name")
                                            ->required()
                                            ->multiple()
                                            ->searchable() //recherche
                                            ->preload(),
                            Checkbox::make('published'),
                            DatePicker::make('published_at'),
                        ]),
                ]),
            ]);
    }
}

        // return $schema
        // -On utilise la méthode components() sur le schéma fourni
            // ->components([

                // ComponentsTabs::make('Création de l\'article')
                //     ->tabs([
                //         // --- ONGLET 1 : CONTENU PRINCIPAL ---
                //         TabsTab::make('Contenu & Rédaction')
                //             ->icon('heroicon-o-pencil-square')
                //             ->schema([
                //                 ComponentsSection::make('Informations de base')
                //                     ->description('Titre, slug et image principale de l\'article.')
                //                     ->schema([
                //                         TextInput::make("title")
                //                             ->label("Titre")
                //                             ->required()
                //                             ->maxLength(255)
                //                             ->live(onBlur: true)
                //                             ->afterStateUpdated(function (string $operation, $state, $set) {
                //                                 if ($operation === 'create' || $operation === 'edit') {
                //                                     $set('slug', Str::slug($state));
                //                                 }
                //                             })
                //                             ->columnSpanFull(),

                //                         TextInput::make("slug")
                //                             ->label("Slug (URL propre)")
                //                             ->unique(ignoreRecord: true, modifyRuleUsing: function (Unique $rule) {
                //                                 return $rule->where('slug', '!=', null);
                //                             })
                //                             ->maxLength(255),
                                        
                //                         FileUpload::make("image")
                //                             ->label("Image de couverture")
                //                             ->image()
                //                             ->disk("public")
                //                             ->directory("posts")
                //                            ->required()
                //                             ->maxSize(2048) // 2 Mo
                //                             ->helperText("Taille maximale : 2Mo. Formats acceptés : .JPG, PNG, GIF, SVG.")
                //                             ->columnSpanFull(),
                //                     ])
                //                     ->columns(2),

                //                 MarkdownEditor::make('body')
                //                     ->label("Contenu de l'article")
                //                     ->required()
                //                     ->minLength(10)
                //                     ->maxLength(65535)
                //                     ->columnSpanFull(),
                //             ]),

                //         // --- ONGLET 2 : MÉTADONNÉES ET PUBLICATION ---
                //         TabsTab::make('Paramètres & Publication')
                //             ->icon('heroicon-o-adjustments-vertical')
                //             ->schema([
                //                 ComponentsSection::make('Catégorisation et Tags')
                //                     ->schema([
                //                         Select::make("category_id")
                //                             ->label("Catégorie")
                //                             // ->options(Category::all()->pluck("name", "id"))
                //                             ->relationship("category", "name")
                //                             ->required()
                //                             ->searchable()
                //                             ->preload(),

                //                         TagsInput::make("tags")
                //                             ->label("Mots clés (Tags)")
                //                             ->required()
                //                             ->helperText("Ajoutez des mots clés pertinents."),
                //                     ])
                //                     ->columns(2),

                //                 ComponentsSection::make('Options de Publication')
                //                     ->schema([
                //                         ColorPicker::make("color")
                //                          ->required()
                //                             ->label("Couleur principale de l'article"),

                //                         Toggle::make("published")
                //                             ->label("Publier l'article")
                //                             ->default(false),

                //                         DatePicker::make("published_at")
                //                             ->label("Date de publication")
                //                             ->required()
                //                             ->native(false)
                //                             ->default(now()),
                //                     ])
                //                     ->columns(3),
                //             ]),
                //     ])->columnSpanFull(),
            // ]);
//     }
// }
