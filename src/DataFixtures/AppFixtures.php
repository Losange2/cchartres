<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $categorie = new \App\Entity\Categorie();
        $categorie->setNom('Football');
        $manager->persist($categorie);
        $categorie2 = new \App\Entity\Categorie();
        $categorie2->setNom('Rugby');
        $manager->persist($categorie2);
        $categorie3 = new \App\Entity\Categorie();
        $categorie3->setNom('Tennis');
        $manager->persist($categorie3);

        $niveau = new \App\Entity\Niveau();
        $niveau->setNom('Débutant');
        $manager->persist($niveau);
        $niveau2 = new \App\Entity\Niveau();
        $niveau2->setNom('Intermédiaire');
        $manager->persist($niveau2);
        $niveau3 = new \App\Entity\Niveau();
        $niveau3->setNom('Confirmé');
        $manager->persist($niveau3);
        $niveau4 = new \App\Entity\Niveau();
        $niveau4->setNom('Expert');
        $manager->persist($niveau4);

        $joueurs = [];
        for ($i = 0; $i < 4; $i++) {
            $joueur = new \App\Entity\Joueur();
            $joueur->setNom($faker->name());
            $joueur->setPrenom($faker->firstName());
            $joueur->setPhoto($faker->paragraph());
            $joueur->setDateDeNaissance($faker->dateTimeBetween('-40 years', '-18 years'));
            $joueur->setCategorieSportive($faker->randomElement([$categorie, $categorie2, $categorie3]));
            $joueur->setNiveau($faker->randomElement([$niveau, $niveau2, $niveau3, $niveau4]));
            $manager->persist($joueur);
            $joueurs[] = $joueur;
        }

        $utilisateur = new \App\Entity\User();
        $utilisateur->setEmail('admin@example.com');
        $utilisateur->setNom($faker->lastName());
        $utilisateur->setPrenom($faker->firstName());
        $utilisateur->setPassword(password_hash('admin', PASSWORD_BCRYPT));
        $utilisateur->setRoles(['ROLE_ADMIN']);
        $manager->persist($utilisateur);
        $utilisateur2 = new \App\Entity\User();
        $utilisateur2->setEmail('user@example.com');
        $utilisateur2->setNom($faker->lastName());
        $utilisateur2->setPrenom($faker->firstName());
        $utilisateur2->setPassword(password_hash('user', PASSWORD_BCRYPT));
        $utilisateur2->setRoles(['ROLE_USER']);
        $manager->persist($utilisateur2);

        $avis = [];
        for ($i = 0; $i < 4; $i++) {
            $avi = new \App\Entity\Avis();
            $avi->setCommentaire($faker->text(200));
            $avi->setNote($faker->numberBetween(1, 5));
            $avi->setJoueur($faker->randomElement($joueurs));
            $avi->setDateDeCreation($faker->dateTimeBetween('-1 years', 'now'));
            $avi->setUtilisateur($faker->randomElement([$utilisateur, $utilisateur2]));
            $manager->persist($avi);
            $avis[] = $avi;
        }

        $manager->flush();
    }
}
