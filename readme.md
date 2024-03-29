# EPPYK

## API

### Get all locales

#### api/v1/locales

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
            "description: "Locale description",
            "code": "RU"
        },
        {
            "id": "56bc84984db07f3d540041aa",
            "title": "English",
            "description: "Locale description",
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
                    "text": "Попробуй!",
                    "author": "author name"
                },
                {
                    "id": "56bc7dbb4db07f19540041a9",
                    "text": "У тебя получится",
                    "author": "author name"
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

### Get answers by locale
 
#### api/v1/locales/{LOCALE}/answers

Params:

* `page` - optional, default 1
* `size` - optional, size of the answers on page, default infinity
* `updated_before` - optional, ISO date format. Answer update time LESS than param.
* `updated_after` - optional, ISO date format. Answer update time MORE than param.

If you pass a **size** param, response will contain **pagination** data with current size and page 

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
            "text": "Попробуй!",
            "author": "author name"
        },
        {
            "id": "56bc7dbb4db07f19540041a9",
            "text": "У тебя получится",
            "author": "author name"
        }
    ],
    "pagination": {
        "page": 1,
        "size": 10
    }
}
