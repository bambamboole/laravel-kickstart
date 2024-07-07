<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DeleteProjectController
{
    public function __invoke(Request $request, string $id)
    {
        $project = auth()->user()->projects()->where('uuid', $id)->firstOrFail();

        $request->validate([
            'name' => 'required|in:'.$project->name,
        ]);

        $project->delete();

        return Redirect::route('dashboard')->with('success', __('project.delete.success', ['name' => $project->name]));
    }
}
