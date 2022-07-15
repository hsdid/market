<?php
declare(strict_types=1);

namespace App\Tests\Integration\Ui\Rest\Controller\Company;

use App\Domain\Company\ValueObject\Address;
use App\Infrastructure\User\DataFixtures\Orm\LoadUserData;
use App\Tests\Integration\Infrastructure\Core\BaseApiTest;

final class PostControllerTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_create_company(): void
    {
        $client = self::createAuthenticatedClient();

        $name = 'User Company 2';
        $description = 'User Company desc 2';
        $address = new Address(
            'Province',
            'Kraków',
            'address',
            'street',
            'postal'
        );

        $client->request(
            'POST',
            '/api/company',
            [
                'name' => $name,
                'description' => $description,
                'active' => true,
                'address' => [
                    'province' => $address->getProvince(),
                    'city' => $address->getCity(),
                    'address' => $address->getAddress(),
                    'street' => $address->getStreet(),
                    'postal' => $address->getPostal(),
                ]
            ]
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $companyId = $data['companyId'];

        $client->request(
            'GET',
            '/api/company/'. $companyId,
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);

        $this->assertEquals($companyId, $data['companyId']);
        $this->assertEquals(LoadUserData::USER_ID, $data['userId']);
        $this->assertEquals($name, $data['name']);
        $this->assertEquals($description, $data['description']);
        $this->assertEquals($address->toArray(), $data['address']);
        $this->assertEquals(true, $data['active']);
    }

    /**
     * @test
     */
    public function it_not_create_company_with_existing_name(): void
    {
        $client = self::createAuthenticatedClient();

        $name = 'User Company 2';
        $description = 'User Company desc 2';
        $address = new Address(
            'Province',
            'Kraków',
            'address',
            'street',
            'postal'
        );

        $client->request(
            'POST',
            '/api/company',
            [
                'name' => $name,
                'description' => $description,
                'active' => true,
                'address' => [
                    'province' => $address->getProvince(),
                    'city' => $address->getCity(),
                    'address' => $address->getAddress(),
                    'street' => $address->getStreet(),
                    'postal' => $address->getPostal(),
                ]
            ]
        );

        $response = $client->getResponse();
        $this->assertBadRequestResponseStatus($response);
    }

    /**
     * @test
     */
    public function it_not_create_company_with_blank_name(): void
    {
        $client = self::createAuthenticatedClient();

        $name = '';
        $description = 'User Company desc 3';
        $address = new Address(
            'Province',
            'Kraków',
            'address',
            'street',
            'postal'
        );

        $client->request(
            'POST',
            '/api/company',
            [
                'name' => $name,
                'description' => $description,
                'active' => true,
                'address' => [
                    'province' => $address->getProvince(),
                    'city' => $address->getCity(),
                    'address' => $address->getAddress(),
                    'street' => $address->getStreet(),
                    'postal' => $address->getPostal(),
                ]
            ]
        );

        $response = $client->getResponse();
        $this->assertBadRequestResponseStatus($response);
    }
}