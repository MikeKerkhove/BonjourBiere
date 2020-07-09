# Bonjour La Bière


Just a little site called 'Bonjour la bière' for learn to code in Symfony.

# Tech/framework used

* PHP
    * Symfony

* TWIG

* Bootstrap

# Installation

* Prerequisite
    * PHP 7.4 or <
    * Symfony CLI

* Clone this repo GIT over https
`git clone https://github.com/MikeKerkhove/BonjourBiere.git`

* Go to the freshly cloned folder

* Install dependencies
`composer install`

* Run this project
`symfony server:start --no-tls`

* Create DB
`php bin/console doctrine:migrations:migrate`

* Feed DB
`php bin/console doctrine:fixtures:load`

# Route Reference

* '/' or '/page/{number}' : Home page with pagination
* '/new' : Form page to suggest a new picture to administrator
* '/about' : Just a simple page to say who are they.
* '/admin' : Administration page for manage all the pics. (NEED AUTH.)
* '/post/create' : Route in post method to create a new suggestion of picture.
* '/post/update' : Route to update picture.
* '/post/delete/{id}' : Route to delete picture by his ID.
* '/get/all' : Route to get all the pics.
* '/get/{id} : Route to get one picture with his ID.

# How to use

When the project is running, you have a nav menu at the top. You can browse these pages with.
All the day at 10am, a new picture is posted (not yet implemented).
You can see old post with the pagination under the picture.
For the administrator, you can go on Login page to manage this site. Use the username 'Admin' and the password is 'AZERTY'.
On this page, you can see all the picture in the database. You can modified picture's informations (not yet implemented) and delete pictures.


# License

No license here :)



