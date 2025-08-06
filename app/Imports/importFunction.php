<?php

namespace App\Imports;

use App\Models\importfun;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class importFunction implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Skip header row (if necessary)
        foreach ($rows->skip(1) as $row) {
            importfun::create([
                'name' => $row[0],
                'email' => $row[1],
                'phone' => $row[2], // Encrypt the password
            ]);
        }
    }
}
