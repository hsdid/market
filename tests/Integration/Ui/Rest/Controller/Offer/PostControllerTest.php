<?php
declare(strict_types=1);

namespace App\Tests\Integration\Ui\Rest\Controller\Offer;

use App\Domain\Offer\ValueObject\Address;
use App\Domain\Offer\ValueObject\PriceRange;
use App\Infrastructure\Company\DataFixtures\Orm\LoadCompanyData;
use App\Infrastructure\User\DataFixtures\Orm\LoadUserData;
use App\Tests\Integration\Infrastructure\Core\BaseApiTest;

final class PostControllerTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_create_offer_without_company(): void
    {
        $price = new PriceRange(100, 200);
        $address = new Address(
            'Province',
            'city',
            'address',
            'street',
            'postal'
        );
        $active = true;

        $offerData = [
            'title' => 'offer title 1',
            'description' => 'description offer 1',
            'companyId' => null,
            'price' => $price,
            'address' => $address,
            'active' => $active,
        ];

        $client = self::createAuthenticatedClient();
        $offerId = $this->createOffer($client, $offerData);

        $client->request(
            'GET',
            '/api/offer/'. $offerId,
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);

        $this->assertEquals($offerId, $data['offerId']);
        $this->assertEquals('offer title 1', $data['title']);
        $this->assertEquals(LoadUserData::USER_ID, $data['userId']);
        $this->assertEquals('description offer 1', $data['description']);
        $this->assertEquals(null, $data['companyId']);
        $this->assertEquals(true, $data['active']);
        $this->assertEquals($price->toArray(), $data['price']);
        $this->assertEquals($address->toArray(), $data['address']);
    }

    /**
     * @test
     */
    public function it_create_offer_with_company(): void
    {
        $title = 'offer title 2';
        $description = 'description offer 2';
        $price = new PriceRange(400, 500);
        $address = new Address(
            'Province',
            'Kraków',
            'address',
            'street',
            'postal'
        );
        $active = true;

        $client = $this->createAuthenticatedClient();

        $client->request(
            'POST',
            '/api/company',
            [
                'name' => 'User Company',
                'description' => 'User Company desc',
                'active' => true,
                'address' => [
                    'city' => 'Kraków'
                ]
            ]
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $companyId = $data['companyId'];

        $offerData = [
            'title' => $title,
            'description' => $description,
            'companyId' => $companyId,
            'price' => $price,
            'address' => $address,
            'active' => $active,
        ];

        $offerId = $this->createOffer($client, $offerData);

        $client->request(
            'GET',
            '/api/offer/'. $offerId,
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($offerId, $data['offerId']);
        $this->assertEquals($title, $data['title']);
        $this->assertEquals(LoadUserData::USER_ID, $data['userId']);
        $this->assertEquals($description, $data['description']);
        $this->assertEquals($companyId, $data['companyId']);
        $this->assertEquals(true, $data['active']);
        $this->assertEquals($price->toArray(), $data['price']);
        $this->assertEquals($address->toArray(), $data['address']);
    }

    /**
     * @test
     */
    public function it_not_create_offer_when_company_not_belong_to_user(): void
    {
        $title = 'offer title 1';
        $description = 'description offer 1';
        $priceRange = new PriceRange(100, 200);
        $address = new Address(
            'Province',
            'city',
            'address',
            'street',
            'postal'
        );
        $active = true;

        $client = self::createAuthenticatedClient();
        $client->request(
            'POST',
            '/api/offer',
            [
                'title' => $title,
                'description' => $description,
                'price' => [
                    'minPrice' => $priceRange->getMinPrice(),
                    'maxPrice' => $priceRange->getMaxPrice()
                ],
                'companyId' => LoadCompanyData::COMPANY_ID,
                'address' => [
                    'province' => $address->getProvince(),
                    'city' => $address->getCity(),
                    'address' => $address->getAddress(),
                    'street' => $address->getStreet(),
                    'postal' => $address->getPostal(),
                ],
                'active' => $active,
            ]
        );

        $response = $client->getResponse();
        $this->assertBadRequestResponseStatus($response);
    }

    /**
     * @test
     */
    public function it_not_create_offer_with_blank_title(): void
    {
        $title = '';
        $description = 'description offer 1';
        $priceRange = new PriceRange(100, 200);
        $address = new Address(
            'Province',
            'city',
            'address',
            'street',
            'postal'
        );
        $active = true;

        $client = self::createAuthenticatedClient();
        $client->request(
            'POST',
            '/api/offer',
            [
                'title' => $title,
                'description' => $description,
                'price' => [
                    'minPrice' => $priceRange->getMinPrice(),
                    'maxPrice' => $priceRange->getMaxPrice()
                ],
                'address' => [
                    'province' => $address->getProvince(),
                    'city' => $address->getCity(),
                    'address' => $address->getAddress(),
                    'street' => $address->getStreet(),
                    'postal' => $address->getPostal(),
                ],
                'active' => $active,
            ]
        );

        $response = $client->getResponse();
        $this->assertBadRequestResponseStatus($response);
    }

    /**
     * @test
     */
    public function it_not_create_offer_with_blank_description(): void
    {
        $title = 'test offer 3';
        $description = '';
        $priceRange = new PriceRange(100, 200);
        $address = new Address(
            'Province',
            'city',
            'address',
            'street',
            'postal'
        );
        $active = true;

        $client = $this->createAuthenticatedClient();
        $client->request(
            'POST',
            '/api/offer',
            [
                'title' => $title,
                'description' => $description,
                'price' => [
                    'minPrice' => $priceRange->getMinPrice(),
                    'maxPrice' => $priceRange->getMaxPrice()
                ],
                'address' => [
                    'province' => $address->getProvince(),
                    'city' => $address->getCity(),
                    'address' => $address->getAddress(),
                    'street' => $address->getStreet(),
                    'postal' => $address->getPostal(),
                ],
                'active' => $active,
            ]
        );

        $response = $client->getResponse();
        $this->assertBadRequestResponseStatus($response);
    }

    /**
     * @test
     */
    public function it_deactivate_offer(): void
    {
        $title = 'test offer 4';
        $description = 'test offer 4';
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
            'title' => $title,
            'description' => $description,
            'companyId' => null,
            'price' => $priceRange,
            'address' => $address,
            'active' => $active,
        ];

        $client = $this->createAuthenticatedClient();

        $offerId = $this->createOffer($client, $offerData);

        //check created offer is active
        $client->request(
            'GET',
            '/api/offer/'. $offerId,
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($offerId, $data['offerId']);
        $this->assertEquals($active, $data['active']);

        //deactive offer
        $client->request(
            'POST',
            '/api/offer/'.$offerId.'/deactivate',
            []
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($offerId, $data['offerId']);

        //check offer is deactivate
        $client->request(
            'GET',
            '/api/offer/'. $offerId,
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($offerId, $data['offerId']);
        $this->assertEquals(false, $data['active']);
    }

    /**
     * @test
     */
    public function it_activate_offer(): void
    {
        $title = 'test offer 5';
        $description = 'test offer 5';
        $priceRange = new PriceRange(100, 300);
        $address = new Address(
            'Province',
            'city',
            'address',
            'street',
            'postal'
        );

        $client = self::createAuthenticatedClient();
        $client->request(
            'POST',
            '/api/offer',
            [
                'title' => $title,
                'description' => $description,
                'price' => [
                    'minPrice' => $priceRange->getMinPrice(),
                    'maxPrice' => $priceRange->getMaxPrice()
                ],
                'address' => [
                    'province' => $address->getProvince(),
                    'city' => $address->getCity(),
                    'address' => $address->getAddress(),
                    'street' => $address->getStreet(),
                    'postal' => $address->getPostal(),
                ],
            ]
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $offerId = $data['offerId'];

        //check offer is deactivate
        $client->request(
            'GET',
            '/api/offer/'. $offerId,
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($offerId, $data['offerId']);
        $this->assertEquals(false, $data['active']);

        //activate offer
        $client->request(
            'POST',
            '/api/offer/'.$offerId.'/activate',
            []
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($offerId, $data['offerId']);

        //check offer is activate
        $client->request(
            'GET',
            '/api/offer/'. $offerId,
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($offerId, $data['offerId']);
        $this->assertEquals(true, $data['active']);
    }
}
