# Blog API

This Blog API is built on top of Laravel 11. It is simple and straightfoward, even thougth I built this for educational purposes it can be used as a personal blog or small community hub as it also features comments.

## Features

The API is controlled only by the users with that are administrator, but it has authentication pages so non administrator users can register, comment and discuss about the posts.

-   **Posts:** Users can read posts that are published, the post model has an `is_draft` field to identify which posts are published or not. Only administrators users can manage posts.
-   **Categories:** Users can see categories, but only administrators can manage them.
-   **Comments:** Authenticated/Registeres users can comment on any posts, only owners or administrators can modify comments or delete them.

## Creation process

Here you can see a list of the best practices or standars I followed while I was creating this basic Blog API.

-   **Cruddy By Design**
-   **Services Classes**
-   **Data Transfer Objects**
-   **Scopes**
-   **Policies**
-   **Enums**

## Use it

Feel free to clone the repository and thinker with this API. In the root of the project you can find a `thunder-collection.json` file so you can have all the endpoints of the application and test it.

If you have problems with CSRF Token you can either disabled CSRF protection or create a Thunder Client environment with a `XSRF-TOKEN` variable. The configuration I included should create the token itself.

If you find any problems, feel free to open an Github Issue and I'll respond as soon as I can.
