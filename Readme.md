
# Installation du projet
Voici les étapes pour installer le projet sur votre machine locale.

Prérequis
PHP 7.4 ou supérieur
Composer
Symfony CLI
Un serveur de base de données (MySQL, PostgreSQL, etc.)

Étapes d'installation

1. Clonez le dépôt Git sur votre machine locale en utilisant la commande suivante :

    ```bash
    git clone [url du dépôt]
    ```

2. Naviguez vers le répertoire cloné :

    ```bash
    cd [nom du répertoire]
    ```

3. Installez les dépendances du projet en exécutant la commande suivante :

    ```bash
    composer install
    ```

4. Configurez votre base de données en modifiant le fichier `.env` avec les informations de connexion appropriées.

5. Générez les tables de la base de données en exécutant la commande suivante :

    ```bash
    php bin/console doctrine:migrations:migrate
    ```

6. Générez la fixture en exécutant la commande suivante :

    ```bash
    php bin/console doctrine:fixtures:load
    ```

8. Lancez le serveur de développement en exécutant la commande suivante :

    ```bash
    symfony server:start    
    ```

8. Accédez à l'application dans votre navigateur en utilisant l'URL suivante :

    ```
    http://localhost:8000

9. Ajouter le ROLE_COACH dans la base pour acceder aux fonctionnalitées
  


