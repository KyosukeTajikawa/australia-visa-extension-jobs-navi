import React from 'react';
import ReviewItem from '../Molecules/ReviewItem';
import { Box } from '@chakra-ui/react';

type Review = {
    id: number;
    farm_rating: number;
    start_date: string;
    end_date: string;
    work_position: string;
    pay_type: number;
    hourly_wage: number;
    is_car_required: number;
    application_method_id?: number | null;
    application_method_name?: string | null;
    application_method_other?: string | null;
    application_method?: { id: number; name: string } | null;
    review_user?: { id: number; nickname: string } | null;
    comment: string;
    created_at: string;
}

type Farm = {
    reviews?: Review[];
}

type ReviewListProps = {
    farm: Farm
}

const ReviewList = ({ farm }: ReviewListProps) => {
    return (
        <Box
            // w={{ base: "72%", md: "78%", xl: "1220px" }}
            // mx={"auto"}
            // px={4}
            // fontSize={"20px"}
            // letterSpacing={1}
        >
            {farm.reviews?.map((review) => (
                <ReviewItem key={review.id} review={review} />
            ))}
        </Box>
    );
};

export default ReviewList;
