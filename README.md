# Mini projet symfony

Projet : création d'une pateforme de gestion automobile sous symfony 5

## Environnement de développement

### Pré-requis

- PHP 7.4
- Composer
- Symfony CLI

### Procedure d'installation Projet

Vous pouvez vérifier les pré-requis (sauf Docker et Docker-compose) avec la commande suivante (de la CLI symfony) :

afin d'avoir acces à votre configuration en dev sur votre machine local :

- crée un fichier .env.dev à la racine de votre du projet
- copier la ligne suivante dans le fichier précedament crée avec vos identifiant de BDD :
  DATABASE_URL="mysql://user:password@127.0.0.1:3306/database?serverVersion=5.7"

```bash
symfony check:requirements
composer install
symfony console doctrine:database:create
symfony console doctrine:migration:migrate
```

### Lancer l'environnement de développement

```bash
symfony serve:start
```

# EasyAdmin

### Acces au Bashboard

La route du dashboard : /admin

- Login : admin
- Password : admin
