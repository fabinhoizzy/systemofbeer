<?php
declare(strict_types=1);

namespace App\Filament\Pages\Auth;

use App\Models\Customer;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register;
use Illuminate\Support\Str;

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

                TextInput::make('mobile')
                    ->label('Telefone/Whatsapp')
                    ->mask('(99) 9 9999-9999')
                    ->required()
                    ->maxLength(16),

                DatePicker::make('birthdate')
                    ->label('Data de Nascimento')
                    ->format('d/m/Y')
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

        Customer::create($this->data);

        Notification::make()
            ->title('Cadastro Realizado!')
            ->body("Enviamos um email para {$this->data['email']} com seus dados de acesso")
            ->success()
            ->send();

        $this->reset();

        return null;
    }

    private function checkIfCustomerCanRegister(): bool
    {
        return now()->parse($this->data['birthdate'])->age >= 18;
    }
}
