<?php

namespace Modules\School\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcademicProgramResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'headline' => $this->headline,
            'description' => $this->description,
            'status' => $this->status,
            'audience' => $this->audience,
            'capabilities' => $this->capabilities,
            'metrics' => $this->metrics,
            'is_public' => $this->is_public,
            'sort_order' => $this->sort_order,
            'settings' => $this->settings,
            'updated_at' => $this->updated_at,
        ];
    }
}
