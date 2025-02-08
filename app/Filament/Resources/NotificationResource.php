<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationResource\Pages;
use App\Models\Notification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;

class NotificationResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Optionally you can keep the hidden field for UI purposes


                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('message')
                    ->label('Message')
                    ->required(),

                Forms\Components\TextInput::make('link')
                    ->label('Link')
                    ->url()
                    ->nullable(),

                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name', function (Builder $query) {
                        // Get the guard from Filament configuration (defaulting to 'web' if not set)

                        return $query->where('dep_id', Auth::guard('web')->user()?->dep_id);
                    })
                    ->required(),

                Forms\Components\Hidden::make('dep_id')
                    ->default(Auth::guard('web')->user()?->dep_id),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->filters([
                QueryBuilder::make()
                    ->label('Department Filter') // Optional: Give the filter a name
                    ->query(function (Builder $query) {
                        // Apply the filtering logic based on dep_id
                        if ($user = Auth::guard('web')->user()) {
                            $query->where('dep_id', $user->dep_id);
                        } else {
                            $query->whereRaw('1 = 0');
                        }
                    })
            ], layout: FiltersLayout::AboveContent)
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('message')
                    ->label('Message')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('link')
                    ->label('Link')
                    ->url(fn(Notification $record) => $record->link)
                    ->sortable()
                    ->searchable(),

                BooleanColumn::make('is_read')
                    ->label('Is Read')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // This method forces the admin_id to be set before creating a record.
    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->guard('web')->user();
        if ($user) {
            $data['dep_id'] = $user->dep_id;
        }
        return $data;
    }


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListNotifications::route('/'),
            'create' => Pages\CreateNotification::route('/create'),
            'view'   => Pages\ViewNotification::route('/{record}'),
            'edit'   => Pages\EditNotification::route('/{record}/edit'),
        ];
    }
}
