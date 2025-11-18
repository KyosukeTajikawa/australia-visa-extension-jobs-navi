import React from 'react';
import ReviewItem from '../Molecules/ReviewItem';
import { Box } from '@chakra-ui/react';

type Review = {
    id: number;
    start_date: string;
    end_date: string;
    work_position: string;
    pay_type: number;
    hourly_wage: number;
    is_car_required: number;
    work_rating: number;
    salary_rating: number;
    hour_rating: number;
    relation_rating: number;
    overall_rating: number;
    comment: string;
};

type ReviewListProps = {
    reviews: Review[];
}

const ReviewList = ({ reviews }: ReviewListProps) => {
    return (
        <Box
            w={{ base: "72%", md: "78%", xl: "1220px" }}
            mx={"auto"}
            px={4}
            fontSize={"20px"}
            letterSpacing={1}
        >
            {reviews?.map((review) => (
                <ReviewItem key={review.id} review={review} />
            ))}
        </Box>
    );
};

export default ReviewList;
