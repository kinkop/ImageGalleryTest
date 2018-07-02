<?php

namespace ImageGallery;

use Illuminate\Database\Eloquent\Model;

class ImageUpload extends Model
{
    protected $fillable = [
        'user_id',
        'mime_type',
        'size',
        'filename'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
