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

    public function toApiView()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->title,
            'code' => $this->code,
            'answers' => $this->answersToApiView(),
        ];
    }

    public function answersToApiView()
    {
        $return = [];
        /** @var Answer $answer */
        foreach ($this->answers()->get() as $answer) {
            $return[] = [
                'id' => $answer->getId(),
                'text' => $answer->text,
            ];
        }

        return $return;
    }

    public function answers()
    {
        return $this->embedsMany('App\Models\Answer');
    }

    /**
     * @param $locale
     * @return Locale
     */
    public static function findByLocale($locale)
    {
        return self::where(['code' => $locale])->first();
    }

    /**
     * @param $id
     * @return Locale
     */
    public static function findByAnswerId($id)
    {
        return self::where('answers.' . self::PRIMARY_KEY, $id)->firstOrFail();
    }

    public function addAnswer($data)
    {
        $this->setAnswer(($data instanceof Answer) ? $data : new Answer($data));

        return $this;
    }

    public function getAnswer($id)
    {
        $answer = $this->answers()->where(self::PRIMARY_KEY, $id)->first();
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

    # mutators

    public function setActiveAttribute($value)
    {
        $this->attributes['active'] = boolval($value);
    }

    public function setDefaultAttribute($value)
    {
        $this->attributes['default'] = boolval($value);
    }
}
