<?php
declare(strict_types=1);

namespace common\models\Works\Processors;

use common\models\WorkLogs\WorkLog;
use GuzzleHttp\Client;
use Throwable;
use yii\base\Model;

/**
 * Class UrlMonitorProcessor
 *
 * @author snowball <snow-snowball@yandex.ru>
 * @package common\models\Works\Processors
 */
class UrlMonitorProcessor extends Model implements WorkProcessorInterface
{
    private static Client|null $client = null;

    public function process(WorkLog $job): void
    {
        try {
            $httpClient = $this->getHttpClient();
            $response = $httpClient->request('GET', $job->getDetails()->url);
            dd($response);
        } catch (Throwable $e) {

        }
    }

    private function getHttpClient(): \GuzzleHttp\Client
    {
        if (self::$client === null) {
            self::$client = new Client();
        }

        return self::$client;
    }
}