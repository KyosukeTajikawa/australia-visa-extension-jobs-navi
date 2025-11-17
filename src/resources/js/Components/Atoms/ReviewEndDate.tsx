import React from 'react';
import { Text } from '@chakra-ui/react';

type ReviewEndDateProps = {
    end_date: string;
}

const ReviewEndDate = ({ end_date }: ReviewEndDateProps) => {
    return (
        <Text>終了日：{end_date}</Text>
    );
};

export default ReviewEndDate;
