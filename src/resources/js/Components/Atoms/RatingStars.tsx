import { StarIcon } from '@chakra-ui/icons';
import { HStack } from '@chakra-ui/react';
import React from 'react';

type RatingStarsProps = {
    rating: number;
}

const RatingStars = ({ rating }: RatingStarsProps) => {
    return (
        <HStack spacing={1}>
            {Array(5).fill("").map((_, i) => (
                <StarIcon key={i} color={i < rating ? "green.500" : "gray.300"} fontSize={"12px"} />
            ))}
        </HStack>
    );
};

export default RatingStars;
