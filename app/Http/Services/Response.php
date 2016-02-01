<?php
namespace App\Http\Services;

use Illuminate\Http\Response as LumenResponse;

class Response extends LumenResponse
{
    public function json($content = [], $code = LumenResponse::HTTP_OK, $meta = [])
    {
        $meta['code'] = $code;
        $respond = [
            'meta' => $meta,
            'data' => $content,
        ];
        return $this->setStatusCode($code)->setContent($respond);
    }

    public function view($view = null, $data = [], $mergeData = [])
    {
        return view($view, $data, $mergeData);
    }
}
