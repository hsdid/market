<?php

declare(strict_types=1);

namespace App\Tests\Integration\Ui\Rest\Controller\Offer;

use App\Domain\Offer\ValueObject\Address;
use App\Domain\Offer\ValueObject\PriceRange;
use App\Tests\Integration\Infrastructure\Core\BaseApiTest;

final class PutControllerTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_create_and_edit_offer_title_desc_price(): void
    {
        $priceRange = new PriceRange(100, 200);
        $address = new Address(
            'Province',
            'city',
            'address',
            'street',
            'postal'
        );
        $active = true;

        $offerData = [
            'title' => 'offer test',
            'description' => 'description offer test',
            'companyId' => null,
            'price' => $priceRange,
            'address' => $address,
            'active' => $active,
        ];

        $client = self::createAuthenticatedClient();
        $offerId = $this->createOffer($client, $offerData);
        $this->offerId = $offerId;
        $newPrice = new PriceRange(1000, 2000);
        $client->request(
            'PUT',
            '/api/offer/'.$offerId,
            [
                'title' => 'exhaust system',
                'description' =>'exhaust system for Audi',
                'price' => [
                    'minPrice' => $newPrice->getMinPrice(),
                    'maxPrice' => $newPrice->getMaxPrice(),
                ],
                'address' => [
                    'province' => $address->getProvince(),
                    'city' => $address->getCity(),
                    'address' => $address->getAddress(),
                    'street' => $address->getStreet(),
                    'postal' => $address->getPostal(),
                ],
                'active' => true
            ]
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);

        $client->request(
            'GET',
            '/api/offer/'. $offerId,
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('exhaust system', $data['title']);
        $this->assertEquals('exhaust system for Audi', $data['description']);
        $this->assertEquals($newPrice->toArray(), $data['price']);
        $this->assertEquals(true, $data['active']);
    }

    /**
     * @test
     */
    public function it_not_edit_offer_that_not_belongs_to_user(): void
    {
        $priceRange = new PriceRange(100, 200);
        $address = new Address(
            'Province',
            'city',
            'address',
            'street',
            'postal'
        );
        $active = true;

        $offerData = [
            'title' => 'Offer to not edit',
            'description' => 'description offer test',
            'companyId' => null,
            'price' => $priceRange,
            'address' => $address,
            'active' => $active,
        ];

        $userData = [
            'firstName' => 'Jeff',
            'lastName' => 'Jefferson',
            'email' => 'jefferson@emauil.com',
            'password' => 'someStrongPassword@'
        ];
        $client = self::createAuthenticatedClient();
        $offerId = $this->createOffer($client, $offerData);
        $this->createUser($client, $userData);

        self::ensureKernelShutdown();
        $client = self::createAuthenticatedClient('jefferson@emauil.com', 'someStrongPassword@');

        $newPrice = new PriceRange(1000, 2000);
        $client->request(
            'PUT',
            '/api/offer/'.$offerId,
            [
                'title' => 'offer 5',
                'description' =>'cant edit this offer',
                'priceRange' => [
                    'minPrice' => $newPrice->getMinPrice(),
                    'maxPrice' => $newPrice->getMaxPrice(),
                ],
                'address' => [
                    'province' => $address->getProvince(),
                    'city' => $address->getCity(),
                    'address' => $address->getAddress(),
                    'street' => $address->getStreet(),
                    'postal' => $address->getPostal(),
                ],
                'active' => true
            ]
        );

        $response = $client->getResponse();
        $this->assertAccessDeniedRequestResponseStatus($response);
    }

    /**
     * @test
     */
    public function it_not_edit_not_existing_offer(): void
    {
        $address = new Address(
            'Province',
            'city',
            'address',
            'street',
            'postal'
        );
        $newPrice = new PriceRange(1000, 2000);
        $client = self::createAuthenticatedClient();
        $client->request(
            'PUT',
            '/api/offer/ad206aff-5b0d-4055-ab0f-fb5b43d6c2bc',
            [
                'title' => 'offer 5',
                'description' =>'cant edit this offer',
                'priceRange' => [
                    'minPrice' => $newPrice->getMinPrice(),
                    'maxPrice' => $newPrice->getMaxPrice(),
                ],
                'address' => [
                    'province' => $address->getProvince(),
                    'city' => $address->getCity(),
                    'address' => $address->getAddress(),
                    'street' => $address->getStreet(),
                    'postal' => $address->getPostal(),
                ],
                'active' => true
            ]
        );

        $response = $client->getResponse();
        $this->assertNotFoundRequestResponseStatus($response);
    }
}
