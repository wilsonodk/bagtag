# Rank Card

The Atlanta Metro Area X-Wing Community uses Rank Cards as a way to have friendly competative play
all year round. The concept of Rank Cards are borrowed from Disc Golf's Bag Tag system. This web
app is to facilitate easier tracking of who has which Rank Card at a given time.

Players create Challenges, which can be between any number of people. A friendly game at the kitchen
table would most likely be between two players. A competative event, such as a Store Championship,
would include lots of players. When the game is over, one of the players (or TO) simply orders the
players by their finishing places (first place on top, last place on bottom). The app then determines
who gets which Rank Card. The app knows which rank cards were available, so it can properly sort them 
out.


## Application Concepts

There are three classes: 

Player
    The Player class tracks the current rank of the player. Players can be associated with one or
    more Stores.

Store
    The Store class tracks general information about the Store to facilitate easier discovery.

Challenge
    The Challenge class tracks which Players where involved in a Challenge, and on what day.


## Contributing

Rank Cards was built using [Symfony][sf] 2.7 and [Bootstrap][bs]/[Bootswatch][bw] 3, using the Flatly
theme. It runs with PHP 5.3 and Postgres 9.4.

Pull requests welcome, but please follow these guidelines:

* Use [editorconfig][ec] in your IDE.

* Indicate if your PR needs to have `php bin/console doctrine:schema:update --force` run.

* You can run the server locally with `php bin/console server:run`.


## Change Log

See [releases][re].


## Author

Wilson 



[sf]: http://symfony.com/
[bs]: http://getbootstrap.com/
[bw]: http://bootswatch.com/
[ec]: http://editorconfig.org/
[re]: releases
