<?php 

namespace Hotel;

use Hotel\BaseService;

class Review extends BaseService
{
    public function addReview()
    {

    } 

    public function getReviewsByRoom($roomId)
    {
        $parameters = [
            ':room_id' => $roomId,
        ];
        return $this->fetchAll('SELECT * FROM review WHERE room_id = :room_id', $parameters);
    }
}  