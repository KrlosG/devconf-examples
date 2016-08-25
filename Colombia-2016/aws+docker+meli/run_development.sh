#!/bin/bash

docker build -t mercadolibre/devconf-colombia-2016 .
docker run -ti -v $(pwd):/app -p 8080:8080 -t mercadolibre/devconf-colombia-2016
