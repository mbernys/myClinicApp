<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PatientFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $patient = new Patient();
        $patient->setFirstName('Jan');
        $patient->setLastName('Kowalski');
        $patient->setEmail('patient@patient.com');
        $patient->setPassword($this->passwordEncoder->encodePassword($patient,'password'));
        $patient->setRoles(['ROLE_USER','ROLE_PATIENT']);
        // $product = new Product();
        // $manager->persist($product);
        $manager->persist($patient);
        $manager->flush();
    }
}
