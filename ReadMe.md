## Exam

Do not forget to update your local .env with the following
environment variable

```
ORDER_REPOSITORY_URL=https://api.staging.lbcx.ph/v1/orders
```

### Order Repository

To see on command approach:
```
php artisan order:list
php artisan order:list --codes=0077-6490-VNCM,0077-6478-DMAR
```

To test:
```
phpunit
```

To see on controller approach:
```
php artisan serve
```

then browse `http://localhost:8000/api/orders`
