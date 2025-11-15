import React from 'react';
import { Box, Text, HStack } from '@chakra-ui/react';
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

type ReviewItemProps = {
    review: Review;
}

const ReviewItem = ({ review }: ReviewItemProps) => {
    const OtherId = 99;
    const OtherLabel = "その他";

    const renderApplicationMethod = (review: Review): string => {
        const name = (review.application_method_name ?? review.application_method?.name ?? "").trim();

        const other = (review.application_method_other ?? "").trim();

        const isOther = review.application_method_id === OtherId || name === OtherLabel;

        if (isOther) {
            return other ? other : OtherLabel;
        }
        return name;
    };
    return (
        <Box>
            <Text mb={1}>{review.review_user?.nickname ?? "匿名ユーザー"}</Text>
            <HStack mb={2}>
                <RatingStars rating={review.farm_rating} />
            </HStack>
            <Text mb={1} color="gray.500" fontSize="16px" textAlign={"center"}>
                {new Date(review.created_at).toLocaleDateString("ja-JP")}
            </Text>
            <ReviewWorkPosition work_position={review.work_position} />
            <ReviewPayType pay_type={review.pay_type} />
            <ReviewHourlyWage hourly_wage={review.hourly_wage} />
            <Text mb={1}>応募方法：{renderApplicationMethod(review)}</Text>
            <ReviewIsCarRequired is_car_required={review.is_car_required} />
            <HStack mb={2}>
                <ReviewStartDate start_date={review.start_date} />
                <Text>〜</Text>
                <ReviewEndDate end_date={review.end_date} />
            </HStack>
            <ReviewComment comment={review.comment} />
            <ReviewFavoriteButton id={review.id} />
        </Box>
    );
}

export default ReviewItem;
