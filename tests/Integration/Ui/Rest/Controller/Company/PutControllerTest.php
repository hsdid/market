<?php
declare(strict_types=1);

namespace App\Tests\Integration\Ui\Rest\Controller\Company;

use App\Domain\Company\ValueObject\Address;
use App\Infrastructure\User\DataFixtures\Orm\LoadUserData;
use App\Tests\Integration\Infrastructure\Core\BaseApiTest;

final class PutControllerTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_create_company_and_update_company(): void
    {
        $client = self::createAuthenticatedClient();

        $name = 'User Company 5';
        $description = 'User Company desc 5';
        $address = new Address(
            'Province',
            'Kraków',
            'address',
            'street',
            'postal'
        );

        $companyData = [
            'name' => $name,
            'description' => $description,
            'address' => $address
        ];

        $companyId = $this->createCompany($client, $companyData);

        $name = 'Company66';
        $description = 'Company66';


        $client->request(
            'PUT',
            '/api/company/'.$companyId,
            [
                'name' => $name,
                'description' => $description,
                'address' => $address->toArray(),
                'active' => true
            ]
        );

        $response = $client->getResponse();
        $this->assertNoContentResponseStatus($response);

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
    public function it_dose_not_update_company_that_not_belongs_to_user(): void
    {
        $name = 'User Company 6';
        $description = 'User Company desc 6';
        $address = new Address(
            'Province',
            'Kraków',
            'address',
            'street',
            'postal'
        );

        $companyData = [
            'name' => $name,
            'description' => $description,
            'address' => $address
        ];

        $userData = [
            'firstName' => 'Jeff2',
            'lastName' => 'Jefferson2',
            'email' => 'jefferson2@emauil.com',
            'password' => 'someStrongPassword@'
        ];

        $client = self::createAuthenticatedClient();
        $companyId = $this->createCompany($client, $companyData);
        $this->createUser($client, $userData);

        self::ensureKernelShutdown();
        $client = self::createAuthenticatedClient($userData['email'], $userData['password']);

        $client->request(
            'PUT',
            '/api/company/'.$companyId,
            [
                'name' => $name,
                'description' => $description,
                'address' => $address->toArray(),
                'active' => true
            ]
        );

        $response = $client->getResponse();
        $this->assertAccessDeniedRequestResponseStatus($response);
    }

    /**
     * @test
     */
    public function it_dose_not_update_not_existing_company(): void
    {
        $name = 'User Company 6';
        $description = 'User Company desc 6';
        $address = new Address(
            'Province',
            'Kraków',
            'address',
            'street',
            'postal'
        );

        $client = self::createAuthenticatedClient();

        $client->request(
            'PUT',
            '/api/company/ad206aff-5b0d-4055-ab0f-fb5b43d6c211',
            [
                'name' => $name,
                'description' => $description,
                'address' => $address->toArray(),
                'active' => true
            ]
        );

        $response = $client->getResponse();
        $this->assertNotFoundRequestResponseStatus($response);
    }
}
