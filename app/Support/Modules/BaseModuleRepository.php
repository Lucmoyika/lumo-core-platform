<?php

namespace App\Support\Modules;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseModuleRepository
{
    public function __construct(protected Model $model) {}

    public function publicItems(int $limit = 6): Collection
    {
        return $this->model->newQuery()
            ->where('is_public', true)
            ->orderBy('sort_order')
            ->latest('updated_at')
            ->limit($limit)
            ->get();
    }

    public function paginate(int $perPage = 12): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->orderBy('sort_order')
            ->latest('updated_at')
            ->paginate($perPage);
    }

    public function findOrFail(int|string $id): Model
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $attributes): Model
    {
        return $this->model->newQuery()->create($attributes);
    }

    public function update(int|string $id, array $attributes): Model
    {
        $record = $this->findOrFail($id);
        $record->fill($attributes)->save();

        return $record->refresh();
    }

    public function delete(int|string $id): void
    {
        $this->findOrFail($id)->delete();
    }

    public function stats(): array
    {
        $query = $this->model->newQuery();

        return [
            'total' => (clone $query)->count(),
            'published' => (clone $query)->where('is_public', true)->count(),
            'draft' => (clone $query)->where('status', 'draft')->count(),
        ];
    }
}
