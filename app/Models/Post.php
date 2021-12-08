<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;

    const TYPE_POST = 1;
    const TYPE_PAGE = 2;

    const COMMENT_CLOSED = 1;
    const COMMENT_OPENED = 2;

    protected $casts = [
        'date' => 'date',
        'status' => 'integer',
        'post_type' => 'integer',
        'comment_status' => 'integer',
        'comment_count' => 'integer'
    ];

    public function scopeContent($query)
    {
        $query->select('id','user_id','author_name','title','slug','published_date','featured_img','excerpt','content','comment_count','status','updated_at');
    }

    public function scopeType($query, $type)
    {
        $query->where('post_type', $type);
    }

    public function scopePublished($query, $type)
    {
        $query->where('status',$this->STATUS_PUBLISHED);
    }

    public function scopeFromAuthor($query, $author_name)
    {
        $query->where('author_name', $author_name);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
