import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Link, HStack, Image, Text, } from "@chakra-ui/react";
import { StarIcon, EditIcon } from '@chakra-ui/icons';


const Create = ({ farm }: CreateProps) => {
    return (
        <Box>
            aaaaa
        </Box>
    );
};

Create.layout = (page: React.ReactNode) => (<MainLayout title="ファーム情報サイト">{page}</MainLayout>);
export default Create;
