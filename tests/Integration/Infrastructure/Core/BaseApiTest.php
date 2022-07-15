<?php
declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Core;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelBrowser;

abstract class BaseApiTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected static function createAuthenticatedClient(
        $username = 'user@email.com',
        $password = 'password',
        string $type = 'user'
    ): HttpKernelBrowser {
        $token = TokenProvider::getInstance()->getToken($type, $username);
        $client = static::createClient();
        if (null === $token) {

            $client->request(
                'POST',
                '/api/login_check',
                [
                    'username' => $username,
                    'password' => $password,
                ],
            );

            $data = json_decode($client->getResponse()->getContent(), true);
            $token = $data['token'];

            TokenProvider::getInstance()->addToken($type, $username, $token);
        }

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $token));

        return $client;
    }
    protected function assertOkResponseStatus(Response $response): void
    {
        $this->assertEquals(200, $response->getStatusCode(), 'Response should have status 200');
    }

    protected function assertNoContentResponseStatus(Response $response): void
    {
        $this->assertEquals(204, $response->getStatusCode(), 'Response should have status 204');
    }

    protected function assertBadRequestResponseStatus(Response $response): void
    {
        $this->assertEquals(400, $response->getStatusCode(), 'Response should have status 400');
    }

    protected function assertAccessDeniedRequestResponseStatus(Response $response): void
    {
        $this->assertEquals(403, $response->getStatusCode(), 'Response should have status 403');
    }

    protected function assertNotFoundRequestResponseStatus(Response $response): void
    {
        $this->assertEquals(404, $response->getStatusCode(), 'Response should have status 404');
    }

    public function createUser($client, array $data): string
    {
        $client->request(
            'POST',
            '/api/register',
            $data
        );

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->assertOkResponseStatus($response);

        return $data['userId'];
    }

    public function createOffer($client, array $offer): string
    {
        $client->request(
            'POST',
            '/api/offer',
            [
                'title' => $offer['title'],
                'description' => $offer['description'],
                'price' => [
                    'minPrice' => $offer['price']->getMinPrice(),
                    'maxPrice' => $offer['price']->getMaxPrice(),
                ],
                'companyId' => $offer['companyId'],
                'address' => [
                    'province' => $offer['address']->getProvince(),
                    'city' => $offer['address']->getCity(),
                    'address' => $offer['address']->getAddress(),
                    'street' => $offer['address']->getStreet(),
                    'postal' => $offer['address']->getPostal(),
                ],
                'active' => $offer['active'],
            ]
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        return $data['offerId'];
    }

    public function createCompany($client, array $company): string
    {
        $client->request(
            'POST',
            '/api/company',
            [
                'name' => $company['name'],
                'description' => $company['description'],
                'active' => true,
                'address' => [
                    'province' => $company['address']->getProvince(),
                    'city' => $company['address']->getCity(),
                    'address' => $company['address']->getAddress(),
                    'street' => $company['address']->getStreet(),
                    'postal' => $company['address']->getPostal(),
                ]
            ]
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);

        return $data['companyId'];
    }

}
