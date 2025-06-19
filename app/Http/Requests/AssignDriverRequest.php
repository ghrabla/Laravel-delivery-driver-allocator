<?php

namespace App\Http\Requests;

use App\Models\Driver;
use App\Models\Restaurant;
use Illuminate\Foundation\Http\FormRequest;

class AssignDriverRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            Driver::LAT => 'required|numeric|between:-90,90',
            Driver::LON => 'required|numeric|between:-180,180',
            Restaurant::ID => 'required|uuid|exists:' . Restaurant::TABLE . ',' . Restaurant::ID,
        ];
    }

    public function latitude(): float
    {
        return (float) $this->input(Driver::LAT);
    }

    public function longitude(): float
    {
        return (float) $this->input(Driver::LON);
    }

    public function restaurantId(): string
    {
        return (string) $this->input(Restaurant::ID);
    }
}
