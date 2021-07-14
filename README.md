# RRM-PHP-FORM

A responsive PHP form according to the image given using Vanilla PHP, CSS, HTML, JavaScript.


## Form sample

![Form task](https://drive.google.com/uc?id=1MMn99dFXvwOTbuqlHYHRG6J7B1RsFPWy)


## Requirments and Tools

- PHP7
- Apache
- MySQL
- XAMPP (Windows and OSX)
- Composer (Needed for PHPmailer)


## Installation

1. Create `RRM-PHP-FORM/` directory in `public_html` or `htdocs` or `www`

2. CD to the `RRM-PHP-FORM/` directory and git clone this repo
```
git clone https://github.com/itsYoungFox/RRM-PHP-FORM.git
```

3. Run Composer to install PHPmailer (or else it will bug out)
```
composer install
```

4. Start apache and mariadb server
```
// OSX or WINDOWS
Start apache and mariadb server in xampp for OSX or Windows
By clicking the 'Start' button for both Apache and MySQL

// Linux
service apache2 start
service mariadb start
or
systemctl apache2 start
systemctl mariadb start
```

5. Create the Database
```
// Run the create database SQL command
CREATE DATABASE rrm_db
```

6. Open your desired web browser and navigate to `http://localhost/RRM-PHP-FORM`


NOTE: The project in this repo is a job interview task and not a personal project.

## EXTRA
Configure `PHPMailer` by editing the parameters in the `RRM-PHP-FORM/src/controller/c.form.php` from line `131`
If you encouter any problem please create an issue or drop a note.