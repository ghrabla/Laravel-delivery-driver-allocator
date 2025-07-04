<?php

namespace App\Http\Requests;

use App\Models\Restaurant;
use Illuminate\Foundation\Http\FormRequest;

class AssignDriverRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            Restaurant::LAT => 'required|numeric|between:-90,90',
            Restaurant::LON => 'required|numeric|between:-180,180',
            Restaurant::ID => 'required|uuid',
        ];
    }

    public function latitude(): float
    {
        return (float) $this->input(Restaurant::LAT);
    }

    public function longitude(): float
    {
        return (float) $this->input(Restaurant::LON);
    }

    public function restaurantId(): string
    {
        return (string) $this->input(Restaurant::ID);
    }
}
