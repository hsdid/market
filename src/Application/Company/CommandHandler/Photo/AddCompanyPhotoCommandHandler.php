<?php

namespace App\Application\Company\CommandHandler\Photo;

use App\Application\Company\Command\Photo\AddCompanyPhotoCommand;
use App\Domain\Company\CompanyPhotoRepositoryInterface;
use App\Domain\Company\Model\CompanyPhoto;
use App\Domain\Company\Photo\PhotoPath;
use App\Domain\Core\Id\CompanyPhotoId;
use Assert\AssertionFailedException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Uid\Uuid;

class AddCompanyPhotoCommandHandler implements MessageHandlerInterface
{
    private CompanyPhotoRepositoryInterface $companyPhotoRepository;

    public function __construct(
        CompanyPhotoRepositoryInterface $companyPhotoRepository
    ) {
        $this->companyPhotoRepository = $companyPhotoRepository;
    }

    /**
     * @throws AssertionFailedException
     */
    public function __invoke(AddCompanyPhotoCommand $command)
    {
        $companyPhotos = [];
        foreach ($command->getFiles() as $photo) {
            $photoId = new CompanyPhotoId((string) Uuid::v4());

            $fileName = md5(uniqid()).'.'.$photo->guessExtension();

            $photoPath = new PhotoPath($fileName);

            $photo->move(
                PhotoPath::PHOTO_DIR,
                $fileName
            );

            $companyPhotos[] = new CompanyPhoto(
                $photoId,
                $command->getCompany(),
                $photoPath,
                $photo->getClientOriginalName(),
                $photo->getClientMimeType()
            );
        }

        foreach ($companyPhotos as $photo) {
            $this->companyPhotoRepository->save($photo);
        }
    }
}
