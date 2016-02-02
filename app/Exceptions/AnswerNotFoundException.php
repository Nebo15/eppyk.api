<?php
namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AnswerNotFoundException extends NotFoundHttpException
{
    public function __construct()
    {
        parent::__construct('answer_not_found');
    }
}
