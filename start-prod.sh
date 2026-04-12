#!/bin/sh
docker compose -f docker-compose.prod.yml up --build -d
echo "Environnement de prod lancé sur http://localhost:8081"
