<?php

namespace App\Http\Requests;

use App\Models\Driver;
use Illuminate\Foundation\Http\FormRequest;

class AssignDriverRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            Driver::LAT => 'required|numeric|between:-90,90',
            Driver::LON => 'required|numeric|between:-180,180',
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
}
