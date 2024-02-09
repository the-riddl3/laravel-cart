### Laravel Cart System

requirements:
- PHP 8.2
- Composer
- Docker

How to run:
- Execute ```./vendor/bin/sail up```
- Execute ```./vendor/bin/sail artisan db:seed``` to insert sample data into the database
- Test that everything works by running ```./vendor/bin/sail artisan test```
- You should be able to access the api endpoints by default at ```http://127.0.0.1/api/*```
