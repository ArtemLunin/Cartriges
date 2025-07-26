sail artisan make:model Place -m
sail artisan make:model Printer -m
sail artisan make:model Cartridge -m
sail artisan make:model Refilling -m
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
