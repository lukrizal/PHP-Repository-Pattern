## Exam

Do not forget to update your local .env with the following
environment variable

```
ORDER_REPOSITORY_URL=https://api.staging.lbcx.ph/v1/orders
```

### Order Repository

```
php artisan order:list
php artisan order:list --codes=0077-6490-VNCM,0077-6478-DMAR
```

```
phpunit
```

```
php artisan serve
```

then browse `http://localhost:8000/api/orders`
