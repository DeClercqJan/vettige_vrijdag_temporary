How to run

0. globally, install the wkhtmlimage binary for your system's architecture (amd64 e.g.). Note that, locally, the knsp snappy bundle gets installed. Both are needed
1. create .env.local and fill out empty variables in .env 
1.1 if using example data, set database name to vettige_vrijdag\
1.2 if using example data set .env.local variables as such:
ICON_DIRECTORY=%kernel.project_dir%/public/uploads/icons
IMAGE_DIRECTORY=%kernel.project_dir%/public/uploads/images
2. yarn install + composer install
3. yarn run encore production
4. create database
5. php bin/console doctrine:migrations:migrate\
4.1 if using example data, run sql script via e.g. DataGrip\
4.2 if using example data, extract uploads.rar to /public/uploads/
6. run webserver (e.g. symfony server:start)

How to use

- concept: tool to coordinate team lunch orders that results in a single pdf which can be used to order at a snackbar. The pdf can then serve to distribute order over users
- login as "admin" on e.g. https://127.0.0.1:8000/ with the password in .env variable
- share the link with all users
- on landing page, select items and confirm
- back on https://127.0.0.1:8000/ admin can close the time window during which people can order
- download pdf and hand it over to snackbar of your choice
- see history on https://127.0.0.1:8000/admin/vettige-vrijdag/previous
- change available options on https://127.0.0.1:8000/admin/change-menu-complex

TODO:
- button bokes / frieteuh does not respond as I would expect it