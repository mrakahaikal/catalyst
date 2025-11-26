<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Catalog\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->afterStateUpdatedJs(<<<'JS'
                        $set('slug', ($state ?? '')
                            .toString() // Make sure the input is string
                            .normalize("NFD") // Pisahkan huruf dengan aksen
                            .replace(/[\u0300-\u036f]/g, "") // Hapus aksen
                            .toLowerCase() // Ubah ke huruf kecil
                            .trim() // Hapus spasi di awal dan akhir
                            .replace(/[^a-z0-9\s-]/g, "") // Hapus karakter non-alfanumerik
                            .replace(/\s+/g, "-") // Ganti spasi dengan '-'
                            .replace(/-+/g, "-")) // Hapus duplikasi '-'
                        JS),
                TextInput::make('slug')
                    ->required(),
                Select::make('parent_id')
                    ->relationship('parent', 'name')
                    ->searchable(),
                Textarea::make('description'),
                TextInput::make('position'),
                ToggleButtons::make('is_visible')
                    ->boolean(),
            ]);
    }
}
