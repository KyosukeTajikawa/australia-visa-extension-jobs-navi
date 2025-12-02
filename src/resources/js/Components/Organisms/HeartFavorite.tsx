import React, { useState } from "react";
import { Box } from "@chakra-ui/react";
import { router } from "@inertiajs/react";
import { AiFillHeart, AiOutlineHeart } from "react-icons/ai";

type HeartFavoriteProps = {
    reviewId: number;
    initial?: boolean;
}

const HeartFavorite = ({ reviewId, initial = false }: HeartFavoriteProps) => {

    const [isFavorite, setIsFavorite] = useState<boolean>(initial);

    const handleFavorite = () => {

        setIsFavorite(prev => {
            const next = !prev;
            const method: "post" | "delete" = next ? "post" : "delete";

            router[method](`/review/${reviewId}/favorites`, {}, {
                preserveScroll: true,
            });

            return next;
        });
    };

    return (
        <Box
            onClick={handleFavorite}
            fontSize="28px"
            color={isFavorite ? "red.500" : "gray.400"}
            mr={4}
        >
            {isFavorite ? <AiFillHeart /> : <AiOutlineHeart />}
        </Box>
    );
};

export default HeartFavorite;
