import React from 'react';
import { Button } from '@chakra-ui/react';
import { router } from "@inertiajs/react";

type ReviewFavoriteButtonProps = {
    id: number;
}

const ReviewFavoriteButton = ({ id }: ReviewFavoriteButtonProps) => {
    return (
        <Button
            mb={3}
            bg={"green.800"}
            _hover={{ bg: "green.700" }}
            color={"white"}
            onClick={() => router.post(`/review/${id}/favorites`)}
        >
            お気に入り
        </Button>
    );
};

export default ReviewFavoriteButton;
