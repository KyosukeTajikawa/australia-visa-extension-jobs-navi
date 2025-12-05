import React, { useState, useEffect } from "react";
import {
    Box, Heading, VStack, HStack, Image, Text, Link, Input, Button, Select, Flex, useToast,
    Modal, ModalOverlay, ModalContent, ModalHeader, ModalBody, ModalCloseButton
} from "@chakra-ui/react";
import MainLayout from "@/Layouts/MainLayout";
import { router } from "@inertiajs/react";
import { ArrowForwardIcon } from '@chakra-ui/icons';

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
}

type User = {
    id: number;
    name: string;
    email: string;
};

type PaginateFarm = {
    data: Farm[];
    current_page: number;
    last_page: number;
    next_page_url: string | null;
    prev_page_url: string | null;
}

type HomeProps = {
    farms: PaginateFarm;
    states: States[];
    keyword: string;
    stateName: string;
    status: string;
    auth: {
        user: User | null;
    };
}

const Home = ({ farms, states, keyword, stateName, status, auth }: HomeProps) => {
    const [searchKeyword, setSearchKeyword] = useState(keyword ?? "");
    const [searchStateName, setSearchStateName] = useState(stateName ?? "");
    const toast = useToast()

    const isLoggedIn = !!auth?.user;
    const [isOpen, setIsOpen] = useState(false);
    const onOpen = () => setIsOpen(true);
    const onClose = () => setIsOpen(false);

    useEffect(() => {
        if (status === "delete_success") {
            toast({
                title: 'ユーザー削除成功.',
                position: 'top',
                description: "ユーザーの削除が完了しました。",
                status: 'error',
                duration: 9000,
                isClosable: true,
            })
        }
    }, [status]);

    const handleClickDetail = (farmId: number) => {
        if (!isLoggedIn) {
            onOpen();
            return;
        }

        router.visit(`/farm/${farmId}`);
    };

    const getFarmNameFontSize = (name: string) => {
        if (name.length >= 10) {
            return { base: "30px", xl: "40px" };
        }

        return { base: "40px", xl: "50px" };
    };

    const farmItems = farms.data.map((farm) => (
        <Box
            key={farm.id}
            w={{ base: "100%", sm: "100%", md: "48%", xl: "45%" }}
            mb={5}
            mx={"auto"}
        >
            <Box
                role="group"
                w={{ base: "full" }}
                position={"relative"}
                overflow={"hidden"}
            >
                <Image
                    src={farm.images?.[0]?.url ?? "https://placehold.co/100x100"}
                    alt={farm.name}
                    w={{ base: "full" }}
                    h={{ base: "200px", sm: "300px", md: "200px", xl: "300px" }}
                    objectFit={"cover"}
                />

                {/* PC画面 */}
                <Box
                    display={{ base: "none", md: "block" }}
                    position={"absolute"}
                    left={0}
                    right={0}
                    top={0}
                    inset={0}
                    zIndex={1}
                    opacity={0}
                    bg="#005133"
                    transform={"translateY(100%)"}
                    transition={"transform 0.5s ease"}
                    _groupHover={{ transform: "translateY(0)", opacity: 0.8 }}
                >
                    <Heading
                        fontSize={getFarmNameFontSize(farm.name)}
                        as={"h3"}
                        color={"white"}
                        mx={2}
                    >
                        {farm.name}
                    </Heading>
                    <Text
                        color={"white"}
                        fontSize={{ base: "30px", xl: "40px" }}
                        ml={4}
                    >
                        {farm.state.name}
                    </Text>
                    <Box>
                        {farm.crops.map((crop) => (
                            <Text
                                key={crop.id}
                                display={"inline-block"}
                                color="white"
                                fontSize={{ base: "20px", xl: "35px" }}
                                mx={3}
                            >
                                {crop.name}</Text>
                        ))}
                    </Box>
                    <Button
                        mt={4}
                        fontSize={{ base: "20px", xl: "30px" }}
                        bg={"005133"}
                        _hover={{ opacity: 0.7, textDecoration: "none" }}
                        color="white"
                        onClick={() => handleClickDetail(farm.id)}
                    >
                        詳しく見る
                        <ArrowForwardIcon />
                    </Button>
                </Box>

                {/* SP画面 */}
                <Box
                    mt={3}
                    display={{ base: "block", md: "none" }}
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
                            py={1}
                            fontSize={"20px"}
                            mr={2}
                        >
                            {crop.name}</Text>
                    ))}
                </Box>
                <Button
                    mt={2}
                    fontWeight="normal"
                    bg="green.800"
                    _hover={{ bg: "green.700", textDecoration: "none" }}
                    color="white"
                    display={{ base: "inline-flex", md: "none" }}
                    alignItems="center"
                    justifyContent="center"
                    px={4}
                    py={2}
                    borderRadius="md"
                    w="auto"
                    onClick={() => handleClickDetail(farm.id)}
                >
                    詳しく見る
                </Button>

            </Box>
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

    const handleSearch = () => {
        router.get(route("home"), {
            keyword: searchKeyword,
            stateName: searchStateName,
        });
    }

    return (
        <Box>
            <Box bg={"#fdf9f2"}>
                <Box
                    py={30}
                    mb={5}
                    w={{ base: "90%", sm: "460px", md: "750px", xl: "1000px" }}
                    mx={"auto"}
                >
                    <Heading
                        as={"h1"}
                        color={"green.800"}
                        letterSpacing={4}
                        fontSize={{ base: "28px", md: "50px" }}
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
                            placeholder="ファーム名を検索..."
                            onChange={(e) => setSearchKeyword(e.target.value)}
                        />
                        <HStack>
                            <Select
                                value={searchStateName}
                                onChange={(e) => setSearchStateName(e.target.value)}
                                borderColor="gray.300"
                                borderRadius="md"
                                focusBorderColor="green.500"
                                size="md"
                                mr={5}
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
            {farms.data.length === 0 ? (
                <Box
                    w={{ base: "90%", sm: "460px", md: "750px", xl: "1000px" }}
                    mx="auto"
                    py={10}
                    textAlign="center"
                >
                    <Text fontSize="lg" color="gray.600">
                        検索結果がありません
                    </Text>
                </Box>
            ) : (
                <Flex
                    wrap={"wrap"}
                    w={{ base: "90%", sm: "460px", md: "750px", xl: "1000px" }}
                    mx={"auto"}
                >
                    {farmItems}
                </Flex>
            )}
            <Box
                justifyContent={"center"}
                display={"flex"}
                mb={4}
            >
                {farms.prev_page_url && (
                    <Text
                        as={Link}
                        href={farms.prev_page_url}
                    >
                        前へ
                    </Text>
                )}
                <Text
                    mx={5}
                >
                    {farms.current_page} / {farms.last_page}
                </Text>
                {farms.next_page_url && (
                    <Text
                        as={Link}
                        href={farms.next_page_url}
                    >
                        次へ
                    </Text>
                )}
            </Box>

            {/* ★ 未ログインの時に表示されるポップアップ（モーダル） ★ */}
            {!isLoggedIn && (
                <Modal isOpen={isOpen} onClose={onClose} isCentered>
                    <ModalOverlay />
                    <ModalContent mx={4}>
                        <ModalHeader>無料のユーザー登録をお願いします</ModalHeader>
                        <ModalCloseButton />
                        <ModalBody>
                            <Text mb={4}>
                                詳しく見るには、無料登録またはログインが必要です。
                            </Text>
                            <VStack spacing={3}>
                                <Button
                                    w="100%"
                                    colorScheme="green"
                                    onClick={() => router.visit("/register")}
                                >
                                    無料ユーザー登録
                                </Button>
                                <Button
                                    w="100%"
                                    variant="outline"
                                    colorScheme="green"
                                    onClick={() => router.visit("/login")}
                                    mb={5}
                                >
                                    ログインはこちら &gt;&gt;
                                </Button>
                            </VStack>
                        </ModalBody>
                    </ModalContent>
                </Modal>
            )}
        </Box >
    );
};

Home.layout = (page: React.ReactNode) => (<MainLayout title="ファーム一覧">{page}</MainLayout>);
export default Home;
