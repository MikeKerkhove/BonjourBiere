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

# How to use

When the project is running, you have a nav menu at the top. You can browse these pages with.
All the day at 10am, a new picture is posted.
You can see old post with the pagination under the picture.
For the administrator, you can go on Login page to manage this site. Use the username 'vlabs' and the password is 'admin'.
On this page, you can see all the picture in the database. You can validated, delete the pictures and see all administrator accounts.


# License

No license here :)



