<?php
declare(strict_types=1);

namespace App\Tests\Integration\Ui\Rest\Controller\Offer;

use App\Domain\Offer\ValueObject\Address;
use App\Domain\Offer\ValueObject\PriceRange;
use App\Tests\Integration\Infrastructure\Core\BaseApiTest;

final class GetListControllerTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_get_offer_list(): void
    {
        $price = new PriceRange(50, 150);
        $address = new Address(
            'Province',
            'city',
            'address',
            'street',
            'postal'
        );
        $active = true;

        $offerData = [
            'title' => 'offer title 10',
            'description' => 'description offer 10',
            'companyId' => null,
            'price' => $price,
            'address' => $address,
            'active' => $active,
        ];

        $client = self::createAuthenticatedClient();
        $this->createOffer($client, $offerData);

        $client->request(
            'GET',
            '/api/offer'
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);

        foreach ($data['items'] as $offer) {
            $this->assertIsString($offer['offerId']);
            $this->assertNotNull($offer['offerId']);
            $this->assertIsString($offer['userId']);
            $this->assertNotNull($offer['userId']);
            $this->assertIsString($offer['title']);
            $this->assertNotNull($offer['title']);
            $this->assertIsBool($offer['active']);
            $this->assertNotNull($offer['active']);
            $this->assertIsArray($offer['address']);
            $this->assertNotNull($offer['createdAt']);
            $this->assertIsArray($offer['price']);
            $this->assertIsArray($offer['photos']);
        }
    }

    /**
     * @test
     */
    public function it_get_offer_list_with_per_page_parameter(): void
    {
        $price = new PriceRange(101, 150);
        $address = new Address(
            'Province',
            'city',
            'address',
            'street',
            'postal'
        );
        $active = true;

        $offerData = [
            'title' => 'offer title 10',
            'description' => 'description offer 10',
            'companyId' => null,
            'price' => $price,
            'address' => $address,
            'active' => $active,
        ];

        $client = self::createAuthenticatedClient();
        $this->createOffer($client, $offerData);

        //check if there is more then 1 offfer
        $client->request(
            'GET',
            '/api/offer'
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $this->assertTrue(count($data['items']) > 1);

        //check perPage parameter work
        $client->request(
            'GET',
            '/api/offer?_itemsOnPage=1'
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $this->assertCount(1, $data['items']);
    }

    /**
     * @test
     */
    public function it_filter_offer_by_address(): void
    {
        $price = new PriceRange(120, 150);
        $address = new Address(
            'Podlaskie',
            'Białystok',
            'Ulica 12',
            'Ulica',
            '18-200'
        );
        $active = true;

        $offerData = [
            'title' => 'offer title 11',
            'description' => 'description offer 11',
            'companyId' => null,
            'price' => $price,
            'address' => $address,
            'active' => $active,
        ];

        $client = self::createAuthenticatedClient();
        $this->createOffer($client, $offerData);
        //by province
        $client->request(
            'GET',
            '/api/offer?address:province=Podlaskie'
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $this->assertCount(1, $data['items']);
        $offer = $data['items'][0];

        $this->assertEquals($address->getProvince(), $offer['address']['province']);
        //by city
        $client->request(
            'GET',
            '/api/offer?address:city=Białystok'
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $this->assertCount(1, $data['items']);
        $offer = $data['items'][0];

        $this->assertEquals($address->getCity(), $offer['address']['city']);
        //by postal code
        $client->request(
            'GET',
            '/api/offer?address:postal=18-200'
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $this->assertCount(1, $data['items']);
        $offer = $data['items'][0];

        $this->assertEquals($address->getPostal(), $offer['address']['postal']);
        //by address
        $client->request(
            'GET',
            '/api/offer?address:address=Ulica 12'
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);

        $this->assertCount(1, $data['items']);
        $offer = $data['items'][0];

        $this->assertEquals($address->getAddress(), $offer['address']['address']);

        //by street
        $client->request(
            'GET',
            '/api/offer?address:street=Ulica'
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);

        $this->assertCount(1, $data['items']);
        $offer = $data['items'][0];

        $this->assertEquals($address->getStreet(), $offer['address']['street']);
    }

    /**
     * @test
     */
    public function it_filter_offer_by_offer_id(): void
    {
        $price = new PriceRange(400, 550);
        $address = new Address(
            'Podlaskie',
            'Białystok',
            'Ulica 12',
            'Ulica',
            '18-200'
        );
        $active = true;

        $offerData = [
            'title' => 'offer title 11',
            'description' => 'description offer 11',
            'companyId' => null,
            'price' => $price,
            'address' => $address,
            'active' => $active,
        ];

        $client = self::createAuthenticatedClient();
        $offerId = $this->createOffer($client, $offerData);

        $client->request(
            'GET',
            '/api/offer?offerId='.$offerId
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);

        $this->assertCount(1, $data['items']);
        $offer = $data['items'][0];
        $this->assertEquals($offerId, $offer['offerId']);
    }

    /**
     * @test
     */
    public function it_filter_offer_by_user_id(): void
    {
        $price = new PriceRange(80, 150);
        $address = new Address(
            'Lubelskie',
            'Lublin',
            'Ulica 1',
            'Ulica 1',
            '20-300'
        );
        $active = true;

        $offerData = [
            'title' => 'offer title 11',
            'description' => 'description offer 11',
            'companyId' => null,
            'price' => $price,
            'address' => $address,
            'active' => $active,
        ];

        $userData = [
            'firstName' => 'Jeff1',
            'lastName' => 'Jefferson1',
            'email' => 'jefferson1@emauil.com',
            'password' => 'someStrongPassword@'
        ];

        $client = self::createAuthenticatedClient();
        $userId = $this->createUser($client, $userData);

        self::ensureKernelShutdown();
        $client = self::createAuthenticatedClient('jefferson1@emauil.com', 'someStrongPassword@');

        $this->createOffer($client, $offerData);

        $client->request(
            'GET',
            '/api/offer?userId='.$userId
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);

        $this->assertCount(1, $data['items']);
        $offer = $data['items'][0];
        $this->assertEquals($userId, $offer['userId']);
    }

    /**
     * @test
     */
    public function it_filter_offer_by_price(): void
    {
        $client = self::createAuthenticatedClient();

        $client->request(
            'GET',
            '/api/offer?price:minPrice[gt]=100'
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $offers = $data['items'];

        $this->assertTrue(count($offers) > 1);
        foreach ($offers as $offer) {
            $this->assertTrue($offer['price']['minPrice'] > 100);
        }

        $client->request(
            'GET',
            '/api/offer?price:maxPrice[lt]=200'
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $offers = $data['items'];

        $this->assertTrue(count($offers) > 1);
        foreach ($offers as $offer) {
            $this->assertTrue($offer['price']['maxPrice'] < 200);
        }

        $client->request(
            'GET',
            '/api/offer?price:minPrice[gt]=100&price:maxPrice[lt]=200'
        );

        $response = $client->getResponse();
        $this->assertOkResponseStatus($response);
        $data = json_decode($response->getContent(), true);
        $offers = $data['items'];
        $this->assertTrue(count($offers) > 1);
        foreach ($offers as $offer) {
            $this->assertTrue($offer['price']['maxPrice'] < 200);
        }
    }
}
