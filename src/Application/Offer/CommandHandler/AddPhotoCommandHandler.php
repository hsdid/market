<?php

namespace App\Application\Offer\CommandHandler;

use App\Application\Offer\Command\AddPhotoCommand;
use App\Domain\Core\Id\OfferPhotoId;
use App\Domain\Offer\Model\OfferPhoto;
use App\Domain\Offer\OfferRepositoryInterface;
use App\Domain\Offer\PhotoPath;
use App\Domain\Offer\Repository\OfferPhotoRepositoryInterface;
use Assert\AssertionFailedException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Uid\Uuid;

class AddPhotoCommandHandler implements MessageHandlerInterface
{
    private OfferPhotoRepositoryInterface $offerPhotoRepository;
    private OfferRepositoryInterface $offerRepository;

    public function __construct
    (
        OfferPhotoRepositoryInterface $offerPhotoRepository,
        OfferRepositoryInterface $offerRepository
    ) {
        $this->offerPhotoRepository = $offerPhotoRepository;
        $this->offerRepository = $offerRepository;
    }

    /**
     * @throws AssertionFailedException
     */
    public function __invoke(AddPhotoCommand $command)
    {
        $offer = $this->offerRepository->getById($command->getOfferId());
        if (null === $offer) {
            throw new \InvalidArgumentException('Offer not found!');
        }
        $offerPhotos = [];

        foreach ($command->getFiles() as $photo) {
            $photoId = new OfferPhotoId((string) Uuid::v4());
            $fileName = md5(uniqid()).'.'.$photo->guessExtension();

            $photoPath = new PhotoPath($fileName);

            $photo->move(
                PhotoPath::PHOTO_DIR,
                $fileName
            );

            $offerPhotos[] = new OfferPhoto(
                $photoId,
                $offer,
                $photoPath,
                $photo->getClientOriginalName(),
                $photo->getClientMimeType()
            );
        }
        foreach ($offerPhotos as $photo) {
            $this->offerPhotoRepository->save($photo);
        }

    }
}
