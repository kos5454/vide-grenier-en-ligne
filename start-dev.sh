#!/bin/sh
docker compose -f docker-compose.dev.yml up --build -d
echo "Environnement de dev lancé sur http://localhost:8080"
