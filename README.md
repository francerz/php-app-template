PHP Application Template
=======================================

Template to create new PHP Web Application projects.

Installation
---------------------------------------

The project dependencies are managed by [composer](https://getcomposer.org).

```cli
composer install
```

Setup
---------------------------------------

Basic application setup parameters are defined in ***.env*** file that is
automatically loaded.

The default parameters file is named ***.env.dist***. This file must be copied
as ***.env*** and then created file can be modified to match environment.

```
cp .env.dist .env
```

Directory structure
---------------------------------------

### public
Web Server accesible files.

### app
Web Application source code.

### res
Web Application resources, like views.

Security Notes
---------------------------------------

### The *.env.dist* file

The ***.env.dist** file MUST NOT contain any private key or password, as this
MAY be exposed. If a key is exposed, this MUST be regenerated to prevent leaks.

### Key rotation

Even though a key is never exposed, it's RECOMMENDED to rotate keys every once a
while to overcome stolen or deciphered keys.

### Dependency update

It's highly recommended to keep up applications with updated dependencies that
has bug and security fixes. This updates can be only compatible minor versions
or major versions that MAY require changes in source code.

### Web Server exposure

Web server document root MUST be directed to public directory. This prevents
source code leak, keys exposure, current dependencies that may have security
flaws.
