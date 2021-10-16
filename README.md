# Coinbase Auto Bidder

## Setup
Go to your Coinbase PRO account, create an API Key and then run these commands in a Linux-based environment:
```
cp .env.example .env
composer install
```

Then, go to your ```.env``` file and fill these attributes with your MySql database connection and Coinbase API keys:  
```
DB_COINBASE_AUTO_BIDDER_HOST=
DB_COINBASE_AUTO_BIDDER_PORT=
DB_COINBASE_AUTO_BIDDER_DATABASE=
DB_COINBASE_AUTO_BIDDER_USERNAME=
DB_COINBASE_AUTO_BIDDER_PASSWORD=
```
```
COINBASE_PRO_API_SECRET=
COINBASE_PRO_API_KEY=
COINBASE_PRO_API_PASSPHRASE=
COINBASE_PRO_API_BASE_URL=
```  
```COINBASE_PRO_API_BASE_URL=``` should be ```https://api-public.sandbox.exchange.coinbase.com``` or ```https://api-public.exchange.coinbase.com```.

Then run ```php artisan migrate``` in order to create MySql tables.

## Commands  

#### Save users accounts
This command saves any Coinbase accounts not yet saved to the database and updates those already there.

```php artisan coinbase:accounts:save```  
  
  
## References 
Coinbase API documentation: [https://docs.cloud.coinbase.com/exchange/docs/welcome](https://docs.cloud.coinbase.com/exchange/docs/welcome)
