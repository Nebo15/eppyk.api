<?php
namespace App\Models;

use App\Exceptions\AnswerNotFoundException;

/**
 * Class Locale
 * @package App\Models
 * @property string $title
 * @property string $code
 * @property bool $active
 * @property bool $default
 * @property Answer[] $answers
 * @property string $updated_at
 * @property string $created_at
 */
class Locale extends Base
{
    protected $collection = 'locales';

    protected $fillable = [
        'title',
        'code',
        'active',
        'default'
    ];

    protected $attributes = [
        'title' => '',
        'code' => '',
        'active' => 1,
        'default' => 0,
        'answers' => []
    ];

    public function answers()
    {
        return $this->embedsMany('App\Models\Answer');
    }

    public function addAnswer($data)
    {
        $answer = ($data instanceof Answer) ? $data : new Answer($data);
        $this->validate($answer->toArray(), $answer->getValidationRules());
        $this->setAnswer($answer);

        return $this;
    }

    public function getAnswer($id)
    {
        $answer = $this->answers()->where(self::PRIMARY_KEY, '=', $id)->first();
        if (!$answer) {
            throw new AnswerNotFoundException;
        }

        return $answer;
    }

    public function setAnswer($data)
    {
        $answer = ($data instanceof Answer) ? $data : new Answer($data);
        $answer->updateTimestamps();
        $this->answers()->associate($answer);
        return $answer;
    }

    public function deleteAnswer($id)
    {
        $this->answers()->dissociate($this->getAnswer($id));

        return $this;
    }
}
