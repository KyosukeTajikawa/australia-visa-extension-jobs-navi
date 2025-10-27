import React, { useState } from "react";
import { Box, Heading, VStack, HStack, Image, Text, Link, Input, Button, Select } from "@chakra-ui/react";
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

type Farm = {
    id: number;
    name: string;
    description: string;
    images: FarmImage[];
    state: []
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
        <Box m={2}>
            <VStack spacing={4} mb={4} align="stretch">
                {/* キーワード入力 */}
                <Input
                    value={searchKeyword}
                    placeholder="検索..."
                    onChange={(e) => setSearchKeyword(e.target.value)}
                />
                <Select
                    value={searchStateName}
                    onChange={(e) => setSearchStateName(e.target.value)}
                    borderColor="gray.300"
                    borderRadius="md"
                    focusBorderColor="green.500"
                    size="md"
                >
                    <option value="">州を選択（任意）</option>
                    {states.map((state) => (
                        <option key={state.id} value={state.name}>
                            {state.name}
                        </option>
                    ))}
                </Select>

                <Button onClick={handleSearch}>検索</Button>
            </VStack>
            {/* ファーム一覧 */}
            <VStack spacing={4} align={"stretch"}>
                {farms.map((farm) => (
                    <Link display={"block"} w={"100%"} key={farm.id} href={`/farm/${farm.id}`} _hover={{ color: "gray.500" }}>
                        <Box p={4} border={"1px solid"} borderColor={"gray.300"} borderRadius={"md"} boxShadow={"md"}>
                            <HStack>
                                <Image src={farm.images?.[0]?.url ?? "https://placehold.co/100x100"} boxSize={"100px"} objectFit={"cover"} alt={farm.name} />
                                <Box flex="1" minW={0}>
                                    <Heading as={"h3"}>{farm.name}</Heading>
                                    <Text>{farm.description}</Text>
                                </Box>
                            </HStack>
                        </Box>
                    </Link>
                ))}
            </VStack>
        </Box >
    );
};

Home.layout = (page: React.ReactNode) => (<MainLayout title="ファーム情報サイト">{page}</MainLayout>);
export default Home;
