<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api;

use YOOtheme\Http\Response;
use YOOtheme\HttpClientInterface;

abstract class AbstractApi
{
    /**
     * @var string
     */
    protected $apiEndpoint = '';

    /**
     * @var HttpClientInterface
     */
    protected $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function withEndpoint(string $endpoint): self
    {
        return $this;
    }

    protected function getUrl(string $name): string
    {
        return "{$this->apiEndpoint}/{$name}";
    }

    protected function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json'
        ];
    }

    public function get(string $name, array $args = []): array
    {
        return $this->request('GET', $name, $args);
    }

    public function post(string $name, array $args = []): array
    {
        return $this->request('POST', $name, $args);
    }

    public function put(string $name, array $args = []): array
    {
        return $this->request('PUT', $name, $args);
    }

    public function update(string $name, array $args = []): array
    {
        return $this->request('UPDATE', $name, $args);
    }

    public function delete(string $name, array $args = []): array
    {
        return $this->request('DELETE', $name, $args);
    }

    protected function request(string $method, string $name, array $args): array
    {
        $url = $this->getUrl($name);
        $headers = $this->getHeaders();

        switch ($method) {
            case 'GET':
                $query = parse_url($url)['query'] ?? '';
                $query = ($query ? '&' : '?') . http_build_query($args, '', '&');

                $response = $this->client->get("{$url}{$query}", compact('headers'));

                break;

            case 'POST':
                $response = $this->client->post($url, json_encode($args), compact('headers'));

                break;

            case 'PUT':
                $response = $this->client->put($url, json_encode($args), compact('headers'));

                break;

            case 'DELETE':
                $query = parse_url($url)['query'] ?? '';
                $query = ($query ? '&' : '?') . http_build_query($args, '', '&');

                $response = $this->client->delete("{$url}{$query}", compact('headers'));

                break;

            default:
                throw new \Exception("Call to undefined method {$method}");
        }

        return $this->processResponse($response);
    }

    protected function processResponse(Response $response): array
    {
        $encoded = json_decode($response->getBody(), true);
        $success = $response->getStatusCode() >= 200 && $response->getStatusCode() <= 299 && $encoded;

        return [
            'success' => $success,
            'data' => $encoded
        ];
    }
}
