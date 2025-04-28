# Application de Chat en PHP

Une application de chat simple et sécurisée permettant aux utilisateurs de communiquer en temps réel.

## Fonctionnalités

- 💬 Chat public et messages privés
- 🔐 Système d'authentification sécurisé
- 👥 Gestion des utilisateurs (inscription/connexion)
- 🔑 Système de modification et expiration des mots de passe
- 🎨 Interface responsive et moderne

## Configuration requise

- PHP 7.0+
- MySQL/MariaDB
- Serveur web (Apache/Nginx)
- XAMPP (recommandé pour le développement)

## Installation

1. Clonez ce dépôt dans votre répertoire web (ex: htdocs pour XAMPP)
2. Créez une base de données MySQL nommée `chat`
3. Importez la structure de la base de données (fichier SQL à venir)
4. Configurez les paramètres de connexion à la base de données dans les fichiers PHP si nécessaire:
```php
$id = mysqli_connect("localhost", "root", "", "chat");
```

## Structure de la base de données

### Table `user`
- id (INT, AUTO_INCREMENT)
- nom (VARCHAR)
- prenom (VARCHAR)
- mail (VARCHAR)
- mdp (VARCHAR)
- role (INT)
- modif_mdp (DATETIME)

### Table `messages`
- id (INT, AUTO_INCREMENT)
- pseudo (VARCHAR)
- message (TEXT)
- date (DATETIME)
- destinataire (VARCHAR)

## Sécurité

- Mots de passe hachés avec BCRYPT
- Protection contre les injections SQL
- Gestion des sessions
- Validation des mots de passe avec critères de complexité

## Fichiers principaux

- `connexion.php` : Page de connexion
- `inscription.php` : Page d'inscription
- `chat.php` : Interface principale du chat
- `change_mdp.php` : Modification du mot de passe
- `logout.php` : Déconnexion
- `style.css` : Styles de l'application

## Auteur

konan Othniel kouakou

