#EN 

## Installation
Laravel:
- `composer install`
- settings `.env` file
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`

## Additional information
Order statuses:
- 0 new
- 10 approved
- 20 finished

Bootstrap `/public/js/app.js`, `/public/css/app.css`

Custom JS `/public/js/script.js` 

Custom CSS `/public/css/style.css` 

## 

#### Weather
- Page with temperature in custom city(Yandex Weather API https://tech.yandex.ru/weather/)

#### Orders
- Orders page
    - columns 
        - Order ID
        - Partner 
        - Order Total Amount 
        - Items 
        - Status
    - order_id - link to order page
- Order Edit Page
    - fields:
        - customer email(редактирование, required)
        - partner(editable, required)
        - products(titles and quantities)
        - status(editable, required)
        - total amount(text)
        - save button

#### Wait List
- Wait List Page
     - columns
        - Placement
        - Party
        - Size
        - Time Waited
- Signup for Wait List page        
     - fields
        - First Name
        - Last Name
        - Phone
        - Email
        - Children
        - Adults
        Total Guests(text - sum children and adults)
        
- Reservations List
     - columns
        - ID
        - Date & Time
        - Name
        - Phone
        - Email
        - Children
        - Adults
        - Total Guests
        - Status
        - Action (dropdown)
            - Waiting
            - In Process
            - Prepared
            - Seated
            
- Signup for our Customer Appreciation Club
      - fields
         - First Name
         - Last Name
         - Phone
         - Email
         - Favorite menu item
         - What is your birthday day and month?            
       
####Go to "Yandex.Weather" and "JavaScript API и HTTP Geocoder" https://developer.tech.yandex.ru/keys/, create API keys and set it in .env  

YANDEX_WEATHER_KEY=

YANDEX_GEOCODING_KEY=        


TWILIO_SID=
TWILIO_TOKEN=
TWILIO_FROM=


# RU

## Настройка проекта
Для Laravel:
- `composer install`
- настроить `.env` файл
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`

## Дополнительная информация
Статусты заказа:
- 0 новый
- 10 подтвержден
- 20 завершен

bootstrap `/public/js/app.js`, `/public/css/app.css`

js код в `/public/js/script.js` 

css в `/public/css/style.css` 

#### Погода
- Страница на которой выводится текущая температура в Брянске (запрос из php) (API https://tech.yandex.ru/weather/)

#### Заказы
- Страница со списоком заказов в табличном виде
    - поля 
        - ид_заказа 
        - название_партнера 
        - стоимость_заказа 
        - наименование_состав_заказа 
        - статус_заказа
    - ид_заказа - ссылка на редактирование заказа в новой вкладке
- Страница редактирования заказа
    - поля для редактирования:
        - email_клиента(редактирование, обязательное)
        - партнер(редактирование, обязательное)
        - продукты(вывод наименования + количества единиц продукта)
        - статус заказа(редактирование, обязательное)
        - стоимость заказ(вывод)
        - сохранение изменений в заказе

#### Wait List
- Wait List Page
     - columns
        - Placement
        - Party
        - Size
        - Time Waited
- Signup for Wait List page        
     - fields
        - First Name
        - Last Name
        - Phone
        - Email
        - Children
        - Adults
        Total Guests(text - sum children and adults)
        
- Reservations List
     - columns
        - ID
        - Date & Time
        - Name
        - Phone
        - Email
        - Children
        - Adults
        - Total Guests
        - Status
        - Action (dropdown)
            - Waiting
            - In Process
            - Prepared
            - Seated
            
- Signup for our Customer Appreciation Club
      - fields
         - First Name
         - Last Name
         - Phone
         - Email
         - Favorite menu item
         - What is your birthday day and month? 
       
####Для получения данных о погоде необходимо получить ключи "Яндекс.Погода" и "JavaScript API и HTTP Геокодер" https://developer.tech.yandex.ru/keys/  и вписать их в .env    

YANDEX_WEATHER_KEY=

YANDEX_GEOCODING_KEY=        


TWILIO_SID=
TWILIO_TOKEN=
TWILIO_FROM=
