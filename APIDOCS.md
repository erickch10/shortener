# URL Shortener API Docs

Generates a short URL from a long one, also lists the most visited ones.

## Create a short URL

* **URL**

  /api/urls

* **Method:**

  `POST`

* **Headers**

  `Accept: application/json`
  `Content-type: application/json`

* **Data Params**

   **Required:**

   `long_Url=[string] Must be a valid URL and include the protocol (htto, https, etc.)`

* **Success Response:**

  * **Code:** 201 if the record didn't exist, 200 if it did <br />
    **Content:**
    ```javascript
    {
      "success": true,
      "data": {
        "id": 187,
        "long_url": "https://www.google.com",
        "short_url": "http://localhost/shortener/abc",
        "title": "Google",
        "created": "2019-06-28T23:10:07+00:00",
        "modified": "2019-06-28T23:10:07+00:00"
      }
    }
    ```

* **Error Response:**

 * **Code:** 422 UNPROCESSABLE ENTITY <br />
   **Content:**
   ```javascript
   {
      "success": false,
      "data": {
          "code": 422,
          "url": "/api/urls",
          "message": "A validation error occurred",
          "errorCount": number of errors,
          "errors": Object with the generated errors,
          "exception": {
              "class": "Crud\\Error\\Exception\\ValidationException",
              "code": 422,
              "message": "A validation error occurred"
          },
          "trace": Object with the error trace data
      }
   }
   ```

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/urls",
      contentType: "application/json",
      dataType: "json",
      type : "POST",
      data: {
        long_url: "http://www.google.com"
      },
      success : function(r) {
        console.log(r);
      }
    });
  ```

## Top visited
----
  Returns the list of registered URLs sorted from the most visited to the least

* **URL**

  /api/top-visited

* **Method:**

  `GET`

*  **URL Params**

   **Optional:**

   `limit=[integer] Number of items to retrieve, the default value is 100`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:**
    ```javascript
    {
      "success": true,
      "data": [
          {
              "id": 187,
              "long_url": "https://www.google.com",
              "title": "Google",
              "short_url": "http://localhost/shortener/abc",
              "visits": 300,
              "created": "2019-06-28T23:24:22+00:00",
              "modified": "2019-06-28T23:24:22+00:00"
          },
          {
              "id": 188,
              "long_url": "https://www.yahoo.com",
              "title": "Yahoo",
              "short_url": "http://localhost/shortener/bbc",
              "visits": 200,
              "created": "2019-06-28T23:10:07+00:00",
              "modified": "2019-06-28T23:10:07+00:00"
          },
          {
              "id": 189,
              "long_url": "https://www.youtube.com",
              "title": "YouTube",
              "short_url": "http://localhost/shortener/cbc",
              "visits": 100,
              "created": "2019-06-28T15:14:49+00:00",
              "modified": "2019-06-28T15:14:49+00:00"
          }
      ]
    }
    ```

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/top-visited",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
