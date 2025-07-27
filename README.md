sail artisan make:model Place -m
sail artisan make:model Printer -m
sail artisan make:model Cartridge -m
sail artisan make:model Refilling -m
sail artisan make:model CartridgeModel -m
sail artisan migrate

sail artisan make:controller Api/PrintersController --resource
sail artisan make:controller Api/PlacesController --resource
sail artisan make:controller Api/CartridgesController --resource

sail artisan make:resource Printer
sail artisan make:resource PrinterCollection
sail artisan make:resource Place
sail artisan make:resource PlaceCollection
sail artisan make:resource Cartridge
sail artisan make:resource CartridgeCollection# Cartriges

## Вынесим валидацию в Form Request:
sail artisan make:request StoreCartridgeRequest
sail artisan make:request UpdateCartridgeRequest
sail artisan make:request SearchCartridgeRequest

## Бэкап БД
sail exec mysql mysqldump -u root -ppassword laravel > backup.sql

## Изменение структуры таблицы cartridges
sail artisan make:migration modify_cartridges_table_add_model_id_remove_model