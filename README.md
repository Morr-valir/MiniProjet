# Mini projet symfony

Projet : création d'une pateforme de gestion automobile sous symfony 5

## Environnement de développement

### Pré-requis

- PHP 7.4
- Composer
- Symfony CLI

### Procedure d'installation Projet

Vous pouvez vérifier les pré-requis (sauf Docker et Docker-compose) avec la commande suivante (de la CLI symfony) :

```bash
symfony check:requirements
```

### Lancer l'environnement de développement

```bash
composer install
symfony console doctrine:migration:migrate
symfony serve:start
```

# EasyAdmin

### Acces au Bashboard

La route du dashboard : /admin

- Login : admin
- Password : admin
