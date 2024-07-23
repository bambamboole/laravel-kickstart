<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Laravel Kickstart
This project is in an early stage development and is changing rapidly currently.  
This repository contains an initial setup for a Laravel project with an opinionated workflow to kickstart your next Laravel project.

If you are also thinking, that the existing start kits are not fitting your needs, then this might be the right place for you.  
I am looking for support and feedback to make this project better and more useful for everyone.

## Stack
- Laravel 11
- Inertia.js with Vue.js in the Frontend
- Tailwind CSS for styling
- Laravel Sanctum for API authentication and authorization
- Laravel Reverb for broadcasting Events via Websockets and Laravel Echo for listening to them

## Features
- Multi tenant capable setup where users can be in multiple projects
- Manage invitations for Projects
- Projects have API tokens for authentication which are independent from users. This allows for easier handling while offboarding members
- Permission management via roles where a user can have one role per project. Permissions are defined in code, while roles are living in the database and are acting as container for permissions
- Server side controlled Sidebar items for the frontend
- Server side triggerable toast messages via `->with('success', 'The message')` on the response
- Sophisticated translation workflow via two packages from me: `bambamboole/laravel-translation-dumper` and `bambamboole/laravel-i18next`.
Every executed translation in PHP and Javascript will be dumped automatically in the translation files.
- Full Vue test setup with coverage support 
- Code lint setup via PHP-CS-Fixer and Prettier for PHP, Blade, Javascript and Tailwind class sorting

## Installation
1. Clone the repository
2. Copy the `.env.example` to `.env` and adjust the settings
3. Run `composer install`
4. Run `php artisan key:generate`
5. Run `npm install`
6. Run `npm run dev`
7. Run `php artisan reverb:start`

## Todos
Feel free to contribute to this project. Here are some ideas for the next steps:
- Make API abilities dynamic
- Add API endpoints for managing invitations and members
- Replace all hard coded strings with translations
- Add more tests
- Make readme more detailed
- Add two factor authentication (multiple devices per user)
- Add CI/CD setup for PHP and Javascript
- Add codecov for code coverage
- Make better design with own logo and color scheme (urgently Help needed)
- add full german(de) translation.

## Ideas
These are some ideas which are not yet planned but could be interesting for the future. If you are interested in one of these, feel free to hit me up to discuss, for sure also with other ideas.
- Make the whole starter kit an installable package which can publish all the needed files and setup the project
- yubikey support for two factor authentication
- ??? Your idea ???

## License

The Laravel Kickstart project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
