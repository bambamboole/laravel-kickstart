<?php declare(strict_types=1);

namespace App\Http\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;

class InviteProjectMemberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:strict'],
            'role_uuid' => ['required', 'uuid', 'exists:roles,uuid'],
        ];
    }
}
