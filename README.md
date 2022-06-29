
## Learning project
This is an API built with PHP Laravel for event creation and ticketing.
## Download and Usage

Clone this project and run command

```
composer install
```

After wards, run 
```php artisan optimize
```
### Prototype Demo (base Url)

- **[https://angwa-event-ticketing.herokuapp.com/api/](https://angwa-event-ticketing.herokuapp.com/api/)**

Using the endpoint above, the following endpoints can be accessed directly on the API

USER AUTHENTICATION ENDPOINTS

1
Account signup
{{BASE_URL}}/user/create

2
Account signin
{{BASE_URL}}/user/login

3
Logout
{{BASE_URL}}/logout



EVENT WORKFLOW
The following endpoints require authorization. The bearer token is used. So provide the bearer token generated during login to access the endpoints.


1
Create Event
{{BASE_URL}}/event/create

2
Show Logged User events
{{BASE_URL}}/event/show

3
Show specific user events
{{BASE_URL}}/event/show/{user_id}

4
Show all events
{{BASE_URL}}/event/all

5
Update Event
{{BASE_URL}}/event/update/{event_id}

6
Delete Event
{{BASE_URL}}/event/delete/{event_id}

7
Create Ticket
{{BASE_URL}}/ticket/create


ACCOUNT CREATION PAYLOAD
```
{
   "name":"Angwa moses",
   "email":"angwamoses@gmail.com",
   "password":"12345678",
   "password_confirmation":"12345678"
}
```
USER LOGIN PAYLOAD
```
{
   "email":"angwamoses@gmail.com",
   "password":"12345678"
}
```

EVENT CREATION PAYLOAD

```
{
   "name":"Otakom Traditional marraie",
   "location":"Flat 4, Johnson ogede way, Benue State",
   "description":"They will be joined together in holy matrimoy",
   "date":"03.05.2022",
   "type":"paid",
   "price":400,
   "slots":22,
   "status":"inactive"
}
```
 
NOTE: slot, price  and status are optional fields.
 
CRAETE TICKET PAYLOAD
```
{
   "event_id":1,
   "slot":2
}
```
 

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
