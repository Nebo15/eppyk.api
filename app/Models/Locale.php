<?php
namespace App\Models;

use App\Exceptions\AnswerNotFoundException;
use Carbon\Carbon;

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

    public function toApiView($with_answers = true, $answers_page = null, $answers_size = null)
    {
        $data = [
            'id' => $this->getId(),
            'title' => $this->title,
            'code' => $this->code,
        ];
        if ($with_answers and 'false' != $with_answers) {
            $data['answers'] = $this->answersToApiView(null, $answers_page, $answers_size);
        }

        return $data;
    }

    /**
     * @param int $page
     * @param int $size
     * @param null $updated_after
     * @param null $updated_before
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAnswersPaginated($page = 1, $size = 30, $updated_after = null, $updated_before = null)
    {
        $queryBuilder = $this->answers()->filter(function ($item) use ($updated_after, $updated_before) {
            $bool = true;
            if ($updated_after) {
                $bool = data_get($item, 'updated_at')->gt(new Carbon($updated_after));
            }
            if ($updated_before) {
                $bool = data_get($item, 'updated_at')->lte(new Carbon($updated_before));
            }

            return $bool;
        });
        $queryBuilder = $queryBuilder->where('active', true);

        return $this->answersToApiView($size ? $queryBuilder->forPage($page, $size) : $queryBuilder);
    }

    public function answersToApiView($answers = null, $page = null, $limit = null)
    {
        $return = [];

        $answers = $answers ?: $this->answers()->where('active', true)->forPage($page, $limit);
        if ($answers) {
            foreach ($answers as $answer) {
                $return[] = [
                    'id' => $answer->getId(),
                    'text' => $answer->text,
                ];
            }
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
        return self::where(['code' => $locale])->firstOrFail();
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
