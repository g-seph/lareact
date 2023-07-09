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

## Chapter 2 - Tailwind CSS

I'm growing to like Tailwind CSS a lot.

[Here](https://tailwindcss.com/docs/guides/laravel)'s how you can use it in a Laravel application.

Now that I think about it... I haven't run npm install yet.

```shell
npm install
```

## Chapter 3 - Some pages for Laravel

Let's add a register feature, a login feature and a user details page.

## Chapter 4 - Inertia && React installation

I can't suggest [this video](https://www.youtube.com/watch?v=Yp4SifzmRu4) enough (a video I already linked before). It shows the process applied with Vue3, but most of the principles are valid for React too.

Dependency installation

```shell
npm install --save-dev @vitejs/plugin-react
npm install react react-dom
npm install @inertiajs/react
composer require inertiajs/inertia-laravel
```

Include the React plugin in the vite.config.js file as per [Laravel documentation](https://laravel.com/docs/10.x/vite#react).

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react'; //this line
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true, //this line
        }),
        react()
    ],
});
```

Create a root template in resources/views named app.blade.php using the @vite helper to load css and js.

Now let's generate the Inertia middleware and let's include it in the app/Http/Kernel.php file. It's important that the newly generated middleware is placed as the last item in the $middlewareGroups['web'] array.

```shell
php artisan inertia:middleware
```

```php
    // ...
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\HandleInertiaRequests::class, // <- this line
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];
    //...
```

Now let's initialize Inertia.

I don't like deleting the app.js file in favour of the app.jsx file used for React, so let's add it.

[Laravel's docs](https://laravel.com/docs/10.x/vite#inertia) are helpful once again, even tho we are using React and not Vue, so we got to edit something.

```jsx
import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";

createInertiaApp({
    resolve: name => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />)
    },
})
```

Now we are resolving paths such as resources/js/Pages/... for our Reacts components.

## Chapter 5 - A simple Inertia rendered page

Now let's build a page using React. This is going to be a simple feature: a page that displays the user's name and has a simple message.

In resources/js/Pages/Inertia/ReactComponent.jsx

```jsx
import {Head} from '@inertiajs/react';

export default function ReactComponent({message, user}) {
    console.log("HELLO");
    return (
        <>
            <Head title="Welcome"/>
            <h1>Welcome</h1>
            <p>Hello {user?.name}, welcome to your first Inertia app!</p>
        </>
    )
}
```

In routes/web.php we add this route

```php
Route::get('/inertia', function() {
    $user = \Illuminate\Support\Facades\Auth::user();
    if (is_null($user))
            return redirect()->route('home.page')->with(
                [
                    'errors' => new \Illuminate\Support\Collection(['Must be logged in'])
                ]
            );
    return \Inertia\Inertia::render('Inertia/ReactComponent', [
        'message' => "Hello from React",
        'user' => $user
    ]);
})->name('inertia.page');
```

As we can see, with the Inertia::render helper method we can render a React component in the specified path (resources/js/Pages) and pass props.
