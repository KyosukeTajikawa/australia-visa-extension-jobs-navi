import React from "react";
import { Box, Heading, VStack, HStack, Image, Text, Link, useToast } from "@chakra-ui/react";


const Detail = ({ farm }) => {
    return (
        <Box m={4}>
            <Box mb={4}>
                <Heading as={"h2"} fontSize={{ base: "24px", md: "30px", lg: "40px" }}>{farm.name}</Heading>
            </Box>
            <Box mb={4}>
                <Image src="https://placehold.co/300x300" boxSize={"300px"} alt={farm.name} objectFit={"contain"} />
            </Box>
            <HStack mb={2}>
                <Text>{farm.street_address}</Text>
                <Text>{farm.suburb}</Text>
                <Text>{farm.state.name}</Text>
                <Text>{farm.postcode}</Text>
            </HStack>
            <Box>
                <Text>{farm.description}</Text>
            </Box>
            <Box>
                <Heading mt={8} as={"h2"} fontSize={{ base: "24px", md: "30px", lg: "40px" }}>レビュー</Heading>
            </Box>
                {farm.review.map((review) => (
            <Box>
                    <Text>仕事のポジション:{review.work_position}</Text>
                        {}
                        <Text>時給{!review.wage ? !review.wage : review.wage}</Text>
            </Box>
                ))}
        </Box>
    );
};

export default Detail;
