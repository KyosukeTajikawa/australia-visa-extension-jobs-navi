import React from "react";
import { Box, Heading, VStack, HStack, Image, Text, Link, useToast } from "@chakra-ui/react";
import { StarIcon } from '@chakra-ui/icons';


const Detail = ({ farm }) => {
    return (
        <Box m={4}>
            {/* ファーム */}
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


            {/* レビュー */}
            <Box>
                <Heading mt={8} as={"h2"} fontSize={{ base: "24px", md: "30px", lg: "40px" }}>レビュー</Heading>
            </Box>
            {farm.reviews.map((review) => (
                <Box border={"1px"} borderRadius={"md"} borderColor={"gray.300"} boxShadow={"md"}>
                    <Text>仕事のポジション:{review.work_position}</Text>
                    <Text>支払種別:{review.pay_type}</Text>
                    <Text>時給:{review.hourly_wage}</Text>
                    <Text>車は必要か否か:{review.is_car_required}</Text>
                    <HStack>
                        <Text>開始日:{review.start_date}</Text>
                        <Text>終了日:{review.end_date}</Text>
                    </HStack>
                    <VStack align={"stretch"}>
                        <Text>仕事内容の評価</Text>
                        <HStack>
                            {Array(5).fill("").map((_, i) => (
                                <StarIcon key={i} color={i < review.work_rating ? "yellow.500" : "gray.300"} />
                            ))}
                        </HStack>
                    </VStack>
                    <VStack align={"stretch"}>
                        <Text>給料の評価</Text>
                        <HStack>
                            {Array(5).fill("").map((_, i) => (
                                <StarIcon key={i} color={i < review.salary_rating ? "yellow.500" : "gray.300"} />
                            ))}
                        </HStack>
                    </VStack>
                    <VStack align={"stretch"}>
                        <Text>労働時間の評価</Text>
                        <HStack>
                            {Array(5).fill("").map((_, i) => (
                                <StarIcon key={i} color={i < review.hour_rating ? "yellow.500" : "gray.300"} />
                            ))}
                        </HStack>
                    </VStack>
                    <VStack align={"stretch"}>
                        <Text>人間関係の評価</Text>
                        <HStack>
                            {Array(5).fill("").map((_, i) => (
                                <StarIcon key={i} color={i < review.relation_rating ? "yellow.500" : "gray.300"} />
                            ))}
                        </HStack>
                    </VStack>
                    <VStack align={"stretch"}>
                        <Text>総合評価</Text>
                        <HStack>
                            {Array(5).fill("").map((_, i) => (
                                <StarIcon key={i} color={i < review.overall_rating ? "yellow.500" : "gray.300"} />
                            ))}
                        </HStack>
                        <Text>コメント</Text>
                        <Text>{review.comment}</Text>
                    </VStack>
                </Box>
            ))}
        </Box>
    );
};

export default Detail;
