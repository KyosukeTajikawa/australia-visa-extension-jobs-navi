import React from 'react';
import { Text } from '@chakra-ui/react';

type ReviewStartDateProps = {
    start_date: string;
}

const ReviewStartDate = ({ start_date }: ReviewStartDateProps) => {
    return (
                <Text>開始日：{start_date}</Text>
    );
};

export default ReviewStartDate;
