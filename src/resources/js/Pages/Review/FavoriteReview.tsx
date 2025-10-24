import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading } from "@chakra-ui/react";

const FavoriteReview = () => {
    return (
        <Box>
            <Heading as={"h1"}>お気に入りレビュー</Heading>
        </Box>
    )
}

FavoriteReview.layout = (page: React.ReactNode) => (<MainLayout title="お気に入りレビュー">{page}</MainLayout>)
export default FavoriteReview;
