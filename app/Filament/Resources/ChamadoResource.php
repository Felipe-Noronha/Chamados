<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChamadoResource\Pages;
use App\Models\Chamado;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;


class ChamadoResource extends Resource
{
    protected static ?string $model = Chamado::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nome_cliente')
                    ->required()
                    ->disabledOn('edit'),

                TextInput::make('email_cliente')
                    ->email()
                    ->required()
                    ->disabledOn('edit'),

                TextInput::make('assunto')
                    ->required()
                    ->disabledOn('edit'),

                Textarea::make('mensagem')
                    ->required()
                    ->disabledOn('edit')
                    ->columnSpanFull(),

                Select::make('status')
                    ->options([
                        'Aberto' => 'Aberto',
                        'Em Andamento' => 'Em Andamento',
                        'Fechado' => 'Fechado',
                    ])
                    ->required(),

                Select::make('prioridade')
                    ->options([
                        'Baixa' => 'Baixa',
                        'Média' => 'Média',
                        'Alta' => 'Alta',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
       return $table
        ->columns([
            TextColumn::make('assunto')->searchable(),
            TextColumn::make('nome_cliente')->searchable(),
            TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                'Aberto' => 'warning',
                'Em Andamento' => 'primary',
                'Fechado' => 'success',
            }),
            TextColumn::make('prioridade'),
            TextColumn::make('created_at')->dateTime('d/m/Y H:i')->sortable(),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            // Tables\Actions\BulkActionGroup::make([
            //     Tables\Actions\DeleteBulkAction::make(),
            // ]),
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
            'index' => Pages\ListChamados::route('/'),
            'create' => Pages\CreateChamado::route('/create'),
            'edit' => Pages\EditChamado::route('/{record}/edit'),
        ];
    }
}
