<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BrandForm
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
                FileUpload::make('logo')
                    ->required(),
                Textarea::make('description'),
                TextInput::make('website'),
                ToggleButtons::make('is_visible')
                    ->boolean(),

            ]);
    }
}
