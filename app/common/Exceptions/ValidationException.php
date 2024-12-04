<?php
declare(strict_types=1);

namespace common\Exceptions;

use Exception;
use Throwable;
use yii\base\Model;

/**
 * Class ValidationException
 *
 * @author snowball <snow-snowball@yandex.ru>
 * @package common\Exceptions
 */
class ValidationException extends Exception
{
    public function __construct(private readonly Model $model, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
