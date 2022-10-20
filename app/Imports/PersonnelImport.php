<?php

namespace App\Imports;

use Exception;
use App\Models\User;
use App\Models\Personnel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class PersonnelImport implements ToModel, WithValidation, WithHeadingRow, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $username = strtolower($row['firstname'].''.$row['lastname']);
        $data = array(
            'username' => $username,
            'password' => Hash::make($username),
        );

        $user = User::create($data);
        $user->syncRoles(['teacher']);

        return new Personnel([
            'user_id' => $user->id,
            'firstname' => $row['firstname'],
            'middlename' => $row['middlename'],
            'lastname' => $row['lastname'],
            'suffix' => $row['suffix'],
            'gender' => $row['gender'],
            'civilstatus' => $row['civilstatus'],
            'birthdate' => $row['birthdate'],
            'email' => $row['email'],
            'contacts' => $row['contacts'],
            'position' => $row['position'],
            'designation' => $row['designation'],
            'address' => $row['address'],
            'barangay' => $row['barangay'],
            'city' => $row['city'],
            'province' => $row['province'],
            'fb_url' => $row['fb_url'],
            'bio_id' => $row['bio_id'],
            'status' => $row['status'],
            'bio' => $row['bio'],
        ]);
        
    }

    public function rules(): array
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'civilstatus' => 'required',
            'birthdate' => 'required',
            'contacts' => 'required',
            'email' => 'required|email|unique:personnels,email',
            'position' => 'required',
            'designation' => 'required',
            'barangay' => 'required',
            'city' => 'required',
            'bio_id' => 'required|unique:personnels,bio_id',
        ];
    }

    public function batchSize(): int{
        return 1000;
    }
}
