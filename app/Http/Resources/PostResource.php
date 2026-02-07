<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'excerpt' => \Str::limit($this->body, 200),
            'image_url' => $this->getImageUrl(),
            'created_at' => $this->created_at->format('d.m.Y H:i'),
            'created_at_human' => $this->created_at->diffForHumans(),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'avatar_url' => $this->user->getAvatarUrl(),
                'initial' => $this->user->getInitial(),
            ],
            'likes_count' => $this->whenCounted('likes', $this->likes_count ?? 0),
            'comments_count' => $this->whenCounted('comments', $this->comments_count ?? 0),
            'is_liked' => Auth::check() ? $this->isLikedBy(Auth::user()) : false,
        ];
    }
}
