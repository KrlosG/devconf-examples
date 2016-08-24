#Search Stats Demo

Este repo esta hecho con el proposito de servir de ejemplo de un uso de ejemplo de api's de mercadolibre

Fue utilizado en la Dev Conf Colombia 2016

## Running

Para correr el ejemplo

```
	docker run -d -p 8080:8080 mercadolibre/php-search-stats-demo
```


Si se quiere buldear la imagen y correrla refrescando cambios locales

```
	docker build -t mercadolibre/php-search-stats-demo .
	docker run -t -i -p 8080:8080 -v $(PWD):/app mercadolibre/php-search-stats-demo 
```


