<?php

namespace Modules\School\Repositories;

use App\Support\Modules\BaseModuleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\School\Models\AcademicProgram;

class AcademicProgramRepository extends BaseModuleRepository
{
    public function __construct(AcademicProgram $model)
    {
        parent::__construct($model);
    }

    public function publicItems(int $limit = 6, array $filters = []): Collection
    {
        return $this->filteredQuery($filters)
            ->where('is_public', true)
            ->limit($limit)
            ->get();
    }

    public function paginate(int $perPage = 12, array $filters = []): LengthAwarePaginator
    {
        return $this->filteredQuery($filters)->paginate($perPage)->withQueryString();
    }

    public function create(array $attributes): Model
    {
        $attributes['slug'] = $this->resolveUniqueSlug($attributes['slug'] ?? null, $attributes['name'] ?? null);

        return parent::create($attributes);
    }

    public function update(int|string $id, array $attributes): Model
    {
        $record = $this->findOrFail($id);

        if (array_key_exists('slug', $attributes) || array_key_exists('name', $attributes)) {
            $attributes['slug'] = $this->resolveUniqueSlug(
                $attributes['slug'] ?? $record->slug,
                $attributes['name'] ?? $record->name,
                (int) $record->id,
            );
        }

        return parent::update($id, $attributes);
    }

    public function stats(array $filters = []): array
    {
        $query = $this->filteredQuery($filters);

        return [
            'total' => (clone $query)->count(),
            'published' => (clone $query)->where('is_public', true)->count(),
            'draft' => (clone $query)->where('status', 'draft')->count(),
            'admission_open' => (clone $query)->where('admission_open', true)->count(),
        ];
    }

    protected function filteredQuery(array $filters = []): Builder
    {
        $query = $this->model->newQuery()
            ->orderBy('sort_order')
            ->latest('updated_at');

        if (($filters['q'] ?? null) !== null && $filters['q'] !== '') {
            $term = trim((string) $filters['q']);
            $query->where(function (Builder $inner) use ($term): void {
                $inner->where('name', 'like', '%'.$term.'%')
                    ->orWhere('headline', 'like', '%'.$term.'%')
                    ->orWhere('description', 'like', '%'.$term.'%');
            });
        }

        if (in_array($filters['status'] ?? null, ['draft', 'active', 'archived'], true)) {
            $query->where('status', $filters['status']);
        }

        if (in_array($filters['level'] ?? null, ['maternelle', 'primaire', 'secondaire', 'professionnel'], true)) {
            $query->where('level', $filters['level']);
        }

        if (($filters['admission_open'] ?? null) !== null && $filters['admission_open'] !== '') {
            $query->where('admission_open', filter_var($filters['admission_open'], FILTER_VALIDATE_BOOLEAN));
        }

        return $query;
    }

    protected function resolveUniqueSlug(?string $slug, ?string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($slug ?: ($name ?: Str::uuid()->toString()));
        $candidate = $base !== '' ? $base : Str::uuid()->toString();
        $counter = 1;

        while ($this->model->newQuery()
            ->where('slug', $candidate)
            ->when($ignoreId !== null, fn (Builder $q): Builder => $q->whereKeyNot($ignoreId))
            ->exists()) {
            $candidate = sprintf('%s-%d', $base, $counter++);
        }

        return $candidate;
    }
}
