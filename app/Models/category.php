<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug'];

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blogs::class);
    }

    public function publishedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Blogs::class)
            ->where('active', '=', 1)
            ->whereDate('published_at', '<', Carbon::now());
    }
}