<?php

namespace App\Filament\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImporter implements ToModel, WithHeadingRow
{
    use Importable;

    /**
     * @param array $row
     * 
     * @return illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $password = random_int(10000000, 99999999);
        return new User([
            'name' => $row['name'],
            'password' => Hash::make($password),
        ]);
    }
}
