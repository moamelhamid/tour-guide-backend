<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('UserImporter')
                ->label('Import Student')
                ->icon('heroicon-o-arrow-up-on-square')
                ->form(
                    [
                        FileUpload::make('attachment')
                            ->acceptedFileTypes(['.csv', '.xlsx', '.xls'])
                            ->required(),
                    ]
                ),
        ];
    }
}
