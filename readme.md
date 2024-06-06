## 1. Reestablecer DB
ejecutar el archivo **db/simple_market.sql** en su servidor **MySQL** para reestablecer la base de datos

## 2. Verificar variables de entorno
verificar el valor de las variables de entorno, principalmente la variable **DATABASE_URL**

## 3. Ejecucion
Es posible ejecutar el aplicativo por docker o por linea de comandos:
### por Docker
- ejecutar el siguiente comando:

        docker compose build --no-cache && docker compose up

- el aplicativo se ejecutara en el puerto 80 (se puede cambiar en docker-compose.sql)

### por linea de comandos
- acceder a la carpet public y ejecutar:
        
        php -S [[domain]:[port]]
        php -S localhost:8080