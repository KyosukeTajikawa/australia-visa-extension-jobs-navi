import React from "react";
import { Box, Heading, VStack, HStack, Image, Text, Link, useToast } from "@chakra-ui/react";

type Farm = {
    id: number;
    name: string;
    description: string;
};

type Props = {
    farms: Farm[]
};

const Home = ({ farms }) => {

    return (
        <Box m={2}>
            <Box bg={"green.500"} mb={2}>
                <Heading as={"h1"} fontSize={{ base: "24px", md: "30px", lg: "40px" }}>ファーム一覧</Heading>
            </Box>
            <VStack spacing={4} align={"stretch"}>
                {farms.map((farm) => (
                    <Link href={`/farm/${farm.id}`} _hover={{ color: "gray.500" }}>
                        <Box key={farm.id} p={4} border={"1px solid"} borderColor={"gray.300"} borderRadius={"md"} boxShadow={"md"}>
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
        </Box>
    );
};

export default Home;
