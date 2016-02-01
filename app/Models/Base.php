<?php
namespace App\Models;

use App\Exceptions\IdNotFoundException;
use Illuminate\Contracts\Validation\ValidationException;
use Jenssegers\Mongodb\Model as Eloquent;

/**
 * Class Base
 * @package App\Models
 * @property string $_id
 */
abstract class Base extends Eloquent
{
    const PRIMARY_KEY = '_id';
    protected $connection = 'mongodb';
    protected $validation_rules = [];

    public function getId()
    {
        return (string)$this->{self::PRIMARY_KEY};
    }

    public function isNew()
    {
        return empty($this->getId());
    }

    public function createId()
    {
        $this->{self::PRIMARY_KEY} = new \MongoId();
    }

    /**
     * @param array $options
     * @return $this
     */
    public function save(array $options = [])
    {
        $this->validate($this->getDirty());

        return parent::save($options) ? $this : false;
    }

    public static function findById($id)
    {
        if (empty($id)) {
            throw new IdNotFoundException;
        }

        return self::where(self::PRIMARY_KEY, '=', $id)->firstOrFail();
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     * SUGAR
     */
    public function setAttribute($key, $value)
    {
        parent::setAttribute($key, $value);

        return $this;
    }

    /**
     * @param array $values
     * @param array $validation_rules
     * @throw ValidationException
     * @return $this
     */
    protected function validate(array $values, $validation_rules = [])
    {
        $validation_rules = $validation_rules ? $validation_rules : $this->validation_rules;
        if ($validation_rules) {
            $validator = \Illuminate\Support\Facades\Validator::make($values, $validation_rules);
            if (!$validator->passes()) {
                throw new ValidationException($validator);
            }
        }

        return $this;
    }
}
