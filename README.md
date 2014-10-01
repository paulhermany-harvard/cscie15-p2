# Project 2 - PHP Basics (Password Generator)

## Live URL
<http://p2.paulhermany.me>

## Description
An implementation of the "correct horse battery staple" password generator (http://xkcd.com/936/).

This tool will let the user generate a password comprised of one or more common words with several customization options such as grade level, word length, and added complexity characters.

### Word Source

The words are sourced from http://www.bigiqkids.com/ and stored in a mysql database by "grade level".
There are 8797 words in the database, a count that provides just around 13 bits of entropy per symbol (http://en.wikipedia.org/wiki/Password_strength)/

## Demo
No demo available for this project.

## Instructions
No instructions available for this project.

## Third-party plug-ins/libraries

| Name               | Version | Url                                   |
| ------------------ | ------- | ------------------------------------- |
| Bootstrap          | 3.2.0   | http://getbootstrap.com/              |
| BootstrapValidator | 0.5.2   | http://bootstrapvalidator.com/        |
| Html5Shiv          | 3.7.2   | https://code.google.com/p/html5shiv/  |
| JQuery             | 1.11.1  | http://jquery.com/                    |
| Respond            | 1.4.2   | https://github.com/scottjehl/Respond/ |
| RequireJS          | 2.1.15  | http://requirejs.org/                 |

### Implementation details

* Bootstrap

  This website uses Bootstrap with the default theme to provide a responsive user interface that works on mobile and desktop.

* Bootstrap

  This website uses Bootstrap Validator for client-side form validation.
  
* Html5Shiv

  This website uses Html5Shiv (included only by CDN) to shim the html for browsers that do not support Html5.

* JQuery

  This is a dependency for the Bootstrap and Bootstrap Validator library.

* Respond

  This website uses Respond (included only by CDN) to shim the css for browsers that do not support CSS3 or responsive css rules.

* RequireJS

  This website uses RequireJS to manage JavaScript library dependencies and handle the CDN pull with local fallback.