import React, { useState } from "react";
import { Box, Heading, VStack, HStack, Image, Text, Link, Input, Button, Select, Flex } from "@chakra-ui/react";
import MainLayout from "@/Layouts/MainLayout";
import { router } from "@inertiajs/react";

type FarmImage = {
    id: number;
    farm_id: number;
    url: string;
}

type States = {
    id: number;
    name: string;
}

type Crops = {
    id: number;
    name: string;
}

type Farm = {
    id: number;
    name: string;
    description: string;
    images: FarmImage[];
    state: States;
    crops: Crops[];
};

type MyFarmsProps = {
    farms: Farm[];
}

const MyFarms = ({ farms }: MyFarmsProps) => {
    if (farms.length === 0) {
        return (
            <Box
                textAlign="center"
                mt="200px"
                color="green.800"
            >
                <Text fontSize="xl">
                    登録したファームはございません。
                </Text>
            </Box>
        );
    }

    const farmItems = farms.map((farm) => (
        <Box
            key={farm.id}
            p={4}
            w={{ base: "90%", md: "48%", xl: "45%" }}
            mb={5}
            mx={"auto"}
            color={"gray.600"}
        >
            <Image
                src={farm.images?.[0]?.url ?? "https://placehold.co/100x100"}
                alt={farm.name}
                w={{ base: "full" }}
                h={{ base: "200px", sm: "300px", md: "200px", xl: "300px" }}
                objectFit={"cover"}
            />
            <Box
                mt={3}
            >
                <Heading
                    as={"h3"}
                >
                    {farm.name}
                </Heading>
                <Text
                    fontSize={"20px"}
                    mb={1}
                >
                    {farm.state.name}
                </Text>
                {farm.crops.map((crop) => (
                    <Text
                        key={crop.id}
                        display={"inline-block"}
                        p={1}
                        fontSize={"20px"}
                        mr={2}
                    >
                        {crop.name}</Text>
                ))}
            </Box>
            <Flex justifyContent={"space-between"}>
            <Button
                as={Link}
                href={`/farm/${farm.id}`}
                mt={2}
                bg="green.800"
                _hover={{ bg: "green.700", textDecoration: "none" }}
                color="white"
            >
                詳しく見る
            </Button>

            <Button
                as={Link}
                href={`/farm/${farm.id}/edit`}
                mt={2}
                bg="green.800"
                _hover={{ bg: "green.700", textDecoration: "none" }}
                color="white"
            >
                    編集
            </Button>
            </Flex>
        </Box>
    ))

    if (farmItems.length % 2 !== 0) {
        farmItems.push(
            <Box
                key={"dummy"}
                p={4}
                w={{ base: "none", md: "48%", xl: "45%" }}
                mb={5}
                mx={"auto"}
                visibility={"hidden"}
                pointerEvents={"none"}
            ></Box>
        );
    }

    return (
        <Box>
            {/* ファーム一覧 */}
            <Heading as={"h1"} color={"#4D4D4F"} m={5}>登録したファーム一覧</Heading>
            <Flex
                wrap={"wrap"}
                w={{ base: "80%", xl: "1280px" }}
                mx={"auto"}
            >
                {farmItems}
            </Flex>
        </Box >
    );
};

MyFarms.layout = (page: React.ReactNode) => (<MainLayout title="作成済ファーム一覧">{page}</MainLayout>);
export default MyFarms;
