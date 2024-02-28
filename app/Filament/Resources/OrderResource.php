<?php
declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $modelLabel = 'Venda';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//                Forms\Components\TextInput::make('user_id')
//                    ->numeric(),

            Wizard::make([
                Wizard\Step::make('Itens')
                ->schema([
                    Repeater::make('items')
                        ->schema([
                            Grid::make()
                                ->schema([
                                    Select::make('product')
                                        ->label('Item')
                                        ->options(Product::all()->pluck('name', 'id'))
                                        ->searchable()
                                        ->preload()
                                        ->native(false)
                                        ->required()
                                        ->columns(2),

                                    TextInput::make('quantity')
                                        ->label('Quantidade')
                                        ->numeric()
                                        ->default(1)
                                        ->columns(2),
                                ])->columnSpanFull(),

                        ])->columnSpanFull(),

                ]),
                Wizard\Step::make('Pagamentos')
                ->schema([


                ]),
            ]),



                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric()
                    ->columnSpanFull()

//                Forms\Components\TextInput::make('status')
//                    ->required()
//                    ->maxLength(255)
//                    ->default('PENDING')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
