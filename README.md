[![CircleCI](https://circleci.com/gh/nonfig/wordpress-plugin/tree/master.svg?style=shield)](https://circleci.com/gh/nonfig/wordpress-plugin/tree/master)

# Nonfig for Wordpress

Nonfig has built-in support for Wordpress. You can now empower your web platforms by integrating Nonfig directly into wordpress using ShortCode API.

Nonfig will remove the need of providing access to your wordpress site. Every content and configuration would now be inside centralized workspace, yet still integrated everywhere.

# Developer


To run wordpress locally for developing the plugin, please run the following command with your local docker installation:

## Running Locally

```
docker-compose -f stack.yml up
```

## Lint and Style

We are using PHP Code Sniffer (phpcs) to lint the code and `phpcbf` to automatically fix the suggestions as well. To writing, we are using `PSR2` standard that may change overtime.

```
composer global require "wp-coding-standards/wpcs"
./vendor/bin/phpcs --config-set installed_paths $HOME/.composer/vendor/wp-coding-standards/wpcs
./vendor/bin/phpcs --config-set default_standard WordPress-Extra
 ./vendor/bin/phpcbf ./admin --extensions=php --standard=Wordpress-Extra
```

the example above only validates `/admin` folder. Essentially, we will validate everything.

You would have wordpress running on port: `7777` and volume at `~/nonfig-wordpress` directory.

# Contributors

The package is maintained by Nonfig and open for public contributions. You can get to know a feature today:

- [@Azim Khan](https://github.com/akhan24)
- [@Arkeologen](https://github.com/arkeologen)