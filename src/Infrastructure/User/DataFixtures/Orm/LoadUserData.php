<?php
declare(strict_types=1);
namespace App\Infrastructure\User\DataFixtures\Orm;

use App\Domain\Core\Id\UserId;
use App\Domain\User\UserInterface;
use App\Infrastructure\User\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadUserData extends Fixture implements ContainerAwareInterface, OrderedFixtureInterface
{

    public const USER_ID = '22200000-0000-474c-b092-b0dd880c07e2';
    public const USER_USERNAME = 'user@email.com';
    public const USER_PASSWORD = 'password';

    public const USER1_ID = '22200000-0000-474c-b092-b0dd830c07e1';
    public const USER1_USERNAME = 'user1@email.com';
    public const USER1_PASSWORD = 'password';

    private ContainerInterface $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null): void
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
    {
        $user = $this->createUser(
            self::USER_ID,
            self::USER_USERNAME,
            self::USER_PASSWORD,
        );

        $manager->persist($user);
        $manager->flush();

//        $user1 = $this->createUser(
//            self::USER1_ID,
//            self::USER1_USERNAME,
//            self::USER1_PASSWORD,
//        );
//
//        $manager->persist($user1);
//
//        $manager->flush();
    }

    /**
     * @throws \Exception|\Assert\AssertionFailedException
     */
    protected function createUser(string $id, string $email, string $plainPassword): UserInterface
    {
        $user = new User(new UserId($id));
        $user->setPassword($plainPassword);
        $user->setEmail($email);
        $user->setFirstName('userName');
        $user->setLastName('lastName');
        $password = $this->container->get('security.password_encoder')
            ->encodePassword($user, $user->getPassword());
        $user->setPassword($password);

        return $user;
    }
    /**
     * {@inheritdoc}
     */
    public function getOrder(): int
    {
        return 3;
    }
}
