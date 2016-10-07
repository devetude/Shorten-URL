# README #

### What is this repository for? ###

* Quick summary

    Shorten URL

#
* Version

    v1.0.0	first version released
    v1.0.5	shorten url able to be copied into clipboard
    v1.0.6	copied into clipboard mobile bug fixed

#
* Demo

    http://su.devetude.net/

#
### How do I get set up? ###

* Enviroment

    apache (v2.2.15)
    php (v5.3.3)
    mysql (v5.1.71)

#
* Dependencies

    php fhc-framework ("https://github.com/flrngel/FHC-Framework.git") was used this project.
    apache "rewrite_mod" module must be needed.

#
* Summary of set up

    1. Git clone on "git clone https://devetude@bitbucket.org/devetude/shorten_url.git".
    2. Create db (devetude_su).
    3. Import url table (shorten_url/db/url.sql) into db (devetude_su).
    4. Modify database connection file (shorten_url/lib/classes/DB.php).
    5. Add apache virtual host (Project root is shorten_url directory).

#
### Who do I talk to? ###

* Repo owner or admin

    devetude all rights reserved.

#
* Other community or team contact

    devetude@naver.com

#
