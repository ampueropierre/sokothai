<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(UserPasswordEncoderInterface $encoder, ParameterBagInterface $parameterBag)
    {
        $this->encoder = $encoder;
        $this->parameterBag = $parameterBag;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('admin@sokothai.fr');
        $user->setPassword($this->encoder->encodePassword($user,$this->parameterBag->get('user_password')));
        $manager->persist($user);

        for ($i = 1; $i <= 3; $i++) {
            $dateTime = new \DateTime('now');
            $event = new Event();
            $event->setName('Event0'.$i);
            $event->setUser($user);
            $event->setCreatedAt($i > 1 ? $dateTime->modify('+'.$i.' month') : $dateTime);
            $event->setUrlFacebook('https://www.facebook.com/');
            $manager->persist($event);
        }

        $manager->flush();
    }
}
