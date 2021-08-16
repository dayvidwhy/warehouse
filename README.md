# Warehouse
Simple image display.

## Development
`docker-compose up -d` then navigate to `localhost` on your machine.

## Deployment
Docker containers running php with apache and mysql.

## Stock naming conventions
Within the `./src/public/stock` folder you simply group images the way you want them to be displayed.
stock/category/sub-category/item.jpg
stock/category/item.jpg

Two levels of nesting are currently supported.
