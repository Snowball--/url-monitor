<?php
declare(strict_types=1);

namespace common\models\Works\Processors;

use common\Exceptions\ValidationException;
use common\models\Jobs\JobInterface;
use common\models\WorkLogs\LogDetailInterface;
use common\models\WorkLogs\UrlLogDetail;
use common\models\WorkLogs\WorkLog;
use common\models\WorkLogs\WorkLogState;
use common\Services\WorkLogService;
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

    public function __construct(private readonly WorkLogService $workLogService, $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @throws GuzzleException
     * @throws Throwable
     */
    public function process(JobInterface $job): mixed
    {
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
            throw $e;
        }

        return $response;
    }

    /**
     * @throws Exception
     * @throws ValidationException
     * @throws Throwable
     */
    private function writeJobResult(WorkLog $job, $response)
    {
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            $job->setDateProcessed(new \DateTimeImmutable('now'));
            $job->state = WorkLogState::FAIL->value;

            if ($response instanceof ResponseInterface) {
                $job->state = $response->getStatusCode() === 200 ? WorkLogState::SUCCESS->value : $job->state;

                $detailsClass = $job->getWork()->getType()->getLogDetailsClass();

                /* @var UrlLogDetail $jobDetails */
                $jobDetails = new $detailsClass();
                $jobDetails->setId($job->id);
                $jobDetails->response_code = $response->getStatusCode();
                $jobDetails->response_body = $response->getBody()->getContents();

                if (!$jobDetails->save()) {
                    throw new ValidationException($jobDetails);
                }
            }

            if (!$job->save()) {
                throw new ValidationException($job);
            }

            $transaction->commit();
        } catch (Throwable $e) {
            Yii::$app->log->logger->log($e->getMessage(), Logger::LEVEL_ERROR);
            $transaction->rollBack();

            throw $e;
        }

        return $job;
    }

    private function getHttpClient(): \GuzzleHttp\Client
    {
        if (self::$client === null) {
            self::$client = new Client();
        }

        return self::$client;
    }
}