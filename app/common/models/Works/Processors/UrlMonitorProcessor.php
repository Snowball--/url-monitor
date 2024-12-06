<?php
declare(strict_types=1);

namespace common\models\Works\Processors;

use common\Exceptions\ValidationException;
use common\models\Jobs\JobInterface;
use common\models\WorkLogs\LogDetailInterface;
use common\models\WorkLogs\UrlLogDetail;
use common\models\WorkLogs\WorkLog;
use common\models\WorkLogs\WorkLogState;
use common\Services\JobService;
use common\Services\Queue\QueueService;
use common\Services\WorkLogService;
use console\models\Forms\AddWorkLogForm;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\log\Logger;

/**
 * Class UrlMonitorProcessor
 *
 * @author snowball <snow-snowball@yandex.ru>
 * @package common\models\Works\Processors
 */
class UrlMonitorProcessor extends Model implements JobProcessorInterface
{
    private static Client|null $client = null;

    public function __construct(
        private readonly WorkLogService $workLogService,
        private readonly QueueService $queueService,
        $config = []
    ) {
        parent::__construct($config);
    }

    /**
     * @throws GuzzleException
     * @throws Throwable
     */
    public function process(JobInterface $job): WorkLog
    {
        $response = null;

        try {
            $httpClient = $this->getHttpClient();
            $params = $job->getParams();
            $url = $params['details']['url'] ?? null;

            if (!$url) {
                throw new \DomainException("Undefined detail 'url'");
            }

            $response = $httpClient->request('GET', $url);

        } catch (Throwable $e) {
            Yii::$app->log->logger->log($e, Logger::LEVEL_ERROR, 'console');
            $response = $e->getMessage();
        }

        $log = $this->writeJobResult($job, $response);
        $this->queueService->removeFromQueue($job);

        return $log;
    }

    /**
     * @throws Exception
     * @throws ValidationException
     * @throws Throwable
     */
    private function writeJobResult(JobInterface $job, $response): WorkLog
    {
        $form = new AddWorkLogForm();
        $form->workId = $job->getWork()->id;
        $form->state = $response instanceof ResponseInterface && $response->getStatusCode() === 200
            ? WorkLogState::SUCCESS : WorkLogState::FAIL;
        $form->attemptNumber = $job->getParams()['attempt_number'] ?? 1;
        $form->detailedData = $response;

        return $this->workLogService->createLog($form);
    }

    private function getHttpClient(): \GuzzleHttp\Client
    {
        if (self::$client === null) {
            self::$client = new Client();
        }

        return self::$client;
    }
}