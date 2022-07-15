<?php

declare(strict_types=1);

namespace App\Tests\Integration\Ui\Rest\Controller\Offer\Photo;

use App\Domain\Offer\ValueObject\Address;
use App\Domain\Offer\ValueObject\PriceRange;
use App\Tests\Integration\Infrastructure\Core\BaseApiTest;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class PostPhotoControllerTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_create_offer_and_add_photos(): void
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
            'title' => 'offer title 10',
            'description' => 'description offer 10',
            'companyId' => null,
            'price' => $price,
            'address' => $address,
            'active' => $active,
        ];

        $client = self::createAuthenticatedClient();
        $offerId = $this->createOffer($client, $offerData);
//        var_dump($offerId);
//
//        $fileData = [
//            'files[]' => new UploadedFile('tests/Integration/Ui/Rest/Controller/Offer/Photo/Image/image1.png', 'image1.png')
//        ];
//
//        $client->request(
//            'POST',
//            '/api/offer/'.$offerId.'/photo',
//            [],
//            [
//                'photo' => [
//                    'files[]' =>  new UploadedFile('tests/Integration/Ui/Rest/Controller/Offer/Photo/Image/image1.png', 'image1.png')
//                ]
//            ]
//        );
//
//        $response = $client->getResponse();
//        var_dump($response->getContent());
//        $this->assertNoContentResponseStatus($response);
    }
}
