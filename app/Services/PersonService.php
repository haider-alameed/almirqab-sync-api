<?php

namespace App\Services;



use App\Models\Person;
use App\Support\MongoObjectId;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
class PersonService
{
    public function __construct()
    {
    }


    public function upsertFromMurqaib(array $p,int $schoolId): Person
    {
        $externalId = (int) Arr::get($p, 'id', 0);

        if ($externalId <= 0) {
            throw new InvalidArgumentException('Person external id (id) is missing from API payload.');
        }

        // Find by external id (almirqab_id)
        $person = Person::firstOrNew(['almirqab_id' => $externalId]);

        // mongo_id is NOT nullable in your migration, so always ensure it exists
        $person->mongo_id ??= MongoObjectId::generate();

        // Normalize values (avoid "" breaking unique code, and keep types clean)
        $code = trim((string) Arr::get($p, 'code', ''));
        $code = $code !== '' ? $code : null;

        $phone = trim((string) Arr::get($p, 'phone', ''));
        $phone = $phone !== '' ? $phone : null;

        $address = trim((string) Arr::get($p, 'address', ''));
        $address = $address !== '' ? $address : null;

        $dob = Arr::get($p, 'date_of_birth');
        $dob = !empty($dob) ? Carbon::parse($dob)->toDateString() : null;

        $lat = Arr::get($p, 'latitude');
        $lng = Arr::get($p, 'longitude');

        $person->fill([
            'full_name'     => Arr::get($p, 'full_name', ''), // NOT nullable in DB
            'school_id' => $schoolId,
            'date_of_birth' => $dob,
            'address'       => $address,
            'phone'         => $phone,
            'code'          => $code,
            'type'          => (int) Arr::get($p, 'type', 0),
            'gender'        => (int) Arr::get($p, 'gender', 0),
            'test'          => (bool) Arr::get($p, 'test', false),
            'latitude'      => is_numeric($lat) ? (float) $lat : 0,
            'longitude'     => is_numeric($lng) ? (float) $lng : 0,
        ]);

        $person->save();

        return $person;
    }
}
