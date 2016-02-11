# EPPYK

## API

### Get all locales

Params:

* `locale` - optional, filter by locale code
* `with_answers` - **true | false** optional, get locales with answers. Default **true**
* `answers_size` - optional, amount of the answers in each locale. Default infinity
* `answers_page` - optional, answers page. Default null

```shell
$ curl https://eppyk.com/api/v1/locales?with_answers=false
```
```json
{
    "meta": {
        "code": 200
    },
    "data": [
        {
            "id": "56bc6a944db07f19540041a8",
            "title": "Russian",
            "code": "RU"
        },
        {
            "id": "56bc84984db07f3d540041aa",
            "title": "English",
            "code": "en"
        }
    ]
}
```

Response with answers

```shell
$ curl https://eppyk.com/api/v1/locales?with_answers=true&answers_size=10&answers_page=1
```

```json
{
    "meta": {
        "code": 200
    },
    "data": [
        {
            "id": "56bc6a944db07f19540041a8",
            "title": "Russian",
            "code": "RU",
            "answers": [
                {
                    "id": "56bc7da84db07f29540041a9",
                    "text": "Попробуй!"
                },
                {
                    "id": "56bc7dbb4db07f19540041a9",
                    "text": "У тебя получится"
                }
            ]
        },
        {
            "id": "56bc84984db07f3d540041aa",
            "title": "English",
            "code": "en",
            "answers": [ ]
        }
    ]
}
```

### Get questions by locale 

Params:

* `page` - optional, default 1
* `size` - optional, size of the answers on page, default 30
* `updated_before` - optional, ISO date format. Answer update time LESS than param.
* `updated_after` - optional, ISO date format. Answer update time MORE than param.


```shell
$ curl https://eppyk.com/api/v1/locales/RU/answers/?page=1&size=10
    &updated_before=2016-02-10&updated_after=2016-02-11T17:57:39.389Z
```

```json
{
    "meta": {
        "code": 200
    },
    "data": [
        {
            "id": "56bc7da84db07f29540041a9",
            "text": "Попробуй!"
        },
        {
            "id": "56bc7dbb4db07f19540041a9",
            "text": "У тебя получится"
        }
    ]
}
