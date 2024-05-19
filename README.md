
# Test tecnico

Buenas, le dejo los pasos a seguir para probar el programa.
los endpoints van seguido de /api ej: 127.0.0.1:8000/api/ba_weather
127.0.0.1:8000/api/current?query=new%20york

## Deployment

To deploy this project run

```bash
  composer install
  php artisan migrate
  php artisan serve
```


## Environment Variables

Variables a utilizar:
Le dejo mi apiKey ya agregada al .env para facilitar.
Tambien se debe configurar la base de datos mysql

WEATHERSTACK_API_KEY=aa2616621f0ff8c86ce7d5961c4563a8


