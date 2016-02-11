# EPPYK

## API

### Get all locales with answers

Params:

* `with_answers` - **true | false** optional, get locales with answers. Default **true**
* `answers_amount` - optional, amount of the answers in each locale. Default infinity

```shell
$ curl https://eppyk.com/api/v1/locales?with_answers=false
```
```json
{
    meta: {
        code: 200
    },
    data: [
        {
            id: "56bc6a944db07f19540041a8",
            title: "Russian",
            code: "RU"
        },
        {
            id: "56bc84984db07f3d540041aa",
            title: "English",
            code: "en"
        }
    ]
}
```

Response with answers

```shell
$ curl https://eppyk.com/api/v1/locales?with_answers=true&answers_amount=10
```

```json
{
    meta: {
        code: 200
    },
    data: [
        {
            id: "56bc6a944db07f19540041a8",
            title: "Russian",
            code: "RU",
            answers: [
                {
                    id: "56bc7da84db07f29540041a9",
                    text: "Попробуй!"
                },
                {
                    id: "56bc7dbb4db07f19540041a9",
                    text: "У тебя получится"
                }
            ]
        },
        {
            id: "56bc84984db07f3d540041aa",
            title: "English",
            code: "en",
            answers: [ ]
        }
    ]
}
```