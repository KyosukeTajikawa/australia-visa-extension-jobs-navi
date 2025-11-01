import React from 'react';
import { Text } from '@chakra-ui/react';

type ReviewWorkPositionProps = {
    work_position: string;
}

const ReviewWorkPosition = ({ work_position }: ReviewWorkPositionProps) => {
    return (
        <Text mb={1}>仕事のポジション：{work_position}</Text>
    );
};

export default ReviewWorkPosition;
