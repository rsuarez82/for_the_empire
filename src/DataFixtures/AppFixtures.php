<?php

namespace App\DataFixtures;

use App\Entity\Courses;
use App\Entity\Participants;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Random\Randomizer;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $shootingForDummies = new Courses();
        $shootingForDummies->setTitle('Shooting for Dummies');
        $shootingForDummies->setFreeSlots(5);
        $shootingForDummies->setDescription('A lot of PewPew!');
        $shootingForDummies->setCourseLeader('Trooper PewPew');
        $shootingForDummies->setContent('Learn how to shoot rebels like a pro! Save the empire today!');
        $shootingForDummies->setCourseDate(new \DateTime('2025-01-05 14:00'));

        $tieFighterManouvering = new Courses();
        $tieFighterManouvering->setTitle('Tie Fighter Manouvering');
        $tieFighterManouvering->setFreeSlots(2);
        $tieFighterManouvering->setDescription('Get winded!');
        $tieFighterManouvering->setCourseLeader('Super-Pilot Bob');
        $tieFighterManouvering->setContent('Were gonna make a flying ace of you in no time!');
        $tieFighterManouvering->setCourseDate(new \DateTime('2025-05-01 11:00'));

        $planetaryDestruction = new Courses();
        $planetaryDestruction->setTitle('How to blow up Planets like a Pro');
        $planetaryDestruction->setFreeSlots(10);
        $planetaryDestruction->setDescription('Subatomar fun for Everyone');
        $planetaryDestruction->setCourseLeader('The Emperor');
        $planetaryDestruction->setContent('Say goodbye to rebel scum planets now! Lets blow up some stellar objects!');
        $planetaryDestruction->setCourseDate(new \DateTime('2026-12-12 11:00'));

        $forceOrChoke = new Courses();
        $forceOrChoke->setTitle('May the forth be with you LOL');
        $forceOrChoke->setFreeSlots(1000);
        $forceOrChoke->setDescription('Midichlorians hate these tricks');
        $forceOrChoke->setCourseLeader('Darth Vader');
        $forceOrChoke->setContent('Use the force to choke, electrocute or brew fantastic coffee!');
        $forceOrChoke->setCourseDate(new \DateTime('2025-05-04 10:00'));

        $manager->persist($shootingForDummies);
        $manager->persist($tieFighterManouvering);
        $manager->persist($planetaryDestruction);
        $manager->persist($forceOrChoke);

        $trooperBob = new Participants();
        $trooperBob->setUnit('Navy');
        $trooperBob->setPassword(crypt('flyMeToTheM00n!', (new Randomizer())->getBytes(64)));
        $trooperBob->setEmail('trooper-bob@aol.com');
        $trooperBob->setLastname('Trooper');
        $trooperBob->setFirstname('Bob');

        $trooperPewPew = new Participants();
        $trooperPewPew->setUnit('Infantry');
        $trooperPewPew->setPassword(crypt('pleaseDontShootMe_111', (new Randomizer())->getBytes(64)));
        $trooperPewPew->setEmail('pewpewtrooper@compuserve.net');
        $trooperPewPew->setLastname('Trooper');
        $trooperPewPew->setFirstname('PewPew');

        $emperorPalpatine = new Participants();
        $emperorPalpatine->setUnit('Command');
        $emperorPalpatine->setPassword(crypt('PalpatineIsAwesome1337', (new Randomizer())->getBytes(64)));
        $emperorPalpatine->setEmail('mrdarkside@yahoo.com');
        $emperorPalpatine->setLastname('Palpatine');
        $emperorPalpatine->setFirstname('Emperor');

        $darthVader = new Participants();
        $darthVader->setUnit('Command');
        $darthVader->setPassword(crypt('LukeIAmURDad101', (new Randomizer())->getBytes(64)));
        $darthVader->setEmail('notyourdad73@lycos.com');
        $darthVader->setLastname('Vader');
        $darthVader->setFirstname('Darth');

        $manager->persist($trooperBob);
        $manager->persist($trooperPewPew);
        $manager->persist($emperorPalpatine);
        $manager->persist($darthVader);

        $manager->flush();
    }
}
