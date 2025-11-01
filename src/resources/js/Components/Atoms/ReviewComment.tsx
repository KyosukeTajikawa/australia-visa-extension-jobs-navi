import React from 'react';
import { Text } from '@chakra-ui/react';

type ReviewCommentProps = {
    comment: string;
}

const ReviewComment = ({ comment }: ReviewCommentProps) => {
    return (
        <Text mb={2}>{comment}</Text>
    );
};

export default ReviewComment;
