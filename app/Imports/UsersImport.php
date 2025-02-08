<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        Log::info('Processing row: ', $row); // Add this line
        // Adjust the key if your Excel header is different (e.g., 'Name')
        $nameKey = 'name'; // Change to 'Name' if needed
        $name = isset($row[$nameKey]) ? trim($row[$nameKey]) : '';

        if (!empty($name)) {
            $password = random_int(10000000, 99999999);
            return new User([
                'name'     => $name,
                'password' => Hash::make($password),
                // Add other required fields here
            ]);
        }

        return null;
    }
}
