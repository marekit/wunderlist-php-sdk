<?php
namespace Mh\Wunderlist;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractWunderlistClient
{
    const CLIENT_ID = '';
    const ACCESS_TOKEN = '';

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * Constructor
     */
    public function __construct($clientId = self::CLIENT_ID, $accessToken = self::ACCESS_TOKEN)
    {
        $guzzle = new Client(
            [
                'base_uri' => 'https://a.wunderlist.com/api/v1/',
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Client-ID' => $clientId,
                    'X-Access-Token' => $accessToken,
                ],
            ]
        );

        $this->client = $guzzle;
    }

    /**
     * Returns all the lists
     * @return array
     */
    public function getLists(): array
    {
        $response = $this->client->get('lists');
        $this->checkResponseStatusCode($response, 200);

        return json_decode($response->getBody(), true);
    }

    /**
     * Returns a specific list
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getList($id): array
    {
        $response = $this->client->get('lists/' . $id);
        $this->checkResponseStatusCode($response, 200);

        return json_decode($response->getBody(), true);
    }

    /**
     * Creates list
     *
     * @param string $title
     *
     * @return mixed
     */
    public function createList($title): array
    {
        $response = $this->client->post('lists', [
            RequestOptions::JSON => ['title' => $title],
        ]);
        $this->checkResponseStatusCode($response, 201);

        return json_decode($response->getBody(), true);
    }

    /**
     * Returns all the folders
     * @return array
     */
    public function getFolders(): array
    {
        $response = $this->client->get('folders');
        $this->checkResponseStatusCode($response, 200);

        return json_decode($response->getBody(), true);
    }

    /**
     * Returns a specific folder
     *
     * @param int $id
     *
     * @return array
     */
    public function getFolder($id): array
    {
        $response = $this->client->get('folders/' . $id);
        $this->checkResponseStatusCode($response, 200);

        return json_decode($response->getBody(), true);
    }

    /**
     * Creates folder
     *
     * @param string $title
     * @param array $listIds
     *
     * @return mixed
     */
    public function createFolder($title, $listIds): array
    {
        $response = $this->client->post('folders', [
            RequestOptions::JSON => ['title' => $title, 'list_ids' => $listIds],
        ]);
        $this->checkResponseStatusCode($response, 201);

        return json_decode($response->getBody(), true);
    }

    /**
     * Creates task
     *
     * @param $listId
     * @param $title
     * @param null $assigneeId
     * @param bool $completed
     * @param string $recurrenceType
     * @param null $reccurrenceCount
     * @param string $dueDate
     * @param bool $starred
     *
     * @return array
     */
    public function createTask(
        $listId,
        $title,
        $assigneeId = null,
        $completed = false,
        $recurrenceType = '',
        $reccurrenceCount = null,
        $dueDate = '',
        $starred = false
    ): array {
        $response = $this->client->post('tasks', [
            RequestOptions::JSON => [
                'list_id' => $listId,
                'title' => $title,
                'assignee_id' => $assigneeId,
                'completed' => $completed,
                'recurrence_type' => $recurrenceType,
                'recurrence_count' => $reccurrenceCount,
                'due_date' => $dueDate,
                'starred' => $starred
            ],
        ]);
        $this->checkResponseStatusCode($response, 201);

        return json_decode($response->getBody(), true);
    }

    /**
     * Check the response status code.
     *
     * @param ResponseInterface $response
     * @param int $expectedStatusCode
     *
     * @throws \RuntimeException on unexpected status code
     */
    private function checkResponseStatusCode(ResponseInterface $response, $expectedStatusCode)
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode !== $expectedStatusCode) {
            throw new \RuntimeException('Wunderlist API returned status code ' . $statusCode . ' expected ' . $expectedStatusCode);
        }
    }
}
