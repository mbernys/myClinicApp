<?php

namespace App\DataFixtures;

use App\Entity\Doctor;
use App\Entity\Patient;
use App\Entity\Specialization;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DoctorFixture extends Fixture implements DependentFixtureInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $doctor1 = new Doctor();
        $doctor1->setFirstName('Justyna');
        $doctor1->setLastName('Wrona');
        $doctor1->setEmail('doctor1@doctor.com');
        $doctor1->setPassword($this->passwordEncoder->encodePassword($doctor1,'password'));
        $doctor1->setSpecialization($this->getReference(SpecializationFixture::REF_KARDIOLOG));
        $doctor1->setRoles(['ROLE_USER','ROLE_DOCTOR']);
        $manager->persist($doctor1);


        $doctor2 = new Doctor();
        $doctor2->setFirstName('Justyna');
        $doctor2->setLastName('Wrona');
        $doctor2->setEmail('doctor2@doctor.com');
        $doctor2->setPassword($this->passwordEncoder->encodePassword($doctor2,'password'));
        $doctor2->setSpecialization($this->getReference(SpecializationFixture::REF_UROLOG));
        $doctor2->setRoles(['ROLE_USER','ROLE_DOCTOR']);
        $manager->persist($doctor2);

        $doctor3 = new Doctor();
        $doctor3->setFirstName('Justyna');
        $doctor3->setLastName('Wrona');
        $doctor3->setEmail('doctor3@doctor.com');
        $doctor3->setPassword($this->passwordEncoder->encodePassword($doctor3,'password'));
        $doctor3->setSpecialization($this->getReference(SpecializationFixture::REF_GINEKOLOG));
        $doctor3->setRoles(['ROLE_USER','ROLE_DOCTOR']);
        $manager->persist($doctor3);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [SpecializationFixture::class];
    }
}
