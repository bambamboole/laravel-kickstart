<?php declare(strict_types=1);

namespace App\Http\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'alpha_dash', 'max:255', 'unique:projects,name'],
        ];
    }
}
