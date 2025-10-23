import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading } from "@chakra-ui/react";
import { useForm } from "@inertiajs/react";

const Create = () => {


    return (
        <Box m={2} w={"90%"}>
            <Heading as={"h1"}>レビュー登録</Heading>
        </Box>
    );
};

Create.layout = (page:React.ReactNode) => (
    <MainLayout title="レビュー登録">{page}</MainLayout>
);
export default Create;
