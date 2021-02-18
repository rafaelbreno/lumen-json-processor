## Test Melhor Envio

## Observations
- Yep! I'm using _Laravel Lumen_ instead of _"Laravel Laravel"_
    - I didn't felt the need to have all of Laravel's components
    - This project looks more like a _microservice_ than a "complete" app


### How to locally deploy
- > $ git clone https://github.com/rafaelbreno/lumen-json-processor.git
- > $ cd lumen-json-processor
- > $ composer install
- > $ cp .env.example .env
- > $ php artisan key:generate
- Configure `.env` file

- Then there are 2 options:
1. Using docker, run:
     - > $ docker-compose up -d
    - > $ docker-compose exec app php artisan migrate
    - > $ docker-compose exec app php artisan schedule:run >> /dev/null 2>&1
        - Run cron job
    - Access `localhost:8000`
2. _"Normal"_ way
    - > $ php artisan serve
    - Configure your databases
    
- Now to "seed" the database you can send any file from `/.static/` folder to the endpoint `/api/log/create/file`

## Migrations/Models
- [x] `logs`
- [x] `requests`
- [x] `headers`
- [x] `responses`
- [x] `entities`
- [x] `routes`
- [x] `servicies`
- [x] `latencies`

## Endpoints
### `/api/log/create`
- Insert log registration via payload
- Only accepts 1 JSON
- Request:
    - ```json
        {
            "request":{
                "method":"GET",
                "uri":"\/",
                "url":"http:\/\/yost.com",
                "size":174,
                "querystring":"aro aro",
                "headers":{
                    "accept":"*\/*",
                    "host":"yost.com",
                    "user-agent":"curl\/7.37.1"
                }
            },
            "upstream_uri":"\/",
            "response":{
                "status":500,
                "size":878,
                "headers":{
                    "Content-Length":"197",
                    "via":"gateway\/1.3.0",
                    "Connection":"close",
                    "access-control-allow-credentials":"true",
                    "Content-Type":"application\/json",
                    "server":"nginx",
                    "access-control-allow-origin":"*"
                }
            },
            "authenticated_entity":{
                "consumer_id":{
                    "uuid":"72b34d31-4c14-3bae-9cc6-516a0939c9d6"
                }
            },
            "route":{
                "hosts":"miller.com",
                "id":"0636a119-b7ee-3828-ae83-5f7ebbb99831",
                "methods":[
                    "GET",
                    "POST",
                    "PUT",
                    "DELETE",
                    "PATCH",
                    "OPTIONS",
                    "HEAD"
                ],
                "paths":[
                  "\/"
                ],
                "preserve_host":false,
                "protocols":[
                    "http",
                    "https"
                ],
                "regex_priority":0,
                "service":{
                    "id":"c3e86413-648a-3552-90c3-b13491ee07d6"
                },
                "strip_path":true,
                "created_at":1564823899,
                "updated_at":1564823899
            },
            "service":{
                "host":"ritchie.com",
                "id":"c3e86413-648a-3552-90c3-b13491ee07d6",
                "name":"ritchie",
                "path":"\/",
                "port":80,
                "protocol":"http",
                "retries":5,
                "read_timeout":60000,
                "connect_timeout":60000,
                "write_timeout":60000,
                "created_at":1563589483,
                "updated_at":1563589483
            },
            "latencies":{
                "proxy":1836,
                "gateway":8,
                "request":1058
            },
            "client_ip":"75.241.168.121",
            "started_at":1566660387
        }
      ```
- Response:
    - ```json
        {
            "upstream_uri": "/",
            "client_ip": "75.241.168.121",
            "started_at": "2019-08-24 15:26:27",
            "request_id": 1,
            "entity_id": 1,
            "response_id": 1,
            "route_id": "0636a119-b7ee-3828-ae83-5f7ebbb99831",
            "service_id": "c3e86413-648a-3552-90c3-b13491ee07d6",
            "latency_id": "1",
            "updated_at": "2021-02-14T06:39:20.000000Z",
            "created_at": "2021-02-14T06:39:20.000000Z",
            "id": 1
        }
      ```
### `/api/log/create/file`
- Insert log registration via file upload
- Only accepts 1 file
- Request:
    - FormData with _'file'_ field
- Response:
    - ```json
        {
            "filename": "2021/02/d38c15ad-0dfe-4c7d-87c6-9af20ffb9fc5.txt",
            "status": 0,
            "updated_at": "2021-02-14T21:43:13.000000Z",
            "created_at": "2021-02-14T21:43:13.000000Z",
            "id": 5
        }
      ```

### `/request/per/consumer`
- Receive CSV file:
- ```csv
    consumer_id,quantity
    72b34d31-4c14-3bae-9cc6-516a0939c9d6,4
    f643db14-a82d-30c2-8c13-889db1d0fcc2,2
    beceaa24-823b-3bf9-9ae6-c8dada26b264,2
    7ba24e1f-ed19-31b2-a4be-4114721d63af,2
  ```

### `/request/per/service`
- Receive CSV file:
- ```csv
    service_id,quantity
    c3e86413-648a-3552-90c3-b13491ee07d6,2046
    d035ffcf-914a-3007-b028-ae18f04d75b4,2090
    a5bf08bd-c030-30d5-8009-83a8c30103bf,2100
    22f8e3a6-01f7-3264-b4b5-9d178df11d06,2107
    eb1ce287-5797-3e45-b9a6-e6d51691257e,2102
  ```

### `/latency/per/service`
- Receive CSV file:
- ```csv
    service_id,proxy,gateway,request
    c3e86413-648a-3552-90c3-b13491ee07d6,1380.0670,12.4306,1737.5225
    d035ffcf-914a-3007-b028-ae18f04d75b4,1399.0263,12.6775,1727.6751
    a5bf08bd-c030-30d5-8009-83a8c30103bf,1405.3490,12.4519,1747.2448
    22f8e3a6-01f7-3264-b4b5-9d178df11d06,1405.1011,12.5093,1743.7428
    eb1ce287-5797-3e45-b9a6-e6d51691257e,1402.8192,12.5038,1748.4291
  ```
