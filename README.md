# POC: Laravel React incremental adoption

This repo is meant to be a proof of concept for the adoption of the React framework on top of the Laravel framework using Inertia.js.

The whole process needed to include a framework such as React in a Laravel application is fully described between the [Laravel documentation](https://laravel.com/docs/10.x) itself and [Inertia's docs](https://inertiajs.com/).

Special thanks to [David Gryzb](https://www.youtube.com/@DavidGrzyb) who's [video](https://www.youtube.com/watch?v=Yp4SifzmRu4) helped me a lot!

## Prologue

You have a Laravel application. That's all. Prologue finished.

[This](https://laravel.com/docs/10.x#your-first-laravel-project) might help yuo to get there.

## Chapter 1 - Database in the belly of the whale

You guessed it: let's start a database using docker. I'm using a docker-compose.yaml file for this in order to easily point towards my env variables.

The docker-compose file is going to store the db data in the repo, let's add the folder to the .gitignore file.
