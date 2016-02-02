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
    ];

    protected $fillable = ['text'];

    public function getValidationRules()
    {
        return [
            'text' => 'string',
        ];
    }

    public function setTextAttribute($text)
    {
        $this->attributes['text'] = strip_tags($text);
    }
}
