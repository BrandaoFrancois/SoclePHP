# SoclePHP

This repository regroup all basic informations and tools for a PHP Project based on a LAMP Server:
  - Apache
  - MariaDB
  - PHP

No need, of some google research with it.

## Installation of LAMP

Execute the script "lamp.sh" with root rights to launch the installation.

## URL Rewriting

## Robots txt

https://github.com/google/robotstxt

## Abilities available

### Simple CRUD Database Management

The repository /src/models regroups all the CRUD files. (User, and a general CRUD model entitled 'Car'.
Use the Db singleton class to load a database configured on conf.php

### User management

The UserManager class permit to manage easily Users accounts.
Users account are defined by a login, a password encrypted with pepper and last best encrypt solution.
By default, Argon encrypt solution is disabled, to enable it, make sur so install a php solution compiled with argon support.
And, enable Argon support on config.php file.

### Upload File System

To upload a file with security, use the static class UploadManager.
You are free to add more tests if needed.
If the files are pictures, use the methods with 'Picture' suffixes.

### Mail Sending

To send a mail with PHP, our solution is to use the open-source library PHPMailer.
To add it and configure it to the project, follow the steps described on the [github PHPMailer README page](https://github.com/PHPMailer/PHPMailer).

Other available solutions:
  - Using mail function from PHP (Not a good idea)

## Next steps

- WAMP Server
- User group management to assign user to group