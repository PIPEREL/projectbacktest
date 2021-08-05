# SYMPHONY 



## INSTALLATION

-- ouvrir un terminal
-- se rendre dans le dossier où l'on veut créer le projet (exemple ici : wamp www) : cd le chemin du dossier dans la console 
-- créer le projet avec composer (pas besoin de créer le dossier du projet)
-- utiliser la commande : composer create-project symfony/website-skeleton sublimmo

## GIT

-- créer un dépot GIT sur GitHub
-- avec un terminal , se rendre dans le dossier du projet (cd)
-- initialiser le dépot local : git init

-- lier le dépot local au dépot distant :

-- git remote add origin http://url_du_dépot_github

-- ajouter tous les fichier : 

- git add 
- git commit -m "message du commit"

-- récupérer les dernières modif : git pull origin master

envoyer les modifs :

    - git push origin master

voir la liste ds commits :

    cd-git log 



## RECUPERER UN PROJET :

-- telecharger le zip ou faire un pull
-- recréer le fichier . env à la racine du projet (avec ses propres informations);
-- les info importentes sont APP_ENV , APP_SECRET et DATABASE_URL (eventuellement MAILER_URL);
-- Mettre à jour le projet : 

    -composer install (ou composer update)

## ajouter un package
composer require symfony/apache-pack

apache pack crée une barre de débug / un routing et un fichier .htaccess

## ajouter uniquement a une vue (developpeur ici)

composer require --dev symfony/profiler-pack


## créer la bdd : 

 php bin/console doctrine:database:create
 
 changer le dossier .env : 

 DATABASE_URL="mysql://root@127.0.0.1:3306/sublimmo?serverVersion=5.7"


 ## créer un controller :

 php bin/console make:controller


 ## verifier si une route existe :

 php bin/console router:match /


 ## créer une table :

php bin/console make:entity


 ## dans le cas d'une relation :
 field type = relation.

 dans le formulaire : ->add("nomdelacleetrangere", EntityType::class, ["label"=> propriétaire/utilisateur, 'class' => NOMDELENTITY::class,  "choice_label" => "nomdelacolone"])

## créer une migration : 

php bin/console make:migration

## executer la migretion : 

php bin/console doctrine:migrations:migrate


## les différentes balises : 
{{ variable }}
{% function %}
{# commentaire #}p

## FIXTURES

necessite composer require --dev orm-fixtures

compléter le fichier src/dataFixtures/AppFixtures
-persist();
-flush();
-envoyer en bdd (en écrasant);

php bin/console doctrine:fixtures:load 

si tu veux ajouter a la suite ajouter --append


ajouter des jeux de données dans la bdd de facon fictive

bundle pour GENERER des données : 

composer require fakerphp/faker


## Filtre twig

-s'utilisent avec un pipe (|)
-stringEctension :

composer require twig/string-extra


## EMAIL

- l'email doit être validé en deux étapes
- generer un mdp pour application


- composer require symfony/swiftmailer-bundle

-.env : gmail://username:password@localhost

-créer le formulaire de contact
- créer le controller associé 
-afficher le formulaire dans une vue
-créer le template de mail 
-voir les mails dans la toolbar sans envoyer ? : (config/package/dev/web_profiler.yaml) => intercept_redirects : true

swiftmailer :

delivery_adresses ['adresse'] # forcer l'envoi de mail a certaines adress mail
disable_delivery : true # desactive l'envoi de mail


## commandes importantes: 


créer une page : php bin/console make:controller nomdelapage

requête depuis le terminal : php bin/console doctrine:query:sql "DELETE FROM maison where id = 25"


## le fichier twig : 

se trouve dans config, packages 
contient les variables globales 


## Les formulaires

créer un formulaire : php bin/console make:form

ajouter les add dans le form (dossier form)

dans le controler:
use app\Form\NomDuForm; 
-$form = $this->createForm(NomduFormdansledossierform::class);  
['NomAdonnerAuForm' => $form->createView()]


gestion du fichier a importer : 'constraint' => new File()


## recevoir un formulaire : 


dans le controller : 
use Symfony\Component\HttpFoundation\Request;

ajouter Request $request en paramètre de function

$form->handleRequest($request); pour verifier si la requête a été postée
voir contact controler.

créer un fichier dans template / dossier contenant le formulaire pour créer un format de mail



## CRUD
après avoir créé un objet en bdd
php bin/console make:crud Maison

## Router 

- voir toutes les routes :  php bin/console debug:router
- info sur une route : php bin/console router:match /url de la route

## créer le Login/user : 

- créer l'entité User : 

php bin/console make:user

- créer l'authentification :

php bin/console make:auth

aller dans src - security - fichier : implémenter la redirection (l-54)

créer l'inscription :

php bin/console make:registration-form

ajouter :  

 public function supports(Request $request): bool
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    après l'url generator dans security - fichier.


 ## rollerworks

composer require rollerworks/password-strength-bundle

# installer tailwind :

npm init

npm install tailwindcss postcss-cli autoprefixer -D 

ajouter /node_modules au git ignore

npx tailwind init tailwind.js -full

créer un postcss.config.js
et coller =>s
const tailwindcss = require('tailwindcss');
module.exports = {
    plugins: [
        tailwindcss('./tailwind.js'),
        require('autoprefixer')
    ],
};

créer un dossier dans public : tailwind.css 
et coller dedans :

npx postcss tailwind.css -o style.css

npx postcss public/css/tailwind.css -o public/css/style.css  // répéter cette ligne a chaque modif.