# Warehouse
Creates a gallery of images by traversing a given directory to create records in a MySQL database using PHP.

## Installation
Composer is required to install the projects dependencies, you can install this with homebrew if needed.
```bash
brew install composer
```

Then clone the repository install the project.
```bash
git clone git@github.com:dayvidwhy/warehouse.git
cd warehouse
composer install
```

 A `docker-compose.yml` file is provided to easily orchestrate the local environment.
```bash
docker-compose up -d
```

## Development
Docker configuration is provided for local development which stands up three containers;
* PHP container with Apache as the web server.
* MySQL container for the database.
* Adminer container to interface with the database via the browser.

## Deployment
The containers can be built and deployed to a production environment.

## Image naming conventions
Within the `./src/public/stock` folder you simply group images the way you want them to be displayed. Two levels of nesting are currently supported.

```bash
stock/category/sub-category/item.jpg
stock/category/item.jpg
```

The files names and folders are used to describe the stock, adjusting the location of a stock item can be achieved by simply moving the image files around and then regenerating the schema with available endpoints.

## Current pages
A few routes are provided to either trigger regeneration of the stock database or to view the images.

### Index page
Index page shows all categories of items.
```bash
Route: /
```

### Category page
Category pages display all stock items associated with a category.
```bash
Route: /:category
```

### Generate page
Helper page for triggering regeneration of the database table.
```bash
Route: /generate
```