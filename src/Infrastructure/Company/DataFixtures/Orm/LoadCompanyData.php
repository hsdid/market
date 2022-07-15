<?php
declare(strict_types=1);
namespace App\Infrastructure\Company\DataFixtures\Orm;

use App\Domain\Company\Company;
use App\Domain\Company\ValueObject\Address;
use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Id\UserId;
use App\Domain\User\UserInterface;
use App\Infrastructure\User\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadCompanyData extends Fixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    public const COMPANY_ID = '22200000-0000-474c-b092-b1dd880c05e3';
    public const COMPANY_USER_ID = '22200000-0000-474c-b092-b0dd880c07e1';
    public const COMPANY_USER_USERNAME = 'user1@email.com';
    public const COMPANY_USER_PASSWORD = 'password';
    private ContainerInterface $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User(new UserId(self::COMPANY_ID));
        $user->setPassword(self::COMPANY_USER_PASSWORD);
        $user->setEmail(self::COMPANY_USER_USERNAME);
        $user->setFirstName('userName');
        $user->setLastName('lastName');
        $password = $this->container->get('security.password_encoder')
            ->encodePassword($user, $user->getPassword());
        $user->setPassword($password);

        $manager->persist($user);

        $company = $this->createCompany(self::COMPANY_ID, $user);
        $manager->persist($company);
        $manager->flush();
    }

    protected function createCompany(string $id, UserInterface $user): Company
    {
        $company = new Company(
            new CompanyId($id),
            $user,
            'Comaony name',
            'Comapny desc',
            new Address(
                'Podlaskie',
                'Bialystok',
                null,
                null,
                null
            ),
            true,
        );
        return $company;
    }


    public function getOrder(): int
    {
        return 3;
    }
}