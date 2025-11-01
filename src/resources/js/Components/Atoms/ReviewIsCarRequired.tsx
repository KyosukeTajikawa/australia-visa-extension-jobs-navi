import React from 'react';
import { Text } from '@chakra-ui/react';

type ReviewIsCarRequiredProps = {
    is_car_required: number;
}

const ReviewIsCarRequired = ({ is_car_required }: ReviewIsCarRequiredProps) => {
    return (
        <Text mb={1}>車の有無：{is_car_required === 1 ? "必要" : "不要"}</Text>
    );
};

export default ReviewIsCarRequired;
