# PHPUnit: Testing with a Bite

Well hi there! This repository holds the code and script
for the [PHPUnit: Testing with a Bite](https://knpuniversity.com/screencast/phpunit) course on KnpUniversity.

## Setup

If you've just downloaded the code, congratulations!

To get it working, follow these steps:

**Setup parameters.yml**

First, make sure you have an `app/config/parameters.yml`
file (you should). If you don't, copy `app/config/parameters.yml.dist`
to get it.

Next, look at the configuration and make any adjustments you
need (like `database_password`).

**Download Composer dependencies**

Make sure you have [Composer installed](https://getcomposer.org/download/)
and then run:

```
composer install
```

You may alternatively need to run `php composer.phar install`, depending
on how you installed Composer.

**Setup the Database**

Again, make sure `app/config/parameters.yml` is setup
for your computer. Then, create the database and the
schema!

```
php bin/console doctrine:database:create
```

If you get an error that the database exists, that should
be ok. But if you have problems, completely drop the
database (`doctrine:database:drop --force`) and try again.

**Start the built-in web server**

You can use Nginx or Apache, but the built-in web server works
great:

```
php bin/console server:run
# using instead:
bin/mydockerRoot.sh symfony serve
```

Now check out the site at `http://localhost:8000`

Have fun!

**(optional) Add bash alias for better DX**

For better DX to avoid having to use `./vendor/bin/phpunit` all the time create a bash alias:

Up with composer memory limit to stop out of memory error: add `-e COMPOSER_MEMORY_LIMIT=-1 `
in the docker run command.

```bash  
alias phpunit=./vendor/bin/phpunit

bin/mydocker.sh vendor/bin/simple-phpunit

```

From now on you will be able to run local PHPUnit from your project directory by executing `phpunit` command. Add alias command to your bash profile if you don't want to run it every time you enter a new terminal.
## Integraion tests
WIth phpunit8 correct tearDown method in class KernelTestCase by adding return type `void` and run as usual.

To make deprecation warning dissapear:

https://stackoverflow.com/questions/58975182/deprecation-doctrine-orm-mapping-underscorenamingstrategy-without-making-it-num


## Have Ideas, Feedback or an Issue?

If you have suggestions or questions, please feel free to
open an issue on this repository or comment on the course
itself. We're watching both :).

## Thanks!

And as always, thanks so much for your support and letting
us do what we love!

<3 Your friends at KnpUniversity
