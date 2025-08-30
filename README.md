sail artisan make:model Place -m
sail artisan make:model Printer -m
sail artisan make:model Cartridge -m
sail artisan make:model Refilling -m
sail artisan make:model CartridgeModel -m
sail artisan migrate

sail artisan make:controller Api/PrintersController --resource
sail artisan make:controller Api/PlacesController --resource
sail artisan make:controller Api/CartridgesController --resource
sail artisan make:controller Api/CartridgeModelsController --resource
sail artisan make:controller Api/RefillingsController --resource

sail artisan make:resource Printer
sail artisan make:resource PrinterCollection
sail artisan make:resource Place
sail artisan make:resource PlaceCollection
sail artisan make:resource Cartridge
sail artisan make:resource CartridgeCollection# Cartriges
sail artisan make:resource CartridgeModel
sail artisan make:resource CartridgeModelCollection
sail artisan make:resource RefillingModel
sail artisan make:resource RefillingModelCollection

## Add JWT to project
sail composer require tymon/jwt-auth
sail artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
sail artisan jwt:secret
sail artisan make:migration create_users_table
sail artisan make:migration add_refresh_token_to_users
sail artisan make:model User
sail artisan make:controller Api/AuthController
sail artisan make:request RegisterRequest
sail artisan make:request LoginRequest

## Вынесем валидацию в Form Request:
sail artisan make:request StoreCartridgeRequest
sail artisan make:request UpdateCartridgeRequest
sail artisan make:request SearchCartridgeRequest
sail artisan make:request UpdatePrinterRequest
sail artisan make:request StorePrinterRequest
sail artisan make:request StoreCartridgeModelRequest
sail artisan make:request UpdateCartridgeModelRequest
sail artisan make:request StoreRefillingRequest
sail artisan make:request IndexRefillingRequest
sail artisan make:request StorePlaceRequest
sail artisan make:request UpdatePlaceRequest

## Бэкап БД
sail exec mysql mysqldump -u root -ppassword laravel > backup.sql

## Изменение структуры таблицы cartridges
sail artisan make:migration modify_cartridges_table_add_model_id_remove_model
## Изменение структуры таблицы cartridge_models с указанием таблицы
sail artisan make:migration modify_cartridge_models_table_add_capacity --table=cartridge_models
## Изменение структуры таблицы refillings с указанием таблицы
sail artisan make:migration modify_refillings_add_cost --table=refillings
