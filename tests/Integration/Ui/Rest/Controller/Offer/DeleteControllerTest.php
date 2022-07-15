<?php
declare(strict_types=1);

namespace App\Tests\Integration\Ui\Rest\Controller\Offer;

use App\Domain\Offer\ValueObject\Address;
use App\Domain\Offer\ValueObject\PriceRange;
use App\Tests\Integration\Infrastructure\Core\BaseApiTest;

final class DeleteControllerTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_delete_offer(): void
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
            'title' => 'offer title 4',
            'description' => 'description offer 4',
            'companyId' => null,
            'price' => $price,
            'address' => $address,
            'active' => $active,
        ];

        $client = self::createAuthenticatedClient();
        $offerId = $this->createOffer($client, $offerData);

        $client->request(
            'DELETE',
            '/api/offer/'.$offerId,
        );

        $response = $client->getResponse();
        $this->assertNoContentResponseStatus($response);
    }

    /**
     * @test
     */
    public function it_not_delete_not_existing_offer(): void
    {
        $client = self::createAuthenticatedClient();

        $client->request(
            'DELETE',
            '/api/offer/ad206aff-5b0d-4055-ab0f-fb5b43d6c2bc',
        );

        $response = $client->getResponse();
        $this->assertNotFoundRequestResponseStatus($response);
    }

    /**
     * @test
     */
    public function it_not_delete_offer_that_not_belongs_to_user(): void
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
            'title' => 'Offer to not delete',
            'description' => 'description offer test delete',
            'companyId' => null,
            'price' => $price,
            'address' => $address,
            'active' => $active,
        ];

        $userData = [
            'firstName' => 'Vazgen',
            'lastName' => 'Hagop',
            'email' => 'Hagop@emauil.com',
            'password' => 'someStrongPassword@'
        ];
        $client = self::createAuthenticatedClient();
        $offerId = $this->createOffer($client, $offerData);
        $this->createUser($client, $userData);

        self::ensureKernelShutdown();
        $client = self::createAuthenticatedClient('Hagop@emauil.com', 'someStrongPassword@');

        $client->request(
            'DELETE',
            '/api/offer/'. $offerId,
        );

        $response = $client->getResponse();
        $this->assertAccessDeniedRequestResponseStatus($response);
    }
}
