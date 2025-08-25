<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    # Création d'un utilisateur administrateur avec le nom d'utilisateur 'admin' et le mot de passe 'password' et le rôle 'ROLE_ADMIN'
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setRoles(['ROLE_ADMIN']);
        
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'password'
        );
        $user->setPassword($hashedPassword);

        $manager->persist($user);
        $manager->flush();
    }
}
