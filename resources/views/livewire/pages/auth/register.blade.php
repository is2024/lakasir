<?php

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new
#[Layout('livewire.components.layouts.guest')]
class extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Akun pemilik')
                        ->schema([
                            TextInput::make('full_name')
                                ->label('Nama Lengkap')
                                ->string()
                                ->required(),
                            TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->required(),
                            TextInput::make('password')
                                ->password()
                                ->required()
                                ->rules(['confirmed']),
                            TextInput::make('password_confirmation')
                                ->password(),
                        ])
                        ->columns(1)
                        ->icon('heroicon-o-user'),
                    Wizard\Step::make('Detail Toko')
                        ->schema([
                            TextInput::make('store_name')
                                ->label('Nama Toko')
                                ->string()
                                ->required(),
                            TextInput::make('store_address')
                                ->label('Alamat Toko')
                                ->string()
                                ->required(),
                            TextInput::make('store_phone')
                                ->label('Nomor Telepon')
                                ->string()
                                ->required(),
                        ])
                        ->icon('heroicon-o-shopping-bag'),
                    Wizard\Step::make('Domain Toko')
                        ->schema([
                            TextInput::make('domain')
                                ->label('Domain')
                                ->rules(['unique:tenants,id'])
                                ->live(debounce: 500)
                                ->suffix('.'.config('tenancy.central_domains')[0]),
                        ])
                        ->icon('heroicon-o-globe-alt'),
                ])
                    ->submitAction(new HtmlString(
                        Blade::render(<<<'BLADE'
                                    <x-filament::button
                                        type="submit"
                                        size="sm"
                                        wire:click="create"
                                    >
                                        Submit
                                    </x-filament::button>
                                  BLADE))),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        dd($this->form->getState());
    }
}

?>

<div class="max-w-xl mx-auto flex justify-center items-center h-screen">
  <div>
    <div class="flex justify-center items-center my-10">
      <img src="{{ asset('assets/logo/image.png') }}" class="w-20 h-24" alt="Logo">
    </div>
    <div class="w-full">
      {{ $this->form }}
    </div>
  </div>
</div>