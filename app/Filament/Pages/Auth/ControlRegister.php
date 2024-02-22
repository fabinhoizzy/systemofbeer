<?php

namespace App\Filament\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Events\Auth\Registered;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register;

class ControlRegister extends Register
{
    public ?array $data = [];
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome Completo')
                    ->required()
                    ->maxLength(255),

                TextInput::make('document')
                    ->label('CPF')
                    ->required()
                    ->mask('999.999.999-99')
                    ->maxLength(14),

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

             /*   TextInput::make('password_confirmation')
                    ->label('Confirme sua senha')
                    ->required()
                    ->password()
                    ->confirmed()
                    ->maxLength(16),*/

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

    #[\Override]
    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);

            $this->data = $this->form->getState();

            if(!$this->checkIfCustomerCanRegister()) {
                Throw new \DomainException("Infelizmente, você não tem idade");
            }

        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/register.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/register.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/register.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        } catch (\DomainException $domainException) {
            Notification::make()
                ->title('Erro ao realizar cadastro')
                ->body($domainException->getMessage())
                ->warning()
                ->send();
            return null;
        }

        $user = $this->getUserModel()::create($this->data);

        event(new Registered($user));

        $this->sendEmailVerificationNotification($user);

        Filament::auth()->login($user);

        session()->regenerate();

        return app(RegistrationResponse::class);
    }

    private function checkIfCustomerCanRegister(): bool
    {
        return (now()->diffInDays($this->data['birthdate'])/ 365) >= 18;
    }
}
