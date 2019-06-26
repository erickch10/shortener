# URL Shortener Challenge

## How to install

After cloning the repository install dependencies from the root folder by running

```
composer install
```

Then run the database migrations

```
bin/cake migrations migrate
```

In case you face this error

```
bin/cake: command not found
```

You just need to set the right permissions for the bin/cake file with

```
chmod 755 bin/cake
```

After that you're good to go.
