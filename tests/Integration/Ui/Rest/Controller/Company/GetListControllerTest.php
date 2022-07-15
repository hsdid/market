<?php

namespace App\Tests\Integration\Ui\Rest\Controller\Company;

use App\Domain\Company\ValueObject\Address;
use App\Tests\Integration\Infrastructure\Core\BaseApiTest;

final class GetListControllerTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_get_company_list(): void
    {


        $name = 'User Company 3';
        $description = 'User Company desc 3';
        $address = new Address(
            'Province',
            'Kraków',
            'address',
            'street',
            'postal'
        );

        $client = self::createAuthenticatedClient();
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

        $client->request(
            'GET',
            '/api/offer'
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);

        foreach ($data['items'] as $company) {
            $this->assertIsString($company['companyId']);
            $this->assertIsString($company['userId']);
            $this->assertIsString($company['name']);
            $this->assertIsBool($company['active']);
            $this->assertIsString($company['description']);
            $this->assertIsArray($company['address']);
            $this->assertNotNull($company['createdAt']);
            $this->assertIsArray($company['photos']);
        }
    }
}
