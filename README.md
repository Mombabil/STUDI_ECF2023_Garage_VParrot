# STUDI ECF2023 Garage VParrot

## LE PROJET Garage automobile

Vincent Parrot, fort de ses 15 années d'expérience dans la réparation automobile, a ouvert 
son propre garage à Toulouse en 2021.

Depuis 2 ans, il propose une large gamme de services: réparation de la carrosserie et de la 
mécanique des voitures ainsi que leur entretien régulier pour garantir leur performance et 
leur sécurité. De plus, le Garage V. Parrot met en vente des véhicules d'occasion afin 
d'accroître son chiffre d'affaires.

Vincent Parrot considère son atelier comme un véritable lieu de confiance pour ses clients et 
leurs voitures doivent, selon lui, à tout prix être entre de bonnes mains. 

Bien qu'il fournisse grâce à ses employés un service de qualité et personnalisé à chaque 
client, Vincent Parrot reconnaît qu'il doit être visible sur internet s'il veut se faire 
définitivement une place parmi la concurrence. Il a donc contacté l’agence de création de 
sites web dont vous faites partie pour un premier devis, qu'il a accepté. 

Vous aurez alors pour mission de créer une application web vitrine pour le Garage V. Parrot, 
en mettant en avant la qualité des services délivrés par cette récente entreprise.

## Prérequis

- PHP 7.4 ou ultérieur
- Composer
- MySQL
- Symfony
- Twig
- Javascript
- Ajax

## Installation

- Clonez le projet : git clone https://github.com/Mombabil/STUDI_ECF2023_Garage_VParrot.git
- Installez les dépendances : composer install
- dans le fichier .env, commentez DATABASE_URL="mysql://302852:3FPgmA3i2T!aFAK@mysql-perret-morgan.alwaysdata.net:3306/perret-morgan_ecf2023_garage_vparrot"
- dans le fichier .env, décommentez DATABASE_URL="mysql://root@127.0.0.1:3306/ecf-projet-garage" (avec vos identifiants si différent)
- Créez la base de données : php bin/console doctrine:database:create
- Exécutez les migrations : php bin/console doctrine:migrations:migrate
Lancez le serveur : "symfony serve" ou "symfony server:start" Le projet sera accessible à l'adresse http://localhost:8000/.

## Creation d'un admin
- Rendez-vous sur php-my admin apres avoir executé les commandes d'installation
- dans la table ecf-projet-garage, aller dans SQL  et saisissez la commande : INSERT INTO user (id, email, name, firstname, roles, password) VALUES (NULL, 'vparrot@gmail.com', 'vincent', 'parrot', '["ROLE_ADMIN"]', '$2y$13$2rM7h40tbCdpaidunDPxQuvtnrPBC5Iy5uH/DTt7akxBTkfuUmzdW')
mot de passe : 123
- Attention, si le mot de passe ne fonctionne pas, vous pouvez utiliser cette commande dans votre IDE : symfony console security:hash-password vous allez générer un mot de passe haché qu'il faudra remplacer.

## Connection
Puisqu'il s'agit d'un garage automobile, seul l'administrateur et les employés on accès a l'espace de connexion,
j'ai donc choisi de ne pas afficher de bouton de connexion. Pour se connecter, rendez-vous à l'adresse : 
https://ecf-studi-garage-vparrot-91064023dde2.herokuapp.com/login
l'identifiant que vous avez du créer en suivant ce guide est : 
- vparrot@gmail.com
le mot de passe est :
- 123

ou si vous êtes en local :
http://localhost:8000/login

## Maquette Adobe XD
Vous pouvez retrouver au format png la charte graphique et les mockup de la page d'accueil au format desktop et mobile dans le dossier documents.
Sinon, vous pouvez retrouver la présentation de la maquette sur le lien : 
https://xd.adobe.com/view/f1aefe52-7f67-42a0-a641-beee3227e48f-a4fd/screen/2b6612e7-b1fc-41a2-a6f4-c508bad07e3e
La maquette est interactive et vous pouvez tester la navbar au format mobile ainsi que le caroussel

## Visiter le site
L'adresse du site et les identifiants sont tous dans le modèle de copie rendu avec l'evaluation

## Trello
Vous pouvez retrouver le trello que j'ai utilisé a cette adresse : https://trello.com/b/hUuhZCMm/ecf-sujet-garage




