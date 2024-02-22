<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register;

class ControlRegister extends Register
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome Completo')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email()
                    ->maxLength(255),

                TextInput::make('password')
                    ->label('Digite sua senha')
                    ->required()
                    ->password()
                    ->maxLength(16),

                TextInput::make('password_confirmation')
                    ->label('Confirme sua senha')
                    ->required()
                    ->password()
                    ->confirmed()
                    ->maxLength(16),

                TextInput::make('phone')
                    ->label('Telefone/Whatsapp')
                    ->mask('(99) 9 9999-9999')
                    ->required()
                    ->maxLength(16),

                DateTimePicker::make('birthdate')
                    ->label('Data de Nascimento')
                    ->required()
            ]);

    }
}
