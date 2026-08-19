<?php

namespace App\Filament\Resources\Exercises\Schemas;

use App\Models\Exercise;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExerciseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                CheckboxList::make('categories')
                    ->options(fn () => Exercise::categoryOptions())
                    ->columns(2),
                FileUpload::make('image_path')
                    ->label('Photo')
                    ->image()
                    ->maxSize(2048)
                    ->disk('public')
                    ->directory('exercise-images'),
            ]);
    }
}
