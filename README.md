How to run

0. globally, install the wkhtmlimage binary for your system's architecture (amd64 e.g.). Note that, locally, the knsp snappy bundle gets installed. Both are needed
1. fill out variables in .env files
1.1 if using example data, set database name to vettige_vrijdag\
1.2 if using example data set .env.local variables as such:
ICON_DIRECTORY=%kernel.project_dir%/public/uploads/icons
IMAGE_DIRECTORY=%kernel.project_dir%/public/uploads/images
2. yarn install + composer install
3. yarn run encore production
4. php bin/console doctrine:migrations:migrate\
4.1 if using example data, run sql script via e.g. DataGrip\
4.2 if using example data, extract uploads.rar to /public/uploads/
5. run webserver
