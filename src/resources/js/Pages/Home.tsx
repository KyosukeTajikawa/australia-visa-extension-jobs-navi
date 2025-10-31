import React, { useState } from "react";
import { Box, Heading, VStack, HStack, Image, Text, Link, Input, Button, Select, SimpleGrid, Flex } from "@chakra-ui/react";
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

type HomeProps = {
    farms: Farm[];
    states: States[];
    keyword: string;
    stateName: string;
};

const Home = ({ farms, states, keyword, stateName }: HomeProps) => {
    const [searchKeyword, setSearchKeyword] = useState(keyword ?? "");
    const [searchStateName, setSearchStateName] = useState(stateName ?? "");

    const handleSearch = () => {
        router.get(route("home"), {
            keyword: searchKeyword,
            stateName: searchStateName,
        });
    }

    return (
        <Box>
            <Box bg="#FAF7F0">
                <Box
                    px={15}
                    py={30}
                    mb={5}
                    w={"900px"}
                    mx={"auto"}
                >
                    <Heading
                        as={"h1"}
                        color={"green.800"}
                        letterSpacing={4}
                        fontSize={"50px"}
                        mb={1}
                    >
                        オーストラリアの<br />ファームを探そう
                    </Heading>
                    <Text
                        color={"green.800"}
                        fontSize={"20px"}
                        mb={"15px"}
                    >
                        ピザ延長のためのファーム情報サイト
                    </Text>
                    <VStack
                        spacing={4}
                        mb={4}
                        align="stretch"
                    >
                        {/* キーワード入力 */}
                        <Input
                            value={searchKeyword}
                            placeholder="検索..."
                            onChange={(e) => setSearchKeyword(e.target.value)}
                            sx={{
                                '::placeholder': {
                                    color: 'green.800',
                                    opacity: 0.8,
                                },
                                color: 'green.800',
                            }}
                        />
                        <HStack>
                            <Select
                                value={searchStateName}
                                onChange={(e) => setSearchStateName(e.target.value)}
                                borderColor="gray.300"
                                borderRadius="md"
                                focusBorderColor="green.500"
                                size="md"
                                w={"80%"}
                                mr={5}
                                sx={{
                                    '&[data-placeholder]': {
                                        color: 'green.800',
                                    },
                                }}
                            >
                                <option>
                                    州を選択（任意）
                                </option>
                                {states.map((state) => (
                                    <option
                                        key={state.id}
                                        value={state.name}
                                    >
                                        {state.name}
                                    </option>
                                ))}
                            </Select>
                            <Button
                                w={"20%"}
                                onClick={handleSearch}
                                bg={"green.800"}
                                _hover={{ bg: "green.700" }}
                                color={"white"}
                            >検索
                            </Button>
                        </HStack>
                    </VStack>

                </Box>
            </Box>
            {/* ファーム一覧 */}
            <Flex
                wrap={"wrap"}
                justifyContent={"space-between"}
                w={"900px"}
                mx={"auto"}>
                {farms.map((farm) => (
                    <Box
                        key={farm.id}
                        p={4}
                        w={"48%"}
                        mb={5}
                    >
                        <Image
                            src={farm.images?.[0]?.url ?? "https://placehold.co/100x100"}
                            alt={farm.name}
                            w={"full"}
                            h={"200px"}
                            objectFit={"cover"}
                        />
                        <Box
                            mt={3}
                        >
                            <Heading
                                as={"h3"}
                                color={"green.800"}
                            >
                                {farm.name}
                            </Heading>
                            <Text
                                color={"green.800"}
                                fontSize={"20px"}
                                mb={1}
                            >
                                {farm.state.name}
                            </Text>
                            {farm.crops.map((crop) => (
                                <Text
                                    key={crop.id}
                                    display={"inline-block"}
                                    bg="green.50"
                                    color="green.800"
                                    borderColor="green.200"
                                    borderRadius="md"
                                    p={1}
                                    fontSize={"20px"}
                                    mr={2}
                                >
                                    {crop.name}</Text>
                            ))}
                        </Box>
                        <Button
                            as={Link}
                            href={`/farm/${farm.id}`}
                            mt={2}
                            fontWeight={"normal"}
                            bg="green.800"
                            _hover={{ bg: "green.700", textDecoration: "none" }}
                            color="white"
                        >
                            詳しく見る
                        </Button>
                    </Box>
                ))}
            </Flex>
        </Box >
    );
};

Home.layout = (page: React.ReactNode) => (<MainLayout title="ファーム情報サイト">{page}</MainLayout>);
export default Home;
