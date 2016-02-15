<?php
namespace App\Models;

/**
 * Class Answers
 * @package App\Models
 * @property string $text
 * @property string $updated_at
 * @property string $created_at
 */
class Answer extends Base
{
    protected $attributes = [
        'text' => '',
        'author' => '',
        'active' => true,
    ];

    protected $fillable = ['text', 'author', 'active'];

    public function setTextAttribute($text)
    {
        $this->attributes['text'] = strip_tags($text);
    }

    # mutators

    public function setActiveAttribute($value)
    {
        $this->attributes['active'] = boolval($value);
    }
}
