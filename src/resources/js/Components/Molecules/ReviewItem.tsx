import React from 'react';
import { Box,Text, HStack } from '@chakra-ui/react';
import RatingStars from '../Atoms/RatingStars';
import ReviewComment from '../Atoms/ReviewComment';
import ReviewStartDate from '../Atoms/ReviewStartDate';
import ReviewEndDate from '../Atoms/ReviewEndDate';
import ReviewIsCarRequired from '../Atoms/ReviewIsCarRequired';
import ReviewPayType from '../Atoms/ReviewPayType';
import ReviewWorkPosition from '../Atoms/ReviewWorkPosition';
import ReviewHourlyWage from '../Atoms/ReviewHourlyWage';
import ReviewFavoriteButton from '../Atoms/ReviewFavoriteButton';

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
}

type ReviewItemProps = {
    review: Review;
}

const ReviewItem = ({ review }: ReviewItemProps) => {
    return (
        <Box>
            <ReviewWorkPosition work_position={review.work_position} />
            <ReviewPayType pay_type={review.pay_type} />
            <ReviewHourlyWage hourly_wage={review.hourly_wage} />
            <ReviewIsCarRequired is_car_required={review.is_car_required} />
            <HStack mb={1}>
                <ReviewStartDate start_date={review.start_date} />
                <Text>〜</Text>
                <ReviewEndDate end_date={review.end_date} />
            </HStack>
            <HStack mb={2}>
                <Text>仕事内容：　</Text>
                <RatingStars rating={review.work_rating} />
            </HStack>
            <HStack mb={2}>
                <Text>給料：　　　</Text>
                <RatingStars rating={review.salary_rating} />
            </HStack>
            <HStack mb={2}>
                <Text>労働時間：　</Text>
                <RatingStars rating={review.hour_rating} />
            </HStack>
            <HStack mb={2}>
                <Text>人間関係：　</Text>
                <RatingStars rating={review.relation_rating} />
            </HStack>
            <HStack mb={2}>
                <Text>総合評価：　</Text>
                <RatingStars rating={review.overall_rating} />
            </HStack>
            <Text mb={1}>コメント</Text>
            <ReviewComment comment={review.comment} />
            <ReviewFavoriteButton id={review.id}/>
        </Box>
    );
}

export default ReviewItem;
