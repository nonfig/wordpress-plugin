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
./vendor/bin/phpcbf ./admin --standard=PSR2 --extensions=php
```

the example above only validates `/admin` folder. Essentially, we will validate everything.

You would have wordpress running on port: `7777` and volume at `~/nonfig-wordpress` directory.

# Author

The package is maintained by Nonfig and open for public contributions.