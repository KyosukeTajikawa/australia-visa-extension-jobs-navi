import React from "react";
import {Box, Heading, VStack, HStack, Image, Text, Link,} from "@chakra-ui/react";
import MainLayout from "@/Layouts/MainLayout";
import type {Page} from "@inertiajs/core";

type Farm = {
    id: number;
    name: string;
    description: string;
};

type HomeProps = {
    farms: Farm[];
};

const Home = ({ farms }: HomeProps) => {
    return (
        <Box m={2}>
            {/* ファーム一覧 */}
            <VStack spacing={4} align={"stretch"}>
                {farms.map((farm) => (
                    <Link key={farm.id} href={`/farm/${farm.id}`} _hover={{ color: "gray.500" }}>
                        <Box p={4} border={"1px solid"} borderColor={"gray.300"} borderRadius={"md"} boxShadow={"md"}>
                            <HStack>
                                <Image src="https://placehold.co/100x100" boxSize={"100px"} objectFit={"cover"} alt={farm.name} />
                                <VStack align={"stretch"}>
                                    <Heading as={"h3"}>{farm.name}</Heading>
                                    <Text>{farm.description}</Text>
                                </VStack>
                            </HStack>
                        </Box>
                    </Link>
                ))}
            </VStack>
        </Box >
    );
};

Home.layout = (page: React.ReactNode) => <MainLayout children={page} title="ファーム情報サイト" />
export default Home;
