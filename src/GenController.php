<?php


namespace Ohmangocat\GenBase;


use Ohmangocat\Gen_base\gen\traits\JsonTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use support\Response;

class GenController
{
    use JsonTrait;
    /**
     * @param LengthAwarePaginator $paginator
     * @return Response
     */
    public function tableRes(LengthAwarePaginator $paginator): Response
    {
        $data = [
            "items" => $paginator->items(),
            "pageInfo" => [
                "total" => $paginator->total(),
                "currentPage" => $paginator->currentPage(),
                "totalPage" => $paginator->lastPage()
            ]
        ];
        return $this->success($data);
    }

}