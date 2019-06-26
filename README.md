# URL Shortener Challenge

This is a URL shortening API built using **CakePHP** framework alongside the **frindsofcake/crud** library which is a library that sets up crud CakePHP actions with the possibility of generating a REST API.

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

## Challenges

The only challenge found during the process was, when receiving a post request to shorten a URL, making the API to return the database record in case the URL already existed there. Since the endpoint was created with a third party library, its documentation wasn't clear on how to call an action manually.

## Design decisions

The two most common ways to generate a short URL were:

1. Generate a random string with a set of characters and a determined length and associate it to the URL. Ensure the uniqueness of the short URL, the obtained string has to be checked against the database and create a new one in case it exists.

2. Insert the URL in the database if it doesn't exst. Then take the generated **id** and convert the value to base 62 (the cmost common case using lower and upper case characters and numbers) string.

The process was made using the second option since it requires less database queries.

Additionally the base 62 encoding and the fetching of the URL's title were implemented in utility classes separated from the controllers and models to ensure the separation of concerns.

## Future improvements

- Personalize the response in case an invalid short URL is provided.
- Validate the input of the base 62 encoding/decoding functions.
