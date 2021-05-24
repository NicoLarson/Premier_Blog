# Premier_Blog [![SymfonyInsight](https://insight.symfony.com/projects/80c2e91e-263b-4803-bf02-45562fce5233/small.svg)](https://insight.symfony.com/projects/80c2e91e-263b-4803-bf02-45562fce5233)

## Requirements
- PHP 8 or higer;
- [Symfony](https://symfony.com/doc/current/setup.html)

## Installation
### Clone the project
```bash
git clone https://github.com/NicoLarson/Premier_Blog.git
```

### SMTP
#### Install [MailDev](https://github.com/maildev/maildev)
```bash=
npm install -g maildev
```
#### Use
```bash=
maildev --hide-extensions STARTTLS
```
Web app on http://localhost:1080.

## Usage
There's no need to configure anything to run the application. If you have installed Symfony binary, run this command:

``` bash
cd Premier_Blog/
symfony serve
``` 

Then access the application in your browser at the given URL (https://localhost:8000 by default).

If you don't have the Symfony binary installed, run:
```
php -S localhost:8000 -t public/
```
 to use the built-in PHP web server or configure a web server like Nginx or Apache to run the application.
