<?php declare(strict_types=1);

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use EagerLoadPivotTrait, HasFactory, HasUuidColumn, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)
            ->using(ProjectMember::class)
            ->withPivot('role_id')
            ->withTimestamps();
    }

    public function hasProjectPermission(Project|string|int $project, string|\BackedEnum $permission): bool
    {
        if (is_string($project)) {
            $projectId = Project::query()->where('uuid', $project)->limit(1)->value('id');
        } elseif (is_int($project)) {
            $projectId = $project;
        } else {
            $projectId = $project->id;
        }
        $role = Role::query()
            ->addSelect(
                [
                    'id' => ProjectMember::query()
                        ->select('role_id')
                        ->where('user_id', $this->id)
                        ->where('project_id', $projectId),
                ]
            )->first();

        if (! $role instanceof Role) {
            return false;
        }

        return in_array($permission instanceof \BackedEnum ? $permission->value : $permission, $role->permissions);
    }
}
