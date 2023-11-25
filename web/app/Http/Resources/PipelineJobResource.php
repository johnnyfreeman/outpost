<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PipelineJobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'event' => PipelineEventResource::make($this->whenLoaded('event')),
            'step' => PipelineStepResource::make($this->whenLoaded('step')),
            'agent' => AgentResource::make($this->whenLoaded('agent')),
            'output' => $this->output,
            'exit_code' => $this->exit_code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'reserved_at' => $this->reserved_at,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
        ];
    }
}
