# Debug Setup for training/participants/certified 404

## Step 1: Find the container listening on port 8080

```powershell
docker ps --format "table {{.Names}}\t{{.Ports}}\t{{.Image}}"
```

Look for a row where the Ports column contains `8080` or `->8080`. Note the container name in the **Names** column.

Example output:
```
NAMES                PORTS                      IMAGE
upsrlm-bc-web        0.0.0.0:8080->80/tcp       upsrlm-bc-web:latest
upsrlm-mysql         3306/tcp                   mysql:5.7
```

The container name here is `upsrlm-bc-web`.

## Step 2: Enter the container and check the current index.php

Replace `<CONTAINER_NAME>` with the name from Step 1:

```powershell
docker exec -it <CONTAINER_NAME> bash -c "head -20 /app/bc/web/index.php"
```

Check the output for the current YII_DEBUG and YII_ENV values. They may look like:
```php
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');
```

## Step 3: Enable debug mode inside the running container

```powershell
docker exec -it <CONTAINER_NAME> bash -c "sed -i \"s/define('YII_DEBUG', false)/define('YII_DEBUG', true)/\" /app/bc/web/index.php && sed -i \"s/define('YII_ENV', 'prod')/define('YII_ENV', 'dev')/\" /app/bc/web/index.php"
```

Verify the change:
```powershell
docker exec -it <CONTAINER_NAME> bash -c "head -20 /app/bc/web/index.php | grep 'YII_'"
```

## Step 4: Restart the PHP/Apache service in the container

```powershell
docker exec -it <CONTAINER_NAME> bash -c "service apache2 reload"
```

Or if it uses PHP-FPM:
```powershell
docker exec -it <CONTAINER_NAME> bash -c "supervisorctl restart php-fpm"
```

## Step 5: Fetch the page with debug headers

```powershell
$response = curl -i "http://upsrlm.local:8080/training/participants/certified" 2>&1 | Select-Object -First 30
$response
```

Look for `X-Debug-Tag:` in the response headers. It will look like:
```
X-Debug-Tag: 68a5c31e4721e
```

**Copy that tag (the hexadecimal value) and paste it in your next response.**

Alternatively, extract just the tag:
```powershell
curl -s -I "http://upsrlm.local:8080/training/participants/certified" | Select-String "X-Debug-Tag"
```

## Step 6: If you see a full exception on the page

Copy and paste the entire exception output (the colored/text error that appears) into your response.

---

**Once you have the X-Debug-Tag or exception, reply with it and I will:**
1. Open the corresponding debug file (`bc/runtime/debug/<TAG>.data`)
2. Parse the stack trace
3. Identify the exact reason for the 404
4. Apply a targeted fix
