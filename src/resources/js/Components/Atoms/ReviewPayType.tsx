import React from 'react';
import { Text } from '@chakra-ui/react';

type ReviewPayTypeProps = {
    pay_type: number;
}

const ReviewPayType = ({ pay_type }: ReviewPayTypeProps) => {
    return (
        <Text mb={1}>支払種別：{pay_type === 1 ? "Hourly-Rate" : "Piece-Rate"}</Text>
    );
};

export default ReviewPayType;
