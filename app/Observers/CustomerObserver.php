<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\PanelTypeEnum;
use App\Mail\NewCustomerMail;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        $password = Str::random(8);

        $user = User::create([
            'name' => $customer->name,
            'email' => $customer->email,
            'panel' => PanelTypeEnum::APP,
            'password' => bcrypt($password),
        ]);

        $customer->user_id = $user->id;
        $customer->saveQuietly();

        Mail::to($customer->email)->send(new NewCustomerMail($customer, $password));
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "deleted" event.
     */
    public function deleted(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "restored" event.
     */
    public function restored(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     */
    public function forceDeleted(Customer $customer): void
    {
        //
    }
}
