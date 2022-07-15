<?php
declare(strict_types=1);

namespace App\Application\Company\UseCase\Photo;

use App\Application\Company\Command\Photo\AddCompanyPhotoCommand;
use App\Domain\Company\Company;
use Symfony\Component\Messenger\MessageBusInterface;

class AddCompanyPhotoUseCase
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function execute(Company $company, array $data)
    {
        $this->messageBus->dispatch(AddCompanyPhotoCommand::withData($company, $data));
    }
}
