import React from 'react';
import { Text } from '@chakra-ui/react';

type ReviewHourlyWageProps = {
    hourly_wage: number;
}

const ReviewHourlyWage = ({ hourly_wage }: ReviewHourlyWageProps) => {
    return (
        <Text mb={1}>時給(豪ドル)：{hourly_wage}</Text>
    );
};

export default ReviewHourlyWage;
