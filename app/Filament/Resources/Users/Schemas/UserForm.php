<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('username')
                    ->required()
                    ->alphaDash()
                    ->minLength(3)
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Phone number')
                    ->tel()
                    ->rule('regex:/^\+?[0-9]{7,15}$/')
                    ->unique(ignoreRecord: true)
                    ->maxLength(32),
                TextInput::make('email')
                    ->label('Email address (optional)')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation) => $operation === 'create')
                    ->minLength(8)
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->helperText('Leave blank to keep the current password.'),
                Toggle::make('is_admin')
                    ->label('Admin')
                    ->helperText('Can sign in to this admin panel.'),
                DateTimePicker::make('email_verified_at'),
                Select::make('locale')
                    ->options(['en' => 'English', 'fa' => 'Persian'])
                    ->native(false),
                Select::make('date_format')
                    ->options(['gregorian' => 'Gregorian', 'jalali' => 'Jalali (Persian)'])
                    ->default('gregorian')
                    ->required()
                    ->native(false),
                Select::make('weight_unit')
                    ->options(['kg' => 'Kilograms (kg)', 'lb' => 'Pounds (lb)'])
                    ->default('kg')
                    ->required()
                    ->native(false),
                Select::make('theme')
                    ->options([
                        'default' => 'Default',
                        'emerald' => 'Emerald',
                        'sunset' => 'Sunset',
                        'ocean' => 'Ocean',
                    ])
                    ->default('default')
                    ->required()
                    ->native(false),
            ]);
    }
}
